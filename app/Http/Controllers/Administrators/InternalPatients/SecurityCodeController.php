<?php

namespace App\Http\Controllers\Administrators\InternalPatients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;

use App\Mail\SecurityCodeSent;

use Exception;
use Lang;
use Session;

class SecurityCodeController extends Controller
{
    private const SECURITY_CODE_LENGTH = 10;
    private const DAYS_TO_EXPIRATE_SECURITY_CODE = 10;

    /** @var \App\Contracts\Repository\SecurityCodeRepositoryInterface */
    private $securityCodeRepository;

    public function __construct(SecurityCodeRepositoryInterface $securityCodeRepository) {
        $this->securityCodeRepository = $securityCodeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
   
        $new_security_code = Str::random(self::SECURITY_CODE_LENGTH);

        $date_today = date("Y-m-d");
        $new_expiration_date = date("Y-m-d", strtotime($date_today."+ ".self::DAYS_TO_EXPIRATE_SECURITY_CODE." days"));

        DB::beginTransaction();
        
        try {
            $this->securityCodeRepository->deletePatientSecurityCode($request->internal_patient_id);

            $security_code = $this->securityCodeRepository->create([
                'internal_patient_id' => $request->internal_patient_id,
                'security_code' => Hash::make($new_security_code),
                'expiration_date' => $new_expiration_date,
                'used_at' => null,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        $patient = $security_code->internalPatient;
        
        Mail::to($patient->email)->send(new SecurityCodeSent($patient, $new_security_code, $new_expiration_date));
        
        Session::flash('success', [Lang::get('patients.send_security_code_successfully')]);

        return redirect()->action([InternalPatientController::class, 'edit'], ['id' => $patient->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

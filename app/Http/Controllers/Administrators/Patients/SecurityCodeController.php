<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use App\Laboratory\Prints\SecurityCodes\PrintSecurityCodeContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Contracts\Repository\PatientRepositoryInterface;

use App\Models\SecurityCode;

use Lang;

class SecurityCodeController extends Controller
{
    private const SECURITY_CODE_LENGTH = 10;

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
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
        $patient_id = $request->patient_id;
        $patient = $this->patientRepository->findOrFail($patient_id);

        $new_security_code = Str::random(self::SECURITY_CODE_LENGTH);

        $date_today = date("Y-m-d");
        $expiration_date = date("Y-m-d", strtotime($date_today."+ 1 week"));

        try {

            $security_code = $patient->security_code;

            if (! $security_code) {
                $security_code = new SecurityCode;
                $security_code->patient_id = $patient_id;
            }

            $security_code->security_code = Hash::make($new_security_code);
            $security_code->expiration_date = $expiration_date;
            $security_code->used_at = null;

            // save using transactions
            $security_code->saveOrFail();

            $strategy = 'modern_style';
            $strategyClass = PrintSecurityCodeContext::STRATEGIES[$strategy];

            return (new $strategyClass)->print_security_code($patient, $new_security_code, $expiration_date);
        } catch (\Exception $exception) {

            exit(Lang::get('errors.error_processing_transaction'));
        }
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

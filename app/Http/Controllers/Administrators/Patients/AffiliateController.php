<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\AffiliateRepositoryInterface;

use Lang;

class AffiliateController extends Controller
{
    private const ATTRIBUTES = [
        'patient_id',
        'plan_id', 
        'affiliate_number',
        'expiration_date',
        'security_code',
    ];

    /** @var \App\Contracts\Repository\AffiliateRepositoryInterface */
    private $affiliateRepository;

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository, 
        SocialWorkRepositoryInterface $socialWorkRepository,
        AffiliateRepositoryInterface $affiliateRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->socialWorkRepository = $socialWorkRepository;
        $this->affiliateRepository = $affiliateRepository;
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
    public function create($patient_id)
    {
        //

        return view('administrators/patients/social_works/affiliates/create')
            ->with('patient', $this->patientRepository->findOrFail($patient_id))
            ->with('social_works', $this->socialWorkRepository->all());
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

        $request->validate([
            'affiliate_number' => 'string|nullable',
            'expiration_date' => 'date|nullable',
            'security_code' => 'numeric|nullable|min:0|max:999',
        ]);

        if (! $affiliate = $this->affiliateRepository->create($request->only(self::ATTRIBUTES))) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([PatientController::class, 'edit'], ['id' => $affiliate->patient_id]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        try {
            $affiliate = $this->affiliateRepository->findOrFail($request->id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => Lang::get('errors.not_found')], 404);
        }
        
        return response()->json([
            'id' => $affiliate->id,
            'plan_id' => $affiliate->plan_id,
            'social_work_id' => $affiliate->plan->social_work_id,
            'affiliate_number' => $affiliate->affiliate_number,
            'security_code' => $affiliate->security_code,
            'expiration_date' => $affiliate->expiration_date,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        
        $request->validate([
            'affiliate_number' => 'string|nullable',
            'expiration_date' => 'date|nullable',
            'security_code' => 'numeric|nullable|min:0|max:999',
        ]);
       
        try {
            if (! $this->affiliateRepository->update($request->only(self::ATTRIBUTES), $request->id)) {
                return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $exception) {
            return response()->json(['message' => Lang::get('errors.error_processing_transaction')], 500);
        }

        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        if (! $this->affiliateRepository->delete($request->id)) {
            return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
        }

        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
    }
}
<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Laboratory\Prints\SecurityCodes\PrintSecurityCodeContext;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;
use App\Contracts\Repository\PatientRepositoryInterface;

class SecurityCodeController extends Controller
{
    private const ATTRIBUTES = [
        'patient_id'
    ];

    /** @var \App\Contracts\Repository\SecurityCodeRepositoryInterface */
    private $securityCodeRepository;

    /** @var \App\Laboratory\Prints\SecurityCodes\PrintSecurityCodeContext */
    private $printSecurityCodeContext;

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    public function __construct(
        SecurityCodeRepositoryInterface $securityCodeRepository, 
        PrintSecurityCodeContext $printSecurityCodeContext,
        PatientRepositoryInterface $patientRepository
    ) {
        $this->securityCodeRepository = $securityCodeRepository;
        $this->printSecurityCodeContext = $printSecurityCodeContext;
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
          
            $security_code = $this->securityCodeRepository->create($request->only(self::ATTRIBUTES));
            
            $strategy = 'modern_style';
            $strategyClass = PrintSecurityCodeContext::STRATEGIES[$strategy];
            $this->printSecurityCodeContext->setStrategy(new $strategyClass);
            
            return $this->printSecurityCodeContext->print_security_code($this->patientRepository->findOrFail($request->patient_id), $security_code['security_code'], $security_code['expiration_date']);
       
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

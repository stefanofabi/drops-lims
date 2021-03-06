<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;

use App\Laboratory\Prints\Protocols\Our\PrintProtocolContext;
use App\Laboratory\Prints\Worksheets\PrintWorksheetContext;
use Illuminate\Http\Request;

use App\Laboratory\Repositories\Patients\PatientRepositoryInterface;
use App\Laboratory\Repositories\Protocols\Our\OurProtocolRepositoryInterface;
use App\Laboratory\Repositories\Prescribers\PrescriberRepositoryInterface;
use App\Laboratory\Repositories\BillingPeriods\BillingPeriodRepositoryInterface;

use Lang;

class OurProtocolController extends Controller
{

    /** @var \App\Laboratory\Repositories\Protocols\Our\OurProtocolRepositoryInterface */
    private $ourProtocolRepository;

    /** @var \App\Laboratory\Repositories\Patients\PatientRepositoryInterface */
    private $patientRepository;

    /** @var \App\Laboratory\Repositories\Prescribers\PrescriberRepositoryInterface */
    private $prescriberRepository;

    /** @var \App\Laboratory\Repositories\BillingPeriods\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct (
        OurProtocolRepositoryInterface $ourProtocolRepository, 
        PatientRepositoryInterface $patientRepository, 
        PrescriberRepositoryInterface $prescriberRepository,
        BillingPeriodRepositoryInterface $billingPeriodRepository
    ) {
        $this->ourProtocolRepository = $ourProtocolRepository;
        $this->patientRepository = $patientRepository;
        $this->prescriberRepository = $prescriberRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
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
    public function create(Request $request)
    {
        //
        $patient_id = $request->patient_id;
        

        if ($patient = $this->patientRepository->find($patient_id)) {
            $affiliates = $patient->affiliates;
        } else {
            $affiliates = [];
        }

        $current_date = date('Y-m-d');

        return view('administrators/protocols/our/create')
            ->with('patient', $patient)
            ->with('billing_periods', $this->billingPeriodRepository->getBillingPeriods($current_date))
            ->with('current_billing_period', $this->billingPeriodRepository->getCurrentBillingPeriod());
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
            'completion_date' => 'required|date',
        ]);
        
        if (! $our_protocol = $this->ourProtocolRepository->create(
            [
                'completion_date' => $request->completion_date,
                'observations' => $request->observations,
            ], 
            [
                'plan_id' => $request->plan_id,
                'prescriber_id' => $request->prescriber_id,
                'withdrawal_date' => $request->withdrawal_date,
                'quantity_orders' => $request->quantity_orders,
                'diagnostic' => $request->diagnostic,              
            ])) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([OurProtocolController::class, 'show'], ['id' => $our_protocol->protocol_id]);
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

        $protocol = $this->ourProtocolRepository->findOrFail($id);

        return view('administrators/protocols/our/show')->with('protocol', $protocol);
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

        $protocol = $this->ourProtocolRepository->findOrFail($id);


        return view('administrators/protocols/our/edit')->with('protocol', $protocol);
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

        $request->validate([
            'completion_date' => 'required|date',
            'quantity_orders' => 'required|numeric|min:0',
        ]);

        if (! $this->ourProtocolRepository->update(
            [
                'completion_date' => $request->completion_date,
                'observations' => $request->observations
            ], 
            [
                'plan_id' => $request->plan_id,
                'prescriber_id' => $request->prescriber_id,
                'withdrawal_date' => $request->withdrawal_date,
                'quantity_orders' => $request->quantity_orders,
                'diagnostic' => $request->diagnostic,              
            ], $id)) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        
        return redirect()->action([OurProtocolController::class, 'show'], ['id' => $id]);
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

    /**
     * Returns a list of filtered patients
     *
     * @return \Illuminate\Http\Response
     */
    public function load_patients(Request $request)
    {
        
        return $this->patientRepository->loadPatients($request->filter);
    }

    /**
     * Returns a list of filtered prescribers
     *
     * @return \Illuminate\Http\Response
     */
    public function load_prescribers(Request $request)
    {
        
        return $this->prescriberRepository->loadPrescribers($request->filter);
    }

    /**
     * Returns a view for add practices
     *
     * @return \Illuminate\Http\Response
     */
    public function add_practices($protocol_id)
    {
        $our_protocol = $this->ourProtocolRepository->findOrFail($protocol_id);

        return view('administrators/protocols/our/add_practices')->with('protocol', $our_protocol);
    }

    /**
     * Returns a list of practices for a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public static function get_practices($protocol_id)
    {
        return $this->ourProtocolRepository->getPractices($protocol_id);
    }

    /**
     * Returns a protocol in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_protocol($protocol_id, $filter_practices = [])
    {
        $strategy = 'modern_style';
        $strategyClass = PrintProtocolContext::STRATEGIES[$strategy];

        return (new $strategyClass)->print($protocol_id, $filter_practices);
    }

    /**
     * Returns a worksheet of protocol in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_worksheet($protocol_id, $filter_practices = [])
    {
        $strategy = 'simple_style';
        $strategyClass = PrintWorksheetContext::STRATEGIES[$strategy];

        return (new $strategyClass)->print($protocol_id, $filter_practices);
    }

}

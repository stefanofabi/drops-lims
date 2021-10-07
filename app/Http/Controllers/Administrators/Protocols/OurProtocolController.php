<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\PrescriberRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use App\Laboratory\Prints\Worksheets\PrintWorksheetContext;
use App\Laboratory\Prints\Protocols\Our\PrintOurProtocolContext;

use Lang;

class OurProtocolController extends Controller
{
    private const ATTRIBUTES = [
        'completion_date',
        'observations',
        'type',
        'patient_id',
        'plan_id',
        'prescriber_id',
        'withdrawal_date',
        'quantity_orders',
        'diagnostic',
        'billing_period_id',
    ];

    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    /** @var \App\Contracts\Repository\PrescriberRepositoryInterface */
    private $prescriberRepository;

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    /** @var \App\Laboratory\Prints\Worksheets\PrintWorksheetContext */
    private $printWorksheetContext;

    /** @var \App\Laboratory\Prints\Protocols\Our\PrintOurProtocolContext */
    private $printOurProtocolContext;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository, 
        PatientRepositoryInterface $patientRepository, 
        PrescriberRepositoryInterface $prescriberRepository,
        BillingPeriodRepositoryInterface $billingPeriodRepository,
        PrintWorksheetContext $printWorksheetContext,
        PrintOurProtocolContext $printOurProtocolContext
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->patientRepository = $patientRepository;
        $this->prescriberRepository = $prescriberRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
        $this->printWorksheetContext = $printWorksheetContext;
        $this->printOurProtocolContext = $printOurProtocolContext;
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

        $patient = $this->patientRepository->find($request->patient_id);

        $billing_periods = $this->billingPeriodRepository->getBillingPeriods();
        
        $current_billing_period = $this->billingPeriodRepository->getCurrentBillingPeriod();

        return view('administrators/protocols/our/create')
            ->with('patient', $patient)
            ->with('billing_periods', $billing_periods)
            ->with('current_billing_period', $current_billing_period);
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
            'patient_id' => 'required|numeric|min:1',
            'plan_id' => 'required|numeric|min:1',
            'prescriber_id' => 'required|numeric|min:1',
            'billing_period_id' => 'required|numeric|min:1',
            'quantity_orders' => 'required|numeric|min:0',
        ]);

        if (! $protocol = $this->protocolRepository->create($request->only(self::ATTRIBUTES))) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([OurProtocolController::class, 'show'], ['id' => $protocol->id]);
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

        $protocol = $this->protocolRepository->findOrFail($id);

        $billing_periods = $this->billingPeriodRepository->getBillingPeriods();

        return view('administrators/protocols/our/edit')
            ->with('protocol', $protocol)
            ->with('billing_periods', $billing_periods);
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
            'plan_id' => 'required|numeric|min:1',
            'prescriber_id' => 'required|numeric|min:1',
            'quantity_orders' => 'required|numeric|min:0',
        ]);
        
        if (! $this->protocolRepository->update($request->only(self::ATTRIBUTES), $id)) {
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
     * Returns a view for add practices
     *
     * @return \Illuminate\Http\Response
     */
    public function add_practices($protocol_id)
    {
        $protocol = $this->protocolRepository->findOrFail($protocol_id);

        return view('administrators/protocols/our/add_practices')->with('protocol', $protocol);
    }

    /**
     * Returns a list of practices for a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public static function get_practices($protocol_id)
    {
        return $this->protocolRepository->getPractices($protocol_id);
    }

    /**
     * Returns a protocol in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_protocol($protocol_id, $filter_practices = [])
    {
        $strategy = 'modern_style';
        $strategyClass = PrintOurProtocolContext::STRATEGIES[$strategy];

        $this->printOurProtocolContext->setStrategy(new $strategyClass);

        return $this->printOurProtocolContext->printProtocol($protocol_id, $filter_practices);
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

        $this->printWorksheetContext->setStrategy(new $strategyClass);
        
        return $this->printWorksheetContext->printWorksheet($protocol_id, $filter_practices);
    }

}

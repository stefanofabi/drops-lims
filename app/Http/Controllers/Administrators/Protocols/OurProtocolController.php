<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\PrescriberRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;
use App\Contracts\Repository\PracticeRepositoryInterface;

use App\Laboratory\Prints\Worksheets\PrintWorksheetContext;
use App\Laboratory\Prints\Protocols\Our\PrintOurProtocolContext;

use App\Mail\ProtocolSent;

use Lang;
use Session;

class OurProtocolController extends Controller
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;

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
        PracticeRepositoryInterface $practiceRepository, 
        PatientRepositoryInterface $patientRepository, 
        PrescriberRepositoryInterface $prescriberRepository,
        BillingPeriodRepositoryInterface $billingPeriodRepository,
        PrintWorksheetContext $printWorksheetContext,
        PrintOurProtocolContext $printOurProtocolContext
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->practiceRepository = $practiceRepository;
        $this->patientRepository = $patientRepository;
        $this->prescriberRepository = $prescriberRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
        $this->printWorksheetContext = $printWorksheetContext;
        $this->printOurProtocolContext = $printOurProtocolContext;
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
            'quantity_orders' => 'required|numeric|min:0',
            'patient_id' => 'required|numeric|min:1',
            'plan_id' => 'required|numeric|min:1',
            'prescriber_id' => 'required|numeric|min:1',
            'type' => 'required|in:our',
        ]);

        if (! $protocol = $this->protocolRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([OurProtocolController::class, 'edit'], ['id' => $protocol->id]);
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
            'quantity_orders' => 'required|numeric|min:0',
            'patient_id' => 'required|numeric|min:1',
            'plan_id' => 'required|numeric|min:1',
            'prescriber_id' => 'required|numeric|min:1',
            'type' => 'required|in:our',
        ]);
        
        if (! $this->protocolRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([OurProtocolController::class, 'edit'], ['id' => $id]);
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
     * Returns a protocol in pdf
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function printProtocol(Request $request, $id)
    {
        $protocol = $this->protocolRepository->findOrFail($id);

        $strategy = 'modern_style';
        $strategyClass = PrintOurProtocolContext::STRATEGIES[$strategy];

        $this->printOurProtocolContext->setStrategy(new $strategyClass($protocol, $request->filter_practices));

        return $this->printOurProtocolContext->print();
    }

    /**
     * Returns a protocol partially in pdf format
     *
     * @return \Illuminate\Http\Response
     */
    public function printPartialReport(Request $request)
    {
        $protocol = $this->practiceRepository->findOrFail($request->id)->protocol;

        $strategy = 'modern_style';
        $strategyClass = PrintOurProtocolContext::STRATEGIES[$strategy];

        $this->printOurProtocolContext->setStrategy(new $strategyClass($protocol, $request->filter_practices));

        return $this->printOurProtocolContext->print();
    }

    /**
     * Returns a worksheet of protocol in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function printWorksheet($protocol_id, $filter_practices = [])
    {
        $strategy = 'simple_style';
        $strategyClass = PrintWorksheetContext::STRATEGIES[$strategy];

        $this->printWorksheetContext->setStrategy(new $strategyClass);
        
        return $this->printWorksheetContext->printWorksheet($protocol_id, $filter_practices);
    }

    public function closeProtocol($id)
    {
        if (! $this->protocolRepository->closeProtocol($id))
        {
            return redirect()->back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('protocols.protocol_closed_successfully')]);

        return redirect()->action([OurProtocolController::class, 'edit'], ['id' => $id]);
    }

    public function sendProtocolToEmail($id)
    {
        $protocol = $this->protocolRepository->findOrFail($id);

        $this->printProtocol($protocol->id);

        Mail::to($protocol->patient->email)->send(new ProtocolSent($protocol));

        Session::flash('success', [Lang::get('protocols.send_protocol_email_successfully')]);

        return redirect()->action([OurProtocolController::class, 'edit'], ['id' => $id]);
    }
}
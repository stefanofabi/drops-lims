<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\PrescriberRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;
use App\Contracts\Repository\PracticeRepositoryInterface;

use App\Laboratory\Prints\Worksheets\PrintWorksheetContext;
use App\Laboratory\Prints\Protocols\PrintProtocolContext;

use App\Mail\ProtocolSent;

use Lang;
use Session;

class ProtocolController extends Controller
{
    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

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

    /** @var \App\Laboratory\Prints\Protocols\Our\PrintProtocolContext */
    private $printProtocolContext;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository,
        PracticeRepositoryInterface $practiceRepository, 
        PatientRepositoryInterface $patientRepository, 
        PrescriberRepositoryInterface $prescriberRepository,
        BillingPeriodRepositoryInterface $billingPeriodRepository,
        PrintWorksheetContext $printWorksheetContext,
        PrintProtocolContext $printProtocolContext
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->practiceRepository = $practiceRepository;
        $this->patientRepository = $patientRepository;
        $this->prescriberRepository = $prescriberRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
        $this->printWorksheetContext = $printWorksheetContext;
        $this->printProtocolContext = $printProtocolContext;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $request->validate([
            'filter' => 'string|nullable',
            'page' => 'required|numeric|min:1',
        ]);
        
        $protocols = $this->protocolRepository->index($request->filter);

        // Pagination
        $count_rows = $protocols->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($request->page, $total_pages, self::ADJACENTS);
        
        if ($total_pages < $request->page) 
        {
            $offset = 0;
            $request->page = 1;
        } else 
        {
            $offset = ($request->page - 1) * self::PER_PAGE;
        }

        return view('administrators/protocols/index')
            ->with('data', $request->all())
            ->with('protocols', $protocols->skip($offset)->take(self::PER_PAGE))
            ->with('paginate', $paginate);
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

        return view('administrators/protocols/create')
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
        
        return redirect()->action([ProtocolController::class, 'edit'], ['id' => $protocol->id]);
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

        return view('administrators/protocols/edit')
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

        return redirect()->action([ProtocolController::class, 'edit'], ['id' => $id]);
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
        $strategyClass = PrintProtocolContext::STRATEGIES[$strategy];

        $this->printProtocolContext->setStrategy(new $strategyClass($protocol, $request->filter_practices));

        return $this->printProtocolContext->print();
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

        return redirect()->action([ProtocolController::class, 'edit'], ['id' => $id]);
    }

    public function sendProtocolToEmail(Request $request, $id)
    {
        $protocol = $this->protocolRepository->findOrFail($id);

        $strategy = 'modern_style';
        $strategyClass = PrintProtocolContext::STRATEGIES[$strategy];

        $this->printProtocolContext->setStrategy(new $strategyClass($protocol));

        $this->printProtocolContext->print();

        Mail::to($protocol->patient->email)->send(new ProtocolSent($protocol, $request->filter_practices));

        Session::flash('success', [Lang::get('protocols.send_protocol_email_successfully')]);

        return redirect()->action([ProtocolController::class, 'edit'], ['id' => $id]);
    }
}
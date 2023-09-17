<?php

namespace App\Http\Controllers\Administrators\InternalProtocols;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\InternalPatientRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use App\Mail\InternalProtocolSent;

use Lang;
use Session;
use PDF;

class InternalProtocolController extends Controller
{
    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    private const INTERNAL_PROTOCOLS_DIRECTORY = "app/internal_protocols/";

    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\InternalPatientRepositoryInterface */
    private $internalPatientRepository;

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct (
        InternalProtocolRepositoryInterface $internalProtocolRepository,
        InternalPatientRepositoryInterface $internalPatientRepository, 
        BillingPeriodRepositoryInterface $billingPeriodRepository
    ) {
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->internalPatientRepository = $internalPatientRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $request->validate([
            'filter' => 'string|nullable',
            'page' => 'required|numeric|min:1',
        ]);
        
        $protocols = $this->internalProtocolRepository->index($request->filter);

        // Pagination
        $page = $request->page;
        $count_rows = $protocols->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);
        
        if ($total_pages < $page) 
        {
            $offset = 0;
            $page = 1;
        } else 
        {
            $offset = ($page - 1) * self::PER_PAGE;
        }

        return view('administrators.internal_protocols.index')
            ->with('filter', $request->filter)
            ->with('protocols', $protocols->skip($offset)->take(self::PER_PAGE))
            ->with('paginate', $paginate)
            ->with('page', $page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        $patient = $this->internalPatientRepository->find($request->internal_patient_id);
        
        $current_billing_period = $this->billingPeriodRepository->getCurrentBillingPeriod();

        return view('administrators.internal_protocols.create')
            ->with('patient', $patient)
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
        ]);
        
        if (! $protocol = $this->internalProtocolRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([InternalProtocolController::class, 'edit'], ['id' => $protocol->id]);
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

        $protocol = $this->internalProtocolRepository->findOrFail($id);

        return view('administrators.internal_protocols.edit')
            ->with('protocol', $protocol);
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
        
        if (! $this->internalProtocolRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([InternalProtocolController::class, 'edit'], ['id' => $id]);
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

        if (! $this->internalProtocolRepository->delete($id)) 
        {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        Session::flash('success', [Lang::get('protocols.success_destroy_message')]);

        return redirect()->action([InternalProtocolController::class, 'index'], ['page' => 1]);
    }

    /**
     * Returns a protocol in pdf
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function generateProtocol(Request $request, $id)
    {
        $request->validate([
            'filter_practices' => 'array|nullable',
        ]);

        $protocol = $this->internalProtocolRepository->findOrFail($id);

        $practices = $protocol->internalPractices;

        if (! empty($request->filter_practices)) 
        {
            $practices = $practices->whereIn('id', $request->filter_practices);
        }

        $practices = $practices->sortBy(['determination.position', 'ASC']);

        $pdf = PDF::loadView('pdf.internal_protocols.modern_style', [
            'protocol' => $protocol,
            'practices' => $practices
        ]);
        
        $protocol_path = storage_path(self::INTERNAL_PROTOCOLS_DIRECTORY."protocol_$protocol->id.pdf");
        $pdf->save($protocol_path);
       
        return $pdf->stream("protocol_$protocol->id");
    }

    /**
     * Returns a worksheet of protocol in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function generateWorksheet($id)
    {
        $protocol = $this->internalProtocolRepository->findOrFail($id);

        $pdf = PDF::loadView('pdf.worksheets.simple_style', [
            'protocol' => $protocol,
        ]);

        return $pdf->stream('worksheet_'.$protocol->id.'.pdf');
    }

    /**
     * Close a protocol so that it is never modified
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function closeProtocol($id)
    {
        if (! $this->internalProtocolRepository->close($id))
        {
            return redirect()->back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('protocols.protocol_closed_successfully')]);

        return redirect()->action([InternalProtocolController::class, 'edit'], ['id' => $id]);
    }

    /**
     * Send a pdf protocol to email patient
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sendProtocolToEmail(Request $request, $id)
    {
        $request->validate([
            'filter_practices' => 'array|nullable',
        ]);

        $protocol = $this->internalProtocolRepository->findOrFail($id);

        $practices = $protocol->internalPractices;

        if (! empty($request->filter_practices)) 
        {
            $practices = $practices->whereIn('id', $request->filter_practices);
        }

        $practices = $practices->sortBy(['determination.position', 'ASC']);

        $pdf = PDF::loadView('pdf.internal_protocols.modern_style', [
            'protocol' => $protocol,
            'practices' => $practices
        ]);

        $protocol_path = storage_path(self::INTERNAL_PROTOCOLS_DIRECTORY."protocol_$protocol->id.pdf");
        $pdf->save($protocol_path);

        Mail::to($protocol->internalPatient->email)->send(new InternalProtocolSent($protocol, $practices));

        Session::flash('success', [Lang::get('protocols.send_protocol_email_successfully')]);

        return redirect()->action([InternalProtocolController::class, 'edit'], ['id' => $id]);
    }
}
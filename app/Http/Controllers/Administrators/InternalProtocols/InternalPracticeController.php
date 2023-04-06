<?php

namespace App\Http\Controllers\Administrators\InternalProtocols;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;
use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\SignInternalPracticeRepositoryInterface;
use App\Contracts\Repository\DeterminationRepositoryInterface;

use Lang;
use Session;

class InternalPracticeController extends Controller
{

    /** @var \App\Contracts\Repository\InternalPracticeRepositoryInterface */
    private $internalPracticeRepository;

    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\SignInternalPracticeRepositoryInterface */
    private $signInternalPracticeRepository;

    /** @var \App\Contracts\Repository\DeterminationRepositoryInterface */
    private $determinationRepository;

    public function __construct (
        InternalPracticeRepositoryInterface $internalPracticeRepository,
        InternalProtocolRepositoryInterface $internalProtocolRepository,
        SignInternalPracticeRepositoryInterface $signInternalPracticeRepository,
        DeterminationRepositoryInterface $determinationRepository
    ) {
        $this->internalPracticeRepository = $internalPracticeRepository;
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->signInternalPracticeRepository = $signInternalPracticeRepository;
        $this->determinationRepository = $determinationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $protocol = $this->internalProtocolRepository->findOrFail($request->internal_protocol_id);
        
        return view('administrators.internal_protocols.internal_practices.index')
            ->with('protocol', $protocol);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
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

        $request->validate([
            'price' => 'required|numeric',
        ]);

        DB::transaction(function () {
            $this->internalPracticeRepository->create($request->all());

            $this->internalProtocolRepository->increment($request->internal_protocol_id, 'total_price', $request->price);
        });

        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
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

        $practice = $this->internalPracticeRepository->findOrFail($id);

        return view('administrators.internal_protocols.internal_practices.edit')
            ->with('practice', $practice);
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

        $practice = $this->internalPracticeRepository->findOrFail($id);

        DB::transaction(function () use ($practice) {
            $this->internalPracticeRepository->delete($id);
         
            $this->internalProtocolRepository->decrement($practice->internal_protocol_id, 'total_price', $practice->price);
        });

        return redirect()->action([InternalPracticeController::class, 'index'], ['internal_protocol_id' => $practice->internal_protocol_id]);
    }

    /**
     * Returns a list of determinations according to the nomenclator of social work
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function loadPractices(Request $request)
    {
        //

        $request->validate([
            'nomenclator_id' => 'required|numeric|min:1',
            'filter' => 'required|string|min:2'
        ]);
        
        return $this->determinationRepository->getDeterminationsFromNomenclator($request->nomenclator_id, $request->filter);
    }

    /**
     * Returns the results for a practice
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getResult($id)
    {
        //
        
        $practice = $this->internalPracticeRepository->findOrFail($id);
        
        return response()->json($practice->result, 200);
    }

    /**
     * Inform the results of a practice
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function informResult(Request $request, $id)
    {
        $practice = $this->internalPracticeRepository->findOrFail($id);

        DB::transaction(function () {
            $this->signInternalPracticeRepository->deleteAllSignatures($id);
            
            // AJAX dont send empty arrays
            if (is_array($request->result)) 
            {
                $this->internalPracticeRepository->saveResult($request->result, $id);
            }
        });

        Session::flash('success', [Lang::get('forms.successful_transaction')]);

        if ($request->boolean('stay_on_this_page')) {
            return redirect()->action([InternalPracticeController::class, 'edit'], ['id' => $practice->id]); 
        }

        return redirect()->action([InternalPracticeController::class, 'index'], ['internal_protocol_id' => $practice->internal_protocol_id]);
    }

    /**
     * Sign the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sign(Request $request, $id)
    {
        //

        $practice = $this->internalPracticeRepository->findOrFail($id);

        DB::transaction(function () use ($practice) {
            $this->signInternalPracticeRepository->create([
                'internal_practice_id' => $practice->id, 
                'user_id' => auth()->user()->id
            ]);
        });

        Session::flash('success', [Lang::get('practices.success_signed')]);

        return redirect()->action([InternalPracticeController::class, 'index'], ['internal_protocol_id' => $practice->internal_protocol_id]);   
    }
}

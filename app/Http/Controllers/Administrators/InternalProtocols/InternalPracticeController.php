<?php

namespace App\Http\Controllers\Administrators\InternalProtocols;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;
use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\SignInternalPracticeRepositoryInterface;
use App\Contracts\Repository\DeterminationRepositoryInterface;

use Lang;
use Throwable;

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
    public function index()
    {
        //

        
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

        $protocol = $this->internalProtocolRepository->findOrFail($request->internal_protocol_id);
        
        return view('administrators.internal_protocols.internal_practices.create')
            ->with('protocol', $protocol);
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

        try  {

            $protocol = $this->internalProtocolRepository->findOrFail($request->internal_protocol_id);

            $determination = $this->determinationRepository->findOrFail($request->determination_id);
            
            if (! $this->internalPracticeRepository->create([
                'determination_id' => $determination->id,
                'internal_protocol_id' => $protocol->id,
                'price' => $determination->getPrice($protocol->plan->nbu_price),
            ])) {
                return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => Lang::get('errors.not_found')], 404);
        } catch (QueryException $exception) {
            return response()->json(['message' => Lang::get('errors.error_processing_transaction')], 500);
        }
        
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
     * Sign the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sign(Request $request, $id)
    {
        //
        
        try {
            if (! $this->signInternalPracticeRepository->create(['internal_practice_id' => $id, 'user_id' => auth()->user()->id])) {
                return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $exception) {
            // the user had already signed the practice

            return response()->json(['message' => Lang::get('practices.already_signed')], 200);
        }

        return response()->json(['message' => Lang::get('practices.success_signed')], 200);
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
        
        $protocol = $this->internalPracticeRepository->findOrFail($id)->internalProtocol;

        if (! $this->internalPracticeRepository->delete($id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([InternalPracticeController::class, 'create'], ['internal_protocol_id' => $protocol->id]);
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
            'filter' => 'required|string|min:2',
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
       
        return $practice->result;
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
        DB::beginTransaction();
        
        try {
            $this->signInternalPracticeRepository->deleteAllSignatures($id);
            
            // AJAX dont send empty arrays
            if (is_array($request->data)) {
                $this->internalPracticeRepository->update(['result' => json_encode($request->data)], $id);
            }

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();

            return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
        }

        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
    }
}

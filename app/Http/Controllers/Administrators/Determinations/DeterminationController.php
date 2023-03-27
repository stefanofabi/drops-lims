<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\DeterminationRepositoryInterface;
use App\Contracts\Repository\NomenclatorRepositoryInterface;

use Lang;
use Session;

class DeterminationController extends Controller
{
    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Contracts\Repository\DeterminationRepositoryInterface */
    private $determinationRepository;

    /** @var \App\Contracts\Repository\NomenclatorRepositoryInterface */
    private $nomenclatorRepository;

    public function __construct(DeterminationRepositoryInterface $determinationRepository, NomenclatorRepositoryInterface $nomenclatorRepository) 
    {
        $this->determinationRepository = $determinationRepository;
        $this->nomenclatorRepository = $nomenclatorRepository;
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

        $determinations = $this->determinationRepository->index($request->filter, $request->nomenclator_id);

        // Pagination
        $page = $request->page;
        $count_rows = $determinations->count();
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

        return view('administrators/determinations/index')
            ->with('nomenclator', $request->nomenclator_id)
            ->with('filter', $request->filter)
            ->with('determinations', $determinations->skip($offset)->take(self::PER_PAGE))
            ->with('nomenclators', $this->nomenclatorRepository->all())
            ->with('paginate', $paginate)
            ->with('page', $page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nomenclators = $this->nomenclatorRepository->all();

        return view('administrators/determinations/create')->with('nomenclators', $nomenclators);
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
            'code' => 'required|numeric|min:0',
            'name' => 'required|string|min:2',
            'position' => 'required|numeric|min:1',
            'javascript' => 'string|nullable|max:1000',
            'report' => 'string|nullable|max:2000',
            'biochemical_unit' => 'required|numeric|min:0',
        ]);

        if (! $determination = $this->determinationRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
       
        return redirect()->action([DeterminationController::class, 'edit'], ['id' => $determination->id]);
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
        
        $determination = $this->determinationRepository->findOrFail($id);

        return view('administrators/determinations/edit')
            ->with('determination', $determination);
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
            'code' => 'required|numeric|min:0',
            'name' => 'required|string|min:2',
            'position' => 'required|numeric|min:1',
            'biochemical_unit' => 'required|numeric|min:0',
        ]);
        
        if (! $this->determinationRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([DeterminationController::class, 'edit'], ['id' => $id]);
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

        $nomenclator_id = $this->determinationRepository->findOrFail($id)->nomenclator_id;

        if (! $this->determinationRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('determinations.success_destroy_message')]);

        return redirect()->action([DeterminationController::class, 'index'], ['nomenclator_id' => $nomenclator_id, 'page' => 1]);
    }
}
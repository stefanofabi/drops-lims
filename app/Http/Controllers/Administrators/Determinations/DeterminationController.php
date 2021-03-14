<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\DeterminationRepositoryInterface;
use App\Contracts\Repository\NomenclatorRepositoryInterface;

use Lang;

class DeterminationController extends Controller
{
    private const ATTRIBUTES = [
        'nomenclator_id',
        'code',
        'name',
        'position',
        'biochemical_unit',
    ];

    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Contracts\Repository\DeterminationRepositoryInterface */
    private $determinationRepository;

    /** @var \App\Contracts\Repository\NomenclatorRepositoryInterface */
    private $nomenclatorRepository;

    public function __construct(
        DeterminationRepositoryInterface $determinationRepository, 
        NomenclatorRepositoryInterface $nomenclatorRepository
    ) {
        $this->determinationRepository = $determinationRepository;
        $this->nomenclatorRepository = $nomenclatorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nomenclators = $this->nomenclatorRepository->all();

        return view('administrators/determinations/determinations')->with('nomenclators', $nomenclators);
    }

    /**
     * Load determinations
     *
     * @param \Illuminate\Http\Request $request
     * @return View $view
     */
    public function load(Request $request)
    {

        $offset = ($request->page - 1) * self::PER_PAGE;

        $determinations = $this->determinationRepository->index($request->nomenclator, $request->filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = $determinations->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($request->page, $total_pages, self::ADJACENTS);

        $nomenclators = $this->nomenclatorRepository->all();

        return view('administrators/determinations/index')
            ->with('request', $request)
            ->with('determinations', $determinations)
            ->with('paginate', $paginate)
            ->with('nomenclators', $nomenclators);
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
            'name' => 'required|string',
            'position' => 'required|numeric|min:1',
            'biochemical_unit' => 'required|numeric|min:0',
        ]);

        if (! $determination = $this->determinationRepository->create($request->only(self::ATTRIBUTES))) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
    
        return redirect()->action([DeterminationController::class, 'show'], ['id' => $determination->id]);
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

        $determination = $this->determinationRepository->findOrFail($id);

        return view('administrators/determinations/show')->with('determination', $determination);
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

        return view('administrators/determinations/edit')->with('determination', $determination);
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
            'name' => 'required|string',
            'position' => 'required|numeric|min:1',
            'biochemical_unit' => 'required|numeric|min:0',
        ]);

        if (!$this->determinationRepository->update($request->only(self::ATTRIBUTES), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([DeterminationController::class, 'show'], ['id' => $id]);
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

        if (!$this->determinationRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        $nomenclators = $this->nomenclatorRepository->all();

        return view('administrators/determinations/determinations')
            ->with('success', [Lang::get('determinations.success_destroy_message')])
            ->with('nomenclators', $nomenclators);
    }
}

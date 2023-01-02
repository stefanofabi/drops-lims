<?php

namespace App\Http\Controllers\Administrators\Prescribers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\PrescriberRepositoryInterface;

use Lang;
use Session;

class PrescriberController extends Controller
{
    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Contracts\Repository\PrescriberRepositoryInterface */
    private $prescriberRepository;

    public function __construct(PrescriberRepositoryInterface $prescriberRepository)
    {
        $this->prescriberRepository = $prescriberRepository;
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

        $prescribers = $this->prescriberRepository->index($request->filter);

        // Pagination
        $page = $request->page;
        $count_rows = $prescribers->count();
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

        return view('administrators/prescribers/index')
            ->with('filter', $request->filter)
            ->with('prescribers', $prescribers->skip($offset)->take(self::PER_PAGE))
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

        return view('administrators/prescribers/create');
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
            'name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'email' => 'email|nullable',
        ]);

        if (! $prescriber = $this->prescriberRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([PrescriberController::class, 'edit'], ['id' => $prescriber->id]);
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
        $prescriber = $this->prescriberRepository->findOrFail($id);

        return view('administrators/prescribers/edit')
            ->with('prescriber', $prescriber);
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
            'name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'email' => 'email|nullable',
        ]);
        
        if (! $this->prescriberRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([PrescriberController::class, 'edit'], ['id' => $id]);
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

        if (! $this->prescriberRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('prescribers.success_destroy_message')]);

        return redirect()->action([PrescriberController::class, 'index'], ['page' => 1]);
    }

    /**
     * Returns a list of filtered prescribers
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function loadPrescribers(Request $request)
    {
        
        $request->validate([
            'filter' => 'required|string|min:2'
        ]);

    return $this->prescriberRepository->loadPrescribers($request->filter);
    }
}

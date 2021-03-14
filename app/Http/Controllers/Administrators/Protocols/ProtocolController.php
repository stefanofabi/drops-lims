<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\ProtocolRepositoryInterface;

class ProtocolController extends Controller
{
    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository
    ) {
        $this->protocolRepository = $protocolRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('administrators/protocols/protocols');
    }

    /**
     * Load protocols
     *
     * @param \Illuminate\Http\Request $request
     * @return View $view
     */
    public function load(Request $request)
    {
        $request->validate([
            'filter' => 'string|nullable',
            'page' => 'required|numeric|min:1',
        ]);

        // Request
        $filter = $request->filter;
        $page = $request->page;

        $offset = ($page - 1) * self::PER_PAGE;
        $protocols = $this->protocolRepository->index($filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = $protocols->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);
        
        return view('administrators/protocols/index')
            ->with('request', $request->all())
            ->with('protocols', $protocols)
            ->with('paginate', $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('administrators/protocols/create');
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
    }
}

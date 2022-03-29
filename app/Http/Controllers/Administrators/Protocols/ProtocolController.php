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

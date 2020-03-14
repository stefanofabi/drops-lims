<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Protocol;
use App\Patient;

class ProtocolController extends Controller
{

    use Pagination;

    private const PER_PAGE = 15;
    private const ADJACENTS = 4;

    private const RETRIES = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('protocols/protocols');
    }

    /**
    * Load protocols
    * @param   \Illuminate\Http\Request  $request
    * @return View $view
    */
    public function load(Request $request) {

        // Request
        $filter = $request['filter'];
        $page = $request['page'];

        $offset = ($page - 1) * self::PER_PAGE;
        $query = Protocol::index($filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = Protocol::count_index($filter);
        $total_pages = ceil($count_rows / self::PER_PAGE);

        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

        $view = view('protocols/index')
        ->with('request', $request->all())
        ->with('protocols', $query)
        ->with('paginate', $paginate);

        return $view;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Returns a list of filtered patients
     *
     * @return \Illuminate\Http\Response
     */
    public function load_patients(Request $request)
    {
        // label column is required
        $filter = $request->filter;

        $social_works = Patient::select('full_name as label', 'id')->where("full_name", "like", "%$filter%")->get()->toJson();

        return $social_works;
    }


    /**
     * Returns a list of a patient's social works
     *
     * @return \Illuminate\Http\Response
     */
    public function load_social_works(Request $request)
    {
        // label column is required
        $filter = $request->filter;

        $social_works = Patient::select('full_name as label', 'id')->where("full_name", "like", "%$filter%")->get()->toJson();

        return $social_works;
    }
}

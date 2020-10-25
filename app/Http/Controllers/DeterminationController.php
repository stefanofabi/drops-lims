<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Models\Nomenclator;
use App\Models\Determination;

class DeterminationController extends Controller
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
    	$nomenclators = Nomenclator::all();
    	
    	return view('administrators/determinations/determinations')->with('nomenclators', $nomenclators);
    }


    /**
    * Load determinations
    * @param   \Illuminate\Http\Request  $request
    * @return View $view
    */
    public function load(Request $request) {

        // Request
    	$filter = $request['filter'];
    	$page = $request['page'];
    	$nomenclator = $request['nomenclator'];

    	$offset = ($page - 1) * self::PER_PAGE;
    	$query = Determination::index($nomenclator, $filter, $offset, self::PER_PAGE);

        // Pagination
    	$count_rows = Determination::count_index($nomenclator, $filter);
    	$total_pages = ceil($count_rows / self::PER_PAGE);

    	$paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

    	$nomenclators = Nomenclator::all();

    	$view = view('administrators/determinations/index')
    	->with('request', $request->all())
    	->with('determinations', $query)
    	->with('paginate', $paginate)
    	->with('nomenclators', $nomenclators);

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
    	$nomenclators = Nomenclator::all();

    	return view('administrators/determinations/create')->with('nomenclators', $nomenclators);
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
    	$id = DB::transaction(function () use ($request) {

            // data for determinations
            $code = $request['code'];
            $name = $request['name'];
            $nomenclator = $request['nomenclator'];
            $position = $request['position'];
            $biochemical_unit = $request['biochemical_unit'];

            $determination = Determination::insertGetId([
               'code' => $code,
               'name' => $name, 
               'nomenclator_id' => $nomenclator,
               'position' => $position,
               'biochemical_unit' => $biochemical_unit,
           ]);

            return $determination;
        }, self::RETRIES);


    	return redirect()->action('DeterminationController@show', ['id' => $id]);
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

        $determination = Determination::findOrFail($id);
        $nomenclator = $determination->nomenclator;

        $reports = Determination::get_reports($id);

        return view('administrators/determinations/show')
        ->with('determination', $determination)
        ->with('nomenclator', $nomenclator)
        ->with('reports', $reports);
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
        $determination = Determination::findOrFail($id);
        $nomenclator = $determination->nomenclator;

        $reports = Determination::get_reports($id);

        return view('administrators/determinations/edit')
        ->with('determination', $determination)
        ->with('nomenclator', $nomenclator)
        ->with('reports', $reports);
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
        DB::transaction(function () use ($request, $id) {


         Determination::where('id', '=', $id)
         ->update(
             [
                'code' => $request->code,
                'name' => $request->name,
                'position' => $request->position,
                'biochemical_unit' => $request->biochemical_unit,
            ]);
        }, self::RETRIES);


        return redirect()->action('DeterminationController@show', ['id' => $id]);
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
}
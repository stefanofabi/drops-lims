<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Nomenclator;
use App\Determination;

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
    	
    	return view('determinations/determinations')->with('nomenclators', $nomenclators);
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

    	$view = view('determinations/index')
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

    	return view('determinations/create')->with('nomenclators', $nomenclators);
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

        $determination = Determination::find($id);
        $nomenclator = $determination->nomenclator;

        $data = [
            'id' => $determination->id,
            'nomenclator' => $nomenclator->name,
            'code' => $determination->code,
            'name' => $determination->name,
            'position' => $determination->position,
            'biochemical_unit' => $determination->biochemical_unit,
        ];


        return view('determinations/show')->with('determination', $data);
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
        $determination = Determination::find($id);
        $nomenclator = $determination->nomenclator;

        $data = [
            'nomenclator' => $nomenclator->name,
            'id' => $determination->id,
            'code' => $determination->code,
            'name' => $determination->name,
            'position' => $determination->position,
            'biochemical_unit' => $determination->biochemical_unit,
        ];

        $nomenclators = Nomenclator::all();

        return view('determinations/edit')
        ->with('determination', $data)
        ->with('nomenclators', $nomenclators);
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
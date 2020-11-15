<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Pagination;

use App\Models\Nomenclator;
use App\Models\Determination;

use Lang; 

class DeterminationController extends Controller
{

	use Pagination;

	private const PER_PAGE = 15;
	private const ADJACENTS = 4;

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

    	$offset = ($request->page - 1) * self::PER_PAGE;

    	$query = Determination::index($request->nomenclator, $request->filter, $offset, self::PER_PAGE);

        // Pagination
    	$count_rows = Determination::count_index($request->nomenclator, $request->filter);
    	$total_pages = ceil($count_rows / self::PER_PAGE);

    	$paginate = $this->paginate($request->page, $total_pages, self::ADJACENTS);

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

		$request->validate([
            'nomenclator_id' => 'required|numeric|min:1',
            'code' => 'required|numeric|min:0',
            'name' => 'required|string',
            'position' => 'required|numeric|min:1',
            'biochemical_unit' => 'required|numeric|min:0',
        ]);

        $determination = new Determination($request->all());

        if ($determination->save()) {
        	$redirect = redirect()->action('DeterminationController@show', $determination->id);
        } else {
        	$redirect = back()->withInput($request->all())
            ->withErrors(
                Lang::get('determinations.error_saving_determination')
            );
        }

    	return $redirect;
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

		$request->validate([
            'code' => 'required|numeric|min:0',
            'name' => 'required|string',
            'position' => 'required|numeric|min:1',
            'biochemical_unit' => 'required|numeric|min:0',
        ]);

		$determination = Determination::findOrFail($id);

		if ($determination->update($request->all())) {
			$redirect = redirect()->action('DeterminationController@show', $id);
		} else {
        	$redirect = back()->withInput($request->all())
            ->withErrors(
                Lang::get('determinations.error_updating_determination')
            );			
		}

        return $redirect;
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
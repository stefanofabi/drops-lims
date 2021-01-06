<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
     *
     * @param \Illuminate\Http\Request $request
     * @return View $view
     */
    public function load(Request $request)
    {

        $offset = ($request->page - 1) * self::PER_PAGE;

        $determinations = Determination::index($request->nomenclator, $request->filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = $determinations->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($request->page, $total_pages, self::ADJACENTS);

        $nomenclators = Nomenclator::all();

        return view('administrators/determinations/index')->with('request', $request->all())->with('determinations', $determinations)->with('paginate', $paginate)->with('nomenclators', $nomenclators);
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

        try {
            $determination = new Determination($request->all());

            if ($determination->save()) {
                $redirect = redirect()->action([DeterminationController::class, 'show'], [$determination->id]);
            } else {
                $redirect = back()->withInput($request->all())->withErrors(Lang::get('determinations.error_saving_determination'));
            }
        } catch (QueryException $e) {
            $redirect = back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return $redirect;
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

        $determination = Determination::findOrFail($id);

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
        $determination = Determination::findOrFail($id);

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

        try {

            $determination = Determination::findOrFail($id);

            if ($determination->update($request->all())) {
                $redirect = redirect()->action([DeterminationController::class, 'show'], $id);
            } else {
                $redirect = back()->withInput($request->all())->withErrors(Lang::get('determinations.error_updating_determination'));
            }
        } catch (QueryException $e) {
            $redirect = back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return $redirect;
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

        $determination = Determination::findOrFail($id);

        $nomenclators = Nomenclator::all();

        $view = view('administrators/determinations/destroy')->with('nomenclators', $nomenclators);

        if ($determination->delete()) {
            $view->with('determination_id', $id)->with('type', 'success');
        } else {
            $view->with('type', 'danger');
        }

        return $view;
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        //

        $determination = Determination::onlyTrashed()->findOrFail($id);

        $nomenclators = Nomenclator::all();

        $view = view('administrators/determinations/restore')->with('determination_id', $id)->with('nomenclators', $nomenclators);

        if ($determination->restore()) {
            $view->with('type', 'success');
        } else {
            $view->with('type', 'danger');
        }

        return $view;
    }
}

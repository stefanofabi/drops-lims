<?php

namespace App\Http\Controllers\Administrators\Prescribers;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Traits\Pagination;

use App\Models\Prescriber;

use Lang;

class PrescriberController extends Controller
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
        return view('administrators/prescribers/prescribers');
    }

    /**
     * Load prescribers
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
        $prescribers = Prescriber::index($filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = $prescribers->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

        return view('administrators/prescribers/index')->with('request', $request->all())->with('prescribers', $prescribers)->with('paginate', $paginate);
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
            'full_name' => 'required|string',
            'email' => 'email|nullable',
        ]);

        $prescriber = new Prescriber($request->all());

        if (! $prescriber->save()) {
            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([PrescriberController::class, 'show'], ['id' => $prescriber->id]);
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
        $prescriber = Prescriber::findOrFail($id);

        return view('administrators/prescribers/show')->with('prescriber', $prescriber);
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
        $prescriber = Prescriber::findOrFail($id);

        return view('administrators/prescribers/edit')->with('prescriber', $prescriber);
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
        try {
            $prescriber = Prescriber::findOrFail($id);

            if (! $prescriber->update($request->all())) {
                return redirect()->back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.not_found'));
        }

        return redirect()->action([PrescriberController::class, 'show'], ['id' => $id]);
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

        $prescriber = Prescriber::find($id);

        if (! $prescriber) {
            // prescriber not exists
            return view('administrators/prescribers/prescribers')->withErrors(Lang::get('errors.not_found'),);
        }

        $view = view('administrators/prescribers/destroy');

        if ($prescriber->delete()) {
            $view->with('prescriber_id', $id)->with('type', 'success');
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

        $prescriber = Prescriber::onlyTrashed()->find($id);

        if (! $prescriber) {
            // prescriber not removed
            return view('administrators/prescribers/prescribers')->withErrors(Lang::get('errors.not_found'),);
        }

        $view = view('administrators/prescribers/restore')->with('prescriber_id', $id);

        if ($prescriber->restore()) {
            $view->with('type', 'success');
        } else {
            $view->with('type', 'danger');
        }

        return $view;
    }
}

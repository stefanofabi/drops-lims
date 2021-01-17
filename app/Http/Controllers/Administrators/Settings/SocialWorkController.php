<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\SocialWork;

use Lang;

class SocialWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $social_works = SocialWork::all();

        return view('administrators/settings/social_works/index')->with('social_works', $social_works);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('administrators/settings/social_works/create');
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
            'name' => 'required|string',
        ]);

        $social_work = new SocialWork($request->all());

        if (! $social_work->save()) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'index']);
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

        $social_work = SocialWork::findOrFail($id);

        return view('administrators/settings/social_works/edit')->with('social_work', $social_work);
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
            'name' => 'required|string',
        ]);

        $social_work = SocialWork::findOrFail($id);

        if (! $social_work->update($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'index']);
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

        $social_work = SocialWork::findOrFail($id);

        try {
            if (! $social_work->delete()) {
                return back()->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'index']);
    }

    /**
     * Load plans from ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function load_plans(Request $request)
    {
        //
        $social_work_id = $request->social_work_id;

        try {
            $social_work = SocialWork::findOrFail($social_work_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], '500');
        }

        return response()->json($social_work->plans, 200);
    }
}

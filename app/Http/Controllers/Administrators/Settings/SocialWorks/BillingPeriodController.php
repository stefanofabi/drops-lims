<?php

namespace App\Http\Controllers\Administrators\Settings\SocialWorks;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\BillingPeriod;

use Lang;

class BillingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $billing_periods = BillingPeriod::orderBy('start_date', 'DESC')->orderBy('end_date', 'DESC')->get();

        return view('administrators/settings/social_works/billing_periods/index')->with('billing_periods', $billing_periods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('administrators/settings/social_works/billing_periods/create');
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
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($request->start_date > $request->end_date) {
            return back()->withInput($request->all())->withErrors(Lang::get('billing_periods.start_date_after_end_date'));
        }

        $billing_period = new BillingPeriod($request->all());

        try {
            if (!$billing_period->save()) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([BillingPeriodController::class, 'edit'], ['id' => $billing_period->id]);
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

        $billing_period = BillingPeriod::findOrFail($id);

        return view('administrators/settings/social_works/billing_periods/edit')->with('billing_period', $billing_period);
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
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($request->start_date > $request->end_date) {
            return back()->withInput($request->all())->withErrors(Lang::get('billing_periods.start_date_after_end_date'));
        }

        $billing_period = BillingPeriod::findOrFail($id);

        try {
            if (!$billing_period->update($request->all())) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([BillingPeriodController::class, 'index']);
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

        $billing_period = BillingPeriod::findOrFail($id);

        try {
            if (!$billing_period->delete()) {
                return back()->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([BillingPeriodController::class, 'index']);
    }

    /**
     * Returns a list of filtered billing periods
     *
     * @return \Illuminate\Http\Response
     */
    public function load_billing_periods(Request $request)
    {
        //
        
        $filter = $request->filter;
        
        // label column is required
        $billing_periods = BillingPeriod::select('id', 'name as label', 'start_date', 'end_date')
            ->where('name', 'like', "%$filter%")
            ->get()
            ->toJson();

        return $billing_periods;
    }
}

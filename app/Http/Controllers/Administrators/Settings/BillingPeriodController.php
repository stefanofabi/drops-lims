<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use Lang;
use Session;

class BillingPeriodController extends Controller
{

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct (BillingPeriodRepositoryInterface $billingPeriodRepository) 
    {
        $this->billingPeriodRepository = $billingPeriodRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $billing_periods = $this->billingPeriodRepository->all();
        
        return view('administrators/settings/billing_periods/index')
            ->with('billing_periods', $billing_periods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('administrators/settings/billing_periods/create');
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

        if (! $billing_period = $this->billingPeriodRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('billing_periods.billing_period_created_successfully')]);

        return redirect()->action([BillingPeriodController::class, 'index']);
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

        $billing_period = $this->billingPeriodRepository->findOrFail($id);

        return view('administrators/settings/billing_periods/edit')
            ->with('billing_period', $billing_period);
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

        if (! $this->billingPeriodRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
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

        if (!$this->billingPeriodRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('billing_periods.billing_period_deleted_successfully')]);
 
        return redirect()->action([BillingPeriodController::class, 'index']);
    }

    /**
     * Returns a list of filtered billing periods
     *
     * @return \Illuminate\Http\Response
     */
    public function loadBillingPeriods(Request $request)
    {
        //

        $request->validate([
            'filter' => 'required|string|min:2',
        ]);

        return $this->billingPeriodRepository->loadBillingPeriods($request->filter);
    }
}

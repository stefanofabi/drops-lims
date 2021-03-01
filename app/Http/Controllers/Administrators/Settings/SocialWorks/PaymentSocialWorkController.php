<?php

namespace App\Http\Controllers\Administrators\Settings\SocialWorks;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\BillingPeriod;
use App\Models\PaymentSocialWork;
use App\Models\SocialWork;

use Lang;

class PaymentSocialWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($social_work_id)
    {
        //
        $social_work = SocialWork::findOrFail($social_work_id);

        return view('administrators/settings/social_works/payments/create')->with('social_work', $social_work);
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
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'billing_period_id' => 'required|numeric|min:1',
        ]);

        $billing_period = BillingPeriod::findOrFail($request->billing_period_id);

        if ($billing_period->end_date > $request->payment_date) {
            return back()->withInput($request->all())->withErrors(Lang::get('payment_social_works.payment_before_billing_period'));
        }

        try {
            $payment = new PaymentSocialWork($request->all());

            if (!$payment->save()) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'edit'], ['id' => $request->social_work_id]);
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

        $payment = PaymentSocialWork::findOrFail($id);

        return view('administrators/settings/social_works/payments/edit')->with('payment', $payment);
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
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'billing_period_id' => 'required|numeric|min:1',
        ]);

        $payment = PaymentSocialWork::findOrFail($id);

        try {

            $billing_period = $payment->billing_period;

            if ($billing_period->end_date > $request->payment_date) {
                return back()->withInput($request->all())->withErrors(Lang::get('payment_social_works.payment_before_billing_period'));
            }

            if (!$payment->update($request->all())) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'edit'], ['id' => $payment->social_work_id]);
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

        $payment = PaymentSocialWork::findOrFail($id);

        try {
            if (!$payment->delete()) {
                return back()->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
            return back()->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'edit'], ['id' => $payment->social_work_id]);
    }
}

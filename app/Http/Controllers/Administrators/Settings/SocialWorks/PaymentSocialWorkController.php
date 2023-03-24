<?php

namespace App\Http\Controllers\Administrators\Settings\SocialWorks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;

use Lang;
use Session;

class PaymentSocialWorkController extends Controller
{
    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    /** @var \App\Contracts\Repository\PaymentSocialWorkRepositoryInterface */
    private $paymentSocialWorkRepository;
    
    public function __construct(
        SocialWorkRepositoryInterface $socialWorkRepository,
        PaymentSocialWorkRepositoryInterface $paymentSocialWorkRepository,
    ) {
        $this->socialWorkRepository = $socialWorkRepository;
        $this->paymentSocialWorkRepository = $paymentSocialWorkRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $social_work = $this->socialWorkRepository->findOrFail($request->social_work_id);
        
        $payments = $social_work->payments;
   
        return view('administrators.settings.social_works.payments.index')
            ->with('social_work', $social_work)
            ->with('payments', $payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        $social_work = $this->socialWorkRepository->findOrFail($request->social_work_id);

        return view('administrators/settings/social_works/payments/create')
            ->with('social_work', $social_work);
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
            'amount' => 'required|numeric|min:0.01',
        ]);

        if (! $this->paymentSocialWorkRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('payment_social_works.payment_created_succesfully')]);
   
        return redirect()->action([PaymentSocialWorkController::class, 'index'], ['social_work_id' => $request->social_work_id]);
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
        
        $social_work_id = $this->paymentSocialWorkRepository->findOrFail($id)->social_work_id;  

        if (! $this->paymentSocialWorkRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('payment_social_works.payment_deleted_succesfully')]);

        return redirect()->action([PaymentSocialWorkController::class, 'index'], ['social_work_id' => $social_work_id]);
    }
}

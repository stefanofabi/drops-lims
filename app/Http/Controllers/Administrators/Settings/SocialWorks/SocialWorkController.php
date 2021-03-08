<?php

namespace App\Http\Controllers\Administrators\Settings\SocialWorks;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Laboratory\Repositories\SocialWorks\SocialWorkRepositoryInterface;

use App\Models\PaymentSocialWork;

use Lang;

class SocialWorkController extends Controller
{
    /** @var \App\Laboratory\Repositories\SocialWorks\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    public function __construct(SocialWorkRepositoryInterface $socialWorkRepository)
    {
        $this->socialWorkRepository = $socialWorkRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $social_works = $this->socialWorkRepository->all();

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
        
        if (! $this->socialWorkRepository->create($request->all())) {
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

        $social_work = $this->socialWorkRepository->findOrFail($id);

        $payments = PaymentSocialWork::select('payment_social_works.id', 'payment_date', 'amount', 'name as billing_period')
            ->join('billing_periods', 'payment_social_works.billing_period_id', '=', 'billing_periods.id')
            ->where('social_work_id', $social_work->id)
            ->orderBy('billing_periods.end_date', 'DESC')
            ->orderBy('payment_date', 'ASC')
            ->get();

        return view('administrators/settings/social_works/edit')
            ->with('social_work', $social_work)
            ->with('payments', $payments);
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
        
        if (! $this->socialWorkRepository->update($request->except(['_token', '_method']), $id)) {
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

        if (! $this->socialWorkRepository->delete($id)) {
                return back()->withErrors(Lang::get('forms.failed_transaction'));
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

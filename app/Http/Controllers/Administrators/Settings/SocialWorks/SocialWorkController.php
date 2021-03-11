<?php

namespace App\Http\Controllers\Administrators\Settings\SocialWorks;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;

use Lang;

class SocialWorkController extends Controller
{
    private const ATTRIBUTES = [
        'name',
        'acronym',
    ];

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    /** @var \App\Contracts\Repository\PaymentSocialWorkRepositoryInterface */
    private $paymentSocialWorkRepository;

    public function __construct(
        SocialWorkRepositoryInterface $socialWorkRepository,
        PaymentSocialWorkRepositoryInterface $paymentSocialWorkRepository
    ) {
        $this->socialWorkRepository = $socialWorkRepository;
        $this->paymentSocialWorkRepository = $paymentSocialWorkRepository;
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
        
        if (! $this->socialWorkRepository->create($request->only(self::ATTRIBUTES))) {
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

        $payments = $this->paymentSocialWorkRepository->getPaymentsFromSocialWork($social_work->id);

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
        
        if (! $this->socialWorkRepository->update($request->only(self::ATTRIBUTES), $id)) {
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
            $social_work = $this->socialWorkRepository->findOrFail($social_work_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => Lang::get('errors.not_found')], '500');
        }

        return response()->json($social_work->plans, 200);
    }
}

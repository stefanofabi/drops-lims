<?php

namespace App\Http\Controllers\Administrators\Settings\SocialWorks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Laboratory\Repositories\SocialWorks\SocialWorkRepositoryInterface;
use App\Laboratory\Repositories\Nomenclators\NomenclatorRepositoryInterface;

use App\Models\Plan;

use Lang;

class PlanController extends Controller
{
    /** @var \App\Laboratory\Repositories\SocialWorks\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    /** @var \App\Laboratory\Repositories\Nomenclators\NomenclatorRepositoryInterface */
    private $nomenclatorRepository;

    public function __construct(
        SocialWorkRepositoryInterface $socialWorkRepository, 
        NomenclatorRepositoryInterface $nomenclatorRepository
    ) {
        $this->socialWorkRepository = $socialWorkRepository;
        $this->nomenclatorRepository = $nomenclatorRepository;
    }

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
        $social_work =  $this->socialWorkRepository->findOrFail($social_work_id);
        $nomenclators = $this->nomenclatorRepository->all();

        return view('administrators/settings/social_works/plans/create')
            ->with('social_work', $social_work)
            ->with('nomenclators', $nomenclators);
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
            'nbu_price' => 'required|numeric',
        ]);
 
        $plan = new Plan($request->all());

        if (! $plan->save()) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'edit'], ['id' => $plan->social_work_id]);
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
        
        $plan = Plan::findOrFail($id);
        $nomenclators = $this->nomenclatorRepository->all();

        return view('administrators/settings/social_works/plans/edit')
            ->with('plan', $plan)
            ->with('nomenclators', $nomenclators);
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
            'nbu_price' => 'required|numeric',
        ]);

        $plan = Plan::findOrFail($id);
    
        if (! $plan->update($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'edit'], ['id' => $plan->social_work_id]);
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

        $plan = Plan::findOrFail($id);

        if (! $plan->delete()) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([SocialWorkController::class, 'edit'], ['id' => $plan->social_work_id]);
    }
}

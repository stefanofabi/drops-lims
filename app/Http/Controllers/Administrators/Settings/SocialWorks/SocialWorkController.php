<?php

namespace App\Http\Controllers\Administrators\Settings\SocialWorks;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;

use Lang;
use Session;

class SocialWorkController extends Controller
{

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
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

        return view('administrators/settings/social_works/index')
            ->with('social_works', $social_works);
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
        
        if (! $this->socialWorkRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }      

        Session::flash('success', [Lang::get('social_works.social_work_created_successfully')]);

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

        return view('administrators/settings/social_works/edit')
            ->with('social_work', $social_work);
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
        
        if (! $this->socialWorkRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('social_works.social_work_updated_successfully')]);
        
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
        
        Session::flash('success', [Lang::get('social_works.social_work_deleted_successfully')]);

        return redirect()->action([SocialWorkController::class, 'index']);
    }

    /**
     * Load social works from ajax
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSocialWorks(Request $request)
    {
        //
        
        return $this->socialWorkRepository->getSocialWorks($request->filter);
    }
}

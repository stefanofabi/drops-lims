<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\NomenclatorRepositoryInterface;

use Lang;
use Session;

class NomenclatorController extends Controller
{

    /** @var \App\Contracts\Repository\NomenclatorRepositoryInterface */
    private $nomenclatorRepository;

    public function __construct(NomenclatorRepositoryInterface $nomenclatorRepository)
    {
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

        $nomenclators = $this->nomenclatorRepository->all();

        return view('administrators/settings/nomenclators/index')->with('nomenclators', $nomenclators);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('administrators/settings/nomenclators/create');
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

        if (! $this->nomenclatorRepository->create($request->all())) {
                return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('nomenclators.nomenclator_created_successfully')]);
  
        return redirect()->action([NomenclatorController::class, 'index']);
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
        $nomenclator = $this->nomenclatorRepository->findOrFail($id);

        return view('administrators/settings/nomenclators/edit')->with('nomenclator', $nomenclator);
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
        
        if (! $this->nomenclatorRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
  
        Session::flash('success', [Lang::get('nomenclators.nomenclator_updated_successfully')]);
  
        return redirect()->action([NomenclatorController::class, 'index']);
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

        if (! $this->nomenclatorRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        Session::flash('success', [Lang::get('nomenclators.nomenclator_deleted_successfully')]);
      
        return redirect()->action([NomenclatorController::class, 'index']);
    }
}

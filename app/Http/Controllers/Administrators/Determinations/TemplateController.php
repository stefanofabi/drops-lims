<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\DeterminationRepositoryInterface;

class TemplateController extends Controller
{
    /** @var \App\Contracts\Repository\DeterminationRepositoryInterface */
    private $determinationRepository;

    public function __construct(DeterminationRepositoryInterface $determinationRepository) 
    {
        $this->determinationRepository = $determinationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        $determination = $this->determinationRepository->findOrFail($id);

        return view('administrators.determinations.templates.edit')
            ->with('determination', $determination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'javascript' => 'present|max:1000',
            'template' => 'present|max:2000',
        ]);
        
        if (! $this->determinationRepository->updateTemplate($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([DeterminationController::class, 'edit'], ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

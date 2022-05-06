<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\FamilyMemberRepositoryInterface;
use App\Contracts\Repository\SecurityCodeRepositoryInterface;

use Throwable;

use Lang;

class FamilyMemberController extends Controller
{
    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;

    /** @var \App\Contracts\Repository\SecurityCodeRepositoryInterface */
    private $securityCodeRepository;

    public function __construct (
        FamilyMemberRepositoryInterface $familyMemberRepository, 
        SecurityCodeRepositoryInterface $securityCodeRepository
    ) {
        $this->familyMemberRepository = $familyMemberRepository;
        $this->securityCodeRepository = $securityCodeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $user = auth()->user();
        $family_members = $user->family_members;

        return view('patients.family_members.index')
            ->with('family_members', $family_members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('patients.family_members.create');
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
            'internal_patient_id' => 'required|numeric|min:1',
            'security_code' => 'required|string',
        ]);

        DB::beginTransaction();

        try {

            $family_member = $this->familyMemberRepository->create([
                'user_id' => auth()->user()->id, 
                'internal_patient_id' => $request->internal_patient_id
            ]);

            $security_code = $this->securityCodeRepository->getSecurityCodeAssociate($request->internal_patient_id);
            $this->securityCodeRepository->update(['used_at' => now()], $security_code->id);

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
         
            return redirect()->back()
                ->withInput($request->except('security_code'))
                ->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([FamilyMemberController::class, 'index']);
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
    }
}
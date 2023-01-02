<?php

namespace App\Http\Controllers\Administrators\InternalPatients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\InternalPatientRepositoryInterface;
use App\Contracts\Repository\SocialWorkRepositoryInterface;

use Lang;
use Session;

class InternalPatientController extends Controller
{
    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Contracts\Repository\InternalPatientRepositoryInterface */
    private $internalPatientRepository;

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    public function __construct(
        InternalPatientRepositoryInterface $internalPatientRepository, 
        SocialWorkRepositoryInterface $socialWorkRepository
    ) {
        $this->internalPatientRepository = $internalPatientRepository;
        $this->socialWorkRepository = $socialWorkRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        
        $request->validate([
            'filter' => 'string|nullable',
            'page' => 'required|numeric|min:1',
        ]);

        $patients = $this->internalPatientRepository->index($request->filter);
   
        // Pagination
        $page = $request->page;
        $count_rows = $patients->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);
        
        if ($total_pages < $page) 
        {
            $offset = 0;
            $page = 1;
        } else 
        {
            $offset = ($page - 1) * self::PER_PAGE;
        }
        
        return view("administrators.internal_patients.index")
            ->with('filter', $request->filter)
            ->with('patients', $patients->skip($offset)->take(self::PER_PAGE))
            ->with('paginate', $paginate)
            ->with('page', $page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        return view('administrators.internal_patients.create');
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
            'last_name' => 'required|string|min:2',
            'name' => 'required|string|min:2',
            'sex' => 'in:F,M',
            'birthdate' => 'date|nullable',
            'email' => 'email|nullable',
            'alternative_email' => 'email|nullable',
        ]);

        if (! $patient = $this->internalPatientRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([InternalPatientController::class, 'edit'], ['id' => $patient->id]);
    }

    /**
     * Show the form for creating a new resource.
     *
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
        
        $patient = $this->internalPatientRepository->findOrFail($id);

        $social_works = $this->socialWorkRepository->all();

        return view('administrators.internal_patients.edit')
            ->with('patient', $patient);
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
            'last_name' => 'required|string|min:2',
            'name' => 'required|string|min:2',
            'sex' => 'in:F,M',
            'birthdate' => 'date|nullable',
            'email' => 'email|nullable',
            'alternative_email' => 'email|nullable',
        ]);
        
        if (! $this->internalPatientRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([InternalPatientController::class, 'edit'], ['id' => $id]);
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

        if (! $this->internalPatientRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('patients.success_destroy_message')]);

        return redirect()->action([InternalPatientController::class, 'index'], ['page' => 1]);
    }

    /**
     * Returns a list of filtered patients
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function loadPatients(Request $request)
    {
        
        $request->validate([
            'filter' => 'required|string|min:2'
        ]);
        
        return $this->internalPatientRepository->loadPatients($request->filter);
    }
}
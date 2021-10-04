<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\TaxConditionRepositoryInterface;

use Lang;

class PatientController extends Controller
{

    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    /** @var \App\Contracts\Repository\TaxConditionRepositoryInterface */
    private $taxConditionRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository, 
        SocialWorkRepositoryInterface $socialWorkRepository,
        TaxConditionRepositoryInterface $taxConditionRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->socialWorkRepository = $socialWorkRepository;
        $this->taxConditionRepository = $taxConditionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $request->validate([
            'type' => 'required|in:animal,human,industrial',
            'filter' => 'string|nullable',
            'page' => 'required|numeric|min:1',
        ]);

        $offset = ($request->page - 1) * self::PER_PAGE;
        $patients = $this->patientRepository->index($request->filter, $request->type);

        // Pagination
        $count_rows = $patients->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($request->page, $total_pages, self::ADJACENTS);
        
        $view = $this->getView($request->type, "index");

        return $view
            ->with('data', $request->all())
            ->with('patients', $patients->skip($offset)->take(self::PER_PAGE))
            ->with('paginate', $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($patient_type)
    {
        //
        
        $tax_conditions = $this->taxConditionRepository->all();

        return $this->getView($patient_type, 'create')
            ->with('tax_conditions', $tax_conditions);
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
            'full_name' => 'required|string',
            'sex' => 'in:F,M',
            'birth_date' => 'date|nullable',
            'email' => 'email|nullable',
            'alternative_email' => 'email|nullable',
            'type' => 'required|in:animal,human,industrial',
        ]);

        if (! $patient = $this->patientRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));;
        }

        return redirect()->action([PatientController::class, 'edit'], ['id' => $patient->id]);
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
        
        $patient = $this->patientRepository->findOrFail($id);

        $social_works = $this->socialWorkRepository->all();

        $tax_conditions = $this->taxConditionRepository->all();

        return $this->getView($patient->type, 'edit')
            ->with('patient', $patient)
            ->with('social_works', $social_works)
            ->with('tax_conditions', $tax_conditions);
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
            'full_name' => 'required|string',
            'sex' => 'in:F,M',
            'birth_date' => 'date|nullable',
            'email' => 'email|nullable',
            'alternative_email' => 'email|nullable',
            'type' => 'in:animal,human,industrial',
        ]);

        if (! $this->patientRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
        
        return redirect()->action([PatientController::class, 'edit'], ['id' => $id]);
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

        if (!$this->patientRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        return view('administrators/patients/patients')
            ->with('success', [Lang::get('patients.success_destroy_message')]);
    }

    public function getView($patient_type, $view_type)
    {
        $patient_type .= "s";

        return view("administrators/patients/$patient_type/$view_type");
    }

    /**
     * Returns a list of filtered patients
     *
     * @return \Illuminate\Http\Response
     */
    public function loadPatients(Request $request)
    {
        
        return $this->patientRepository->loadPatients($request->filter);
    }
}
<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\PaginationTrait;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\SocialWorkRepositoryInterface;

use Lang;

class PatientController extends Controller
{
    private const ATTRIBUTES = [
        'full_name',
        'key',
        'sex',
        'birth_date',
        'city',
        'address',
        'owner',
        'business_name',
        'tax_condition',
        'start_activity',
        'type',
    ];

    use PaginationTrait;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository, 
        SocialWorkRepositoryInterface $socialWorkRepository
    ) {
        $this->patientRepository = $patientRepository;
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

        return view('administrators/patients/patients');
    }

    /**
     * Load patients
     *
     * @param \Illuminate\Http\Request $request
     * @return View $view
     */
    public function load(Request $request)
    {
        $request->validate([
            'type' => 'in:animal,human,industrial',
            'filter' => 'string|nullable',
            'page' => 'required|numeric|min:1',
        ]);

        // Request
        $patient_type = $request->type;
        $filter = $request->filter;
        $page = $request->page;

        $offset = ($page - 1) * self::PER_PAGE;
        $patients = $this->patientRepository->index($filter, $offset, self::PER_PAGE, $patient_type);

        // Pagination
        $count_rows = $patients->count();
        $total_pages = ceil($count_rows / self::PER_PAGE);
        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

        switch ($patient_type) {
            case 'animal':
            {
                $view = view('administrators/patients/animals/index');
                break;
            }

            case 'human':
            {
                $view = view('administrators/patients/humans/index');
                break;
            }

            case 'industrial':
            {
                $view = view('administrators/patients/industrials/index');
                break;
            }
        }

        return $view
            ->with('request', $request)
            ->with('data', $patients)
            ->with('paginate', $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type = null)
    {
        //

        switch ($type) {
            case 'animal':
            {
                $view = view('administrators/patients/animals/create');
                break;
            }

            case 'human':
            {
                $view = view('administrators/patients/humans/create');
                break;
            }

            case 'industrial':
            {
                $view = view('administrators/patients/industrials/create');
                break;
            }

            default: {
                $view = view('administrators/patients/create');
                break;
            }
        }

        return $view;
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
            'type' => 'in:animal,human,industrial',
            'birth_date' => 'date|nullable',
        ]);

        if (! $patient = $this->patientRepository->create($request->only(self::ATTRIBUTES))) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));;
        }

        return redirect()->action([PatientController::class, 'show'], ['id' => $patient->id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $patient = $this->patientRepository->findOrFail($id);

        switch ($patient->type) {
            case 'animal':
            {
                $view = view('administrators/patients/animals/show');
                break;
            }

            case 'human':
            {
                $view = view('administrators/patients/humans/show');
                break;
            }

            case 'industrial':
            {
                $view = view('administrators/patients/industrials/show');
                break;
            }

            // others cases has filtered in enum field
        }

        return $view->with('patient', $patient);
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

        switch ($patient->type) {
            case 'animal':
            {
                $view = view('administrators/patients/animals/edit');
                break;
            }

            case 'human':
            {
                $view = view('administrators/patients/humans/edit');
                break;
            }

            case 'industrial':
            {
                $view = view('administrators/patients/industrials/edit');
                break;
            }

            // others cases has filtered in enum field
        }

        return $view
            ->with('patient', $patient)
            ->with('social_works', $social_works);
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
            'type' => 'in:animal,human,industrial',
            'birth_date' => 'date|nullable',
            'start_activity' => 'date|nullable',
        ]);
        
        if (! $this->patientRepository->update($request->only(self::ATTRIBUTES), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));;
        }

        return redirect()->action([PatientController::class, 'show'], ['id' => $id]);
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
}

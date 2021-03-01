<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Traits\Pagination;
use App\Models\Patient;
use App\Models\SocialWork;

use Lang;

class PatientController extends Controller
{
    use Pagination;

    private const PER_PAGE = 15;

    private const ADJACENTS = 4;

    private const RETRIES = 5;

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
        $patients = Patient::index($filter, $offset, self::PER_PAGE, $patient_type);

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

            // other cases has filtered in web routes
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

        $patient = new Patient($request->all());
        
        try {
            if (! $patient->save()) {
                return redirect()->back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));;
            }
        } catch (QueryException $exception) {
            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
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

        $patient = Patient::findOrFail($id);

        $patient_type = $patient->type;

        switch ($patient_type) {
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
        $patient = Patient::findOrFail($id);

        $social_works = SocialWork::all();

        $patient_type = $patient->type;

        switch ($patient_type) {
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

        return $view->with('patient', $patient)->with('social_works', $social_works);
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

        $patient = Patient::findOrFail($id);

        try {
            if (! $patient->update($request->all())) {
                return redirect()->back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));;
            }
        } catch (QueryException $exception) {
            $redirect = redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
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

        $patient = Patient::findOrFail($id);

        $view = view('administrators/patients/destroy');
        try {
            if ($patient->delete()) {
                $view->with('patient_id', $id)->with('type', 'success');
            } else {
                $view->with('type', 'danger');
            }
        } catch (QueryException $exception) {
            return redirect()->back()->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return $view;
    }
}

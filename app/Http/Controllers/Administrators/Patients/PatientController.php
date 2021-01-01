<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        return $view->with('request', $request->all())->with('data', $patients)->with('paginate', $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('administrators/patients/create');
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

            default:
            {
                return view('administrators/patients/patients')->withErrors(Lang::get('errors.invalid_patient_type'));
            }
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

            default:
            {
                return view('administrators/patients/patients')->withErrors(Lang::get('errors.invalid_patient_type'));
            }
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

        try {
            $patient = Patient::findOrFail($id);

            $patient->update($request->all());
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.not_found'));
        }

        return redirect()->action([PatientController::class, 'show'], ['id' => $id]);
    }

    /**
     * Show the form for creating a new animal patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_animal()
    {
        //

        return view('administrators/patients/animals/create');
    }

    /**
     * Show the form for creating a new human patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_human()
    {
        //

        return view('administrators/patients/humans/create');
    }

    /**
     * Show the form for creating a new industrial patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_industrial()
    {
        //

        return view('administrators/patients/industrials/create');
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
        ]);

        $patient = new Patient($request->all());

        if (! $patient->save()) {
            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));;
        }

        return redirect()->action([PatientController::class, 'show'], ['id' => $patient->id]);
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

        $patient = Patient::find($id);

        if (! $patient) {
            // patient not exists
            return view('administrators/patients/patients')->withErrors(Lang::get('patients.error_destroy_patient'));
        }

        $view = view('administrators/patients/destroy');

        if ($patient->delete()) {
            $view->with('patient_id', $id)->with('type', 'success');
        } else {
            $view->with('type', 'danger');
        }

        return $view;
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        //

        $patient = Patient::onlyTrashed()->find($id);

        if (! $patient) {
            // patient not removed
            return view('administrators/patients/patients')->withErrors(Lang::get('patients.error_restore_patient'));
        }

        $view = view('administrators/patients/restore')->with('patient_id', $id);

        if ($patient->restore()) {
            $view->with('type', 'success');
        } else {
            $view->with('type', 'danger');
        }

        return $view;
    }
}

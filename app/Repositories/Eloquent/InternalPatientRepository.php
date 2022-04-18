<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\InternalPatientRepositoryInterface;

use App\Models\InternalPatient;

final class InternalPatientRepository implements InternalPatientRepositoryInterface
{
    protected $model;

    /**
     * PatientRepository constructor.
     *
     * @param Patient $patient
     */
    public function __construct(InternalPatient $patient)
    {
        $this->model = $patient;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {   
        $patient = $this->model->findOrFail($id);
        
        return $patient->update($data);
    }

    public function delete($id)
    {
        $patient = $this->model->findOrFail($id);
        
        return $patient->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function index($filter)
    {
        return $this->model
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("last_name", "ilike", "%$filter%")
                        ->orWhere("name", "ilike", "%$filter%")
                        ->orWhere("identification_number", "ilike", "$filter%");
                }
            })
            ->orderBy('last_name', 'asc')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function loadPatients($filter) {
        // label column is required
        
        $patients = $this->model->select(DB::raw("CONCAT(last_name, ' ', name) as label"), 'id') 
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("last_name", "ilike", "%$filter%")
                        ->orWhere("name", "ilike", "%$filter%")
                        ->orWhere("identification_number", "ilike", "$filter%");
                }
            })
            ->take(15)
            ->orderBy('last_name', 'ASC')
            ->orderBy('name', 'ASC')
            ->get();

        if ($patients->isEmpty()) 
        {
            return response()->json(['label' => 'No records found']);
        }

        return $patients;
    }
}
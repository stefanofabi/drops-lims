<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PatientRepositoryInterface;

use App\Models\Patient;

final class PatientRepository implements PatientRepositoryInterface
{
    protected $model;

    /**
     * PatientRepository constructor.
     *
     * @param Patient $patient
     */
    public function __construct(Patient $patient)
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

    public function index($filter, $type)
    {
        return $this->model
            ->where('type', $type)
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("full_name", "like", "%$filter%")
                        ->orWhere("identification_number", "like", "$filter%")
                        ->orWhere("owner", "like", "%$filter%");
                }
            })
            ->orderBy('full_name', 'asc')
            ->get();
    }

    public function loadPatients($filter) {
        // label column is required
        
        $patients = $this->model->select('full_name as label', 'id') 
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("full_name", "like", "%$filter%")
                        ->orWhere("identification_number", "like", "$filter%")
                        ->orWhere("owner", "like", "%$filter%");
                }
            })
            ->get();

        if ($patients->isEmpty()) 
        {
            return response()->json(['label' => 'No records found']);
        }

        return $patients;
    }
}
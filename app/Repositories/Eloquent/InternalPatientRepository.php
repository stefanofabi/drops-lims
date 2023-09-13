<?php

namespace App\Repositories\Eloquent;

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
        // use find to trigger model events

        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
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
                    $query->orWhere("full_name", "ilike", "%$filter%")
                        ->orWhere("identification_number", "like", "$filter%");
                }
            })
            ->orderBy('full_name', 'ASC')
            ->get();
    }

    public function loadPatients($filter) 
    {
        return $this->model
            ->select('id', 'full_name', 'identification_number') 
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere('full_name', 'ilike', "%$filter%")
                        ->orWhere('identification_number', 'like', "$filter%");
                }
            })
            ->orderBy('full_name', 'ASC')
            ->get();
    }

    public function getSexComposition() 
    {
        return $this->model
        ->select('sex') 
        ->selectRaw('COUNT(*) as total_patients')
        ->groupBy('sex')
        ->get();
    }
}
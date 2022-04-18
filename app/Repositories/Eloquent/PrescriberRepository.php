<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PrescriberRepositoryInterface;

use App\Models\Prescriber; 

final class PrescriberRepository implements PrescriberRepositoryInterface
{
    protected $model;

    /**
     * PrescriberRepository constructor.
     *
     * @param Prescriber $prescriber
     */
    public function __construct(Prescriber $prescriber)
    {
        $this->model = $prescriber;
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
        $prescriber = $this->model->findOrFail($id);

        return $prescriber->update($data);
    }

    public function delete($id)
    {
        $prescriber = $this->model->findOrFail($id);

        return $prescriber->delete();
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
                        ->orWhere("provincial_enrollment", "ilike", "$filter%")
                        ->orWhere("national_enrollment", "ilike", "$filter%");
                }
            })
            ->orderBy('full_name', 'asc')
            ->get();
    }

    public function loadPrescribers($filter)
    {
        // label column is required
   
        $prescribers = $this->model->select('full_name as label', 'id')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("full_name", "ilike", "%$filter%")
                    ->orWhere("provincial_enrollment", "ilike", "$filter%")
                    ->orWhere("national_enrollment", "ilike", "$filter%");
                }
            })
            ->take(15)
            ->orderBy('full_name', 'ASC')
            ->get();

        if ($prescribers->isEmpty()) 
        {
            return response()->json(['label' => 'No records found']);
        }

        return $prescribers;
    }
}
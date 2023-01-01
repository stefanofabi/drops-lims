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
                        ->orWhere("primary_enrollment", "like", "$filter%")
                        ->orWhere("secondary_enrollment", "like", "$filter%");
                }
            })
            ->orderBy('full_name', 'asc')
            ->get();
    }

    public function loadPrescribers($filter)
    {

        return $this->model->select('id', 'full_name', 'primary_enrollment', 'secondary_enrollment')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere('full_name', 'ilike', "%$filter%")
                    ->orWhere('primary_enrollment', 'like', "$filter%")
                    ->orWhere('secondary_enrollment', 'like', "$filter%");
                }
            })
            ->orderBy('full_name', 'ASC')
            ->get();
    }
}
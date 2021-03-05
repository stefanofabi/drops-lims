<?php

namespace App\Laboratory\Repositories\Prescribers;

use App\Laboratory\Repositories\Prescribers\PrescriberRepositoryInterface;

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
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function index($filter, $offset, $length)
    {
        return $this->model
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("full_name", "like", "%$filter%")
                        ->orWhere("provincial_enrollment", "like", "$filter%")
                        ->orWhere("national_enrollment", "like", "$filter%");
                }
            })
            ->orderBy('full_name', 'asc')
            ->offset($offset)
            ->limit($length)
            ->get();
    }
}
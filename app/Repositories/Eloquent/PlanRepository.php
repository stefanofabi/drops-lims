<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PlanRepositoryInterface;

use App\Models\Plan; 

use App\Exceptions\NotImplementedException;

use Lang;

final class PlanRepository implements PlanRepositoryInterface
{
    protected $model;

    /**
     * PlanRepository constructor.
     *
     * @param Plan $plan
     */
    public function __construct(Plan $plan)
    {
        $this->model = $plan;
    }

    public function all()
    {
        throw new NotImplementedException('Method has not implemented');
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

}
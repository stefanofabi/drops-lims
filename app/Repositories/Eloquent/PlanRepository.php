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
        $this->model->name = $data['name'];
        $this->model->nbu_price = $data['nbu_price'];
        $this->model->social_work_id = $data['social_work_id'];
        $this->model->nomenclator_id = $data['nomenclator_id'];

        $this->model->save();

        return $this->model;
    }

    public function update(array $data, $id)
    {
        return $this->model->findOrFail($id)->update($data);
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
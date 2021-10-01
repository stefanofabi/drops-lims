<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\TaxConditionRepositoryInterface;

use App\Models\TaxCondition; 

final class TaxConditionRepository implements TaxConditionRepositoryInterface
{
    protected $model;

    /**
     * TaxCondition constructor.
     *
     * @param TaxCondition $taxCondition
     */
    public function __construct(TaxCondition $taxCondition)
    {
        $this->model = $taxCondition;
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
        return $this->model->find($id)->update($data);
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
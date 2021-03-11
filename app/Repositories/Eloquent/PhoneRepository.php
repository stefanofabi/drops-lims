<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PhoneRepositoryInterface;

use App\Models\Phone; 

final class PhoneRepository implements PhoneRepositoryInterface
{
    protected $model;

    /**
     * PhoneRepository constructor.
     *
     * @param Phone $phone
     */
    public function __construct(Phone $phone)
    {
        $this->model = $phone;
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
    
}
<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\PhoneRepositoryInterface;

use App\Models\Phone; 

use App\Exceptions\NotImplementedException;

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
<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;

use App\Models\InternalPractice; 

use App\Exceptions\NotImplementedException;

final class InternalPracticeRepository implements InternalPracticeRepositoryInterface
{
    protected $model;

    /**
     * InternalPracticeRepository constructor.
     *
     * @param Practice $practice
     */
    public function __construct(InternalPractice $practice)
    {
        $this->model = $practice;
    }

    public function all()
    {
        throw NotImplementedException("InternalPractice::all() not implemented");
    }

    public function create(array $data)
    {
        $this->model->determination_id = $data['determination_id'];
        $this->model->internal_protocol_id = $data['internal_protocol_id'];

        // the price field is protected from mass assignment
        $this->model->price = $data['price'];

        return $this->model->save();
    }

    public function update(array $data, $id)
    {
        throw NotImplementedException("InternalPractice::update($data, $id) not implemented");
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

    public function getPracticesNotSigned() 
    {
        return $this->model
            ->leftJoin('sign_internal_practices', 'internal_practices.id', '=', 'sign_internal_practices.internal_practice_id')
            ->where('sign_internal_practices.internal_practice_id', null)
            ->get();
    }

    public function saveResult(array $data, $id)
    {
        // the result field is protected by $fillable in the eloquent model
        $practice = $this->model->findOrFail($id);
        $practice->result = $data;
        
        return $practice->save();
    }
}
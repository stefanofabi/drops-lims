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
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
        $practice = new Practice($data);

        return $practice->save();
    }

    public function update(array $data, $id)
    {
        $practice = $this->model->findOrFail($id);
        
        return $practice->update($data);
    }

    public function delete($id)
    {
        $practice = $this->model->findOrFail($id);

        return $practice->delete();
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
}
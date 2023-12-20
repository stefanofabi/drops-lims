<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;
use App\Traits\GenerateReplacementVariables;

use App\Models\InternalPractice; 

use App\Exceptions\NotImplementedException;

final class InternalPracticeRepository implements InternalPracticeRepositoryInterface
{
    use GenerateReplacementVariables;

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

    public function saveResult(array $result, $id)
    {
        $this->model = $this->model->findOrFail($id);

        // the result field is protected by $fillable in the eloquent model
        $this->model->result = $result;
        $this->model->result_template = str_replace(array_keys($this->generateReplacementVariables($this->model->result)), array_values($this->model->result), $this->model->determination->template);
        
        return $this->model->save();
    }
}
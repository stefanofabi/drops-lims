<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;

use App\Models\SecurityCode; 

use App\Exceptions\NotImplementedException;

final class SecurityCodeRepository implements SecurityCodeRepositoryInterface
{
    protected $model;

    /**
     * SecurityCodeRepository constructor.
     *
     * @param SecurityCode $security_code
     */
    public function __construct(SecurityCode $security_code)
    {
        $this->model = $security_code;
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
        throw new NotImplementedException('Method has not implemented');
    }

    public function find($id)
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function findOrFail($patient_id)
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function getSecurityCodeAssociate($patient_id) 
    {
        return $this->model->where('internal_patient_id', $patient_id)->first();
    }

    public function deletePatientSecurityCode($patient_id) 
    {
        return $this->model->where(['internal_patient_id' => $patient_id])->delete();
    }
}
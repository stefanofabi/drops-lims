<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\SignInternalPracticeRepositoryInterface;

use App\Models\SignInternalPractice; 

use App\Exceptions\NotImplementedException;

final class SignInternalPracticeRepository implements SignInternalPracticeRepositoryInterface
{
    protected $model;
    
    /**
     * SignPracticeRepository constructor.
     *
     * @param SignInternalPractice $signInternalPractice
     */
    public function __construct(SignInternalPractice $signInternalPractice)
    {
        $this->model = $signInternalPractice;
    }

    public function all()
    {
        throw new NotImplementedException('Not implemented');
    }

    public function create(array $data)
    {
        $sign = new SignInternalPractice($data);

        return $sign->save() ? $sign : null;
    }

    public function update(array $data, $id)
    {
        throw new NotImplementedException('Not implemented');
    }

    public function delete($id)
    {
        $sign = $this->model->findOrFail($id);

        return $sign->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }    

    public function deleteAllSignatures($practice_id) 
    {
        return $this->model->where('internal_practice_id', $practice_id)->delete();
    }
}
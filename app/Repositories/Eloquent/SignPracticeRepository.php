<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\SignPracticeRepositoryInterface;

use App\Models\SignPractice; 

use App\Exceptions\NotImplementedException;

final class SignPracticeRepository implements SignPracticeRepositoryInterface
{
    protected $model;
    
    /**
     * SignPracticeRepository constructor.
     *
     * @param SignPractice $signPractice
     */
    public function __construct(SignPractice $signPractice)
    {
        $this->model = $signPractice;
    }

    public function all()
    {
        throw new NotImplementedException('Not implemented');
    }

    public function create(array $data)
    {
        $sign = new SignPractice($data);

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
        return $this->model->where('practice_id', $practice_id)->delete();
    }
}
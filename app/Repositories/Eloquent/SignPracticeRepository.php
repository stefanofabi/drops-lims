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
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        throw new NotImplementedException('Not implemented');
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
<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\EmailRepositoryInterface;

use App\Models\Email; 

use App\Exceptions\NotImplementedException;

final class EmailRepository implements EmailRepositoryInterface
{
    protected $model;

    /**
     * EmailRepository constructor.
     *
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        $this->model = $email;
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
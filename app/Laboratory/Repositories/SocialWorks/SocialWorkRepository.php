<?php

namespace App\Laboratory\Repositories\SocialWorks;

use App\Laboratory\Repositories\SocialWorks\SocialWorkRepositoryInterface;

use App\Models\SocialWork; 

final class SocialWorkRepository implements SocialWorkRepositoryInterface
{
    protected $model;

    /**
     * SocialWorkRepository constructor.
     *
     * @param SocialWork $socialWork
     */
    public function __construct(SocialWork $socialWork)
    {
        $this->model = $socialWork;
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
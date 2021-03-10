<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\AffiliateRepositoryInterface;

use App\Models\Affiliate; 

final class AffiliateRepository implements AffiliateRepositoryInterface
{
    protected $model;

    /**
     * AffiliateRepository constructor.
     *
     * @param Affiliate $affiliate
     */
    public function __construct(Affiliate $affiliate)
    {
        $this->model = $affiliate;
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
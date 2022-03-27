<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\NomenclatorRepositoryInterface;

use App\Models\Nomenclator; 

final class NomenclatorRepository implements NomenclatorRepositoryInterface
{
    protected $model;

    /**
     * NomenclatorRepository constructor.
     *
     * @param Nomenclator $nomenclator
     */
    public function __construct(Nomenclator $nomenclator)
    {
        $this->model = $nomenclator;
    }

    public function all()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->findOrFail($id)->update($data);
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
<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\DeterminationRepositoryInterface;

use App\Models\Determination; 

final class DeterminationRepository implements DeterminationRepositoryInterface
{
    protected $model;

    /**
     * DeterminationRepository constructor.
     *
     * @param Determination $determination
     */
    public function __construct(Determination $determination)
    {
        $this->model = $determination;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        $determination = new Determination($data);

        return $determination->save() ? $determination : null;
    }

    public function update(array $data, $id)
    {
        $determination = $this->model->findOrFail($id);
        
        return $determination->update($data);
    }

    public function delete($id)
    {
        $determination = $this->model->findOrFail($id);

        return $determination->delete();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function index($filter, $nomenclator_id) 
    {
		return $this->model
            ->where('nomenclator_id', '=', $nomenclator_id)
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("name", "like", "%$filter%")
                        ->orWhere("code", "like", "$filter%");
                }
            })
            ->orderBy('code', 'asc')
            ->orderBy('name', 'asc')
            ->get();
	}
}
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
        return $this->model->orderBy('code', 'ASC');
    }

    public function create(array $data)
    {
        // nomenclator id is protected against mass allocation
        $determination = new Determination;
        $determination->nomenclator_id = $data['nomenclator_id'];
        $determination->code = $data['code'];
        $determination->name = $data['name'];
        $determination->position = $data['position'];
        $determination->biochemical_unit = $data['biochemical_unit'];

        $determination->save();

        return $determination;
    }

    public function update(array $data, $id)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->where('id', $id)->delete();
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
                    $query->orWhere("name", "ilike", "%$filter%")
                        ->orWhere("code", "like", "$filter%");
                }
            })
            ->orderBy('code', 'asc')
            ->orderBy('name', 'asc')
            ->get();
	}

    public function getDeterminationsFromNomenclator($nomenclator_id, $filter) {
        return $this->model
            ->select('id', 'code', 'name', 'biochemical_unit')
            ->selectRaw("CONCAT(code, ' - ', name) as label")
            ->where('nomenclator_id', $nomenclator_id)
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere('name', 'ilike', "%$filter%")
                        ->orWhere('code', 'like', "$filter%");
                }
            })
            ->orderBy('determinations.name', 'ASC')
            ->get();
    }

    public function updateReport(array $data, $id)
    {
        $determination = $this->model->findOrFail($id);
        $determination->javascript = $data['javascript'];
        $determination->report = $data['report'];

        return $determination->save();
    }
}
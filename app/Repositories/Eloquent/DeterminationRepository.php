<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\DeterminationRepositoryInterface;

use App\Models\Determination; 

use DB;

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
        return $this->model->create($data);
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
        $determinations = $this->model
            ->select('determinations.id', DB::raw("CONCAT(determinations.code, ' - ', determinations.name) as label"))
            ->where('determinations.nomenclator_id', $nomenclator_id)
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("determinations.name", "ilike", "%$filter%")
                        ->orWhere("determinations.code", "like", "$filter%");
                }
            })
            ->take(15)
            ->orderBy('determinations.name', 'ASC')
            ->get();

            
        if ($determinations->isEmpty()) 
        {
            return response()->json(['label' => 'No records found']);
        }

        return $determinations;
    }

    public function updateReport(array $data, $id)
    {
        $determination = $this->model->findOrFail($id);
        $determination->javascript = $data['javascript'];
        $determination->report = $data['report'];

        return $determination->save();
    }
}
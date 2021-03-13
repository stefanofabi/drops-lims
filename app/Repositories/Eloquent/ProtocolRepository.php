<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\ProtocolRepositoryInterface;

use App\Models\Protocol; 

final class ProtocolRepository implements ProtocolRepositoryInterface
{
    protected $model;

    /**
     * ProtocolRepository constructor.
     *
     * @param Protocol $protocol
     */
    public function __construct(Protocol $protocol)
    {
        $this->model = $protocol;
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

    public function getPractices($protocol_id) 
    {
        $protocol = $this->model->findOrFail($protocol_id);

        return $protocol->practices;
    }

    public function index($filter, $offset, $length)
    {

        return $this->model
            ->select('protocols.id', 'protocols.completion_date', 'protocols.type', 
                DB::raw('COALESCE(patients.id, derived_patients.id) as patient_id'),
                DB::raw('COALESCE(patients.full_name, derived_patients.full_name) as patient')
            )
            ->leftJoin('patients', 'protocols.patient_id', '=', 'patients.id')
            ->leftJoin('derived_patients', 'protocols.derived_patient_id', '=', 'derived_patients.id')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("protocols.id", "like", "$filter%")
                        ->orWhere("patients.full_name", "like", "%$filter%")
                        ->orWhere("patients.key", "like", "$filter%")
                        ->orWhere("patients.owner", "like", "%$filter%")
                        ->orWhere("derived_patients.full_name", "like", "%$filter%")
                        ->orWhere("derived_patients.key", "like", "$filter%");
                }
            })
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($length)
            ->get();
    }

    public function getProtocolsInDatesRange($initial_date, $ended_date) 
    {
        return $this->model
            ->whereBetween('completion_date', [$initial_date, $ended_date])
            ->orderBy('completion_date', 'ASC')
            ->get();
    }
}
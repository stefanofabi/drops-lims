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
        $protocol = new Protocol($data);

        return $protocol->save() ? $protocol : null;
    }

    public function update(array $data, $id)
    {
        $protocol = $this->model->findOrFail($id);

        return $protocol->update($data);
    }

    public function delete($id)
    {
        $protocol = $this->model->findOrFail($id);

        return $protocol->delete();
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

    public function index($filter)
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
                        ->orWhere("patients.identification_number", "like", "$filter%")
                        ->orWhere("patients.owner", "like", "%$filter%")
                        ->orWhere("derived_patients.full_name", "like", "%$filter%")
                        ->orWhere("derived_patients.key", "like", "$filter%");
                }
            })
            ->orderBy('completion_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /*
    * Returns a list of protocols between two specified dates for a particular patient
    */
    public function getProtocolsInDatesRange($initial_date, $ended_date, $patient_id) 
    {
        return $this->model
            ->where('patient_id', $patient_id)
            ->whereBetween('completion_date', [$initial_date, $ended_date])
            ->orderBy('completion_date', 'ASC')
            ->where('protocols.type', 'our')
            ->get();
    }

    /*
    * Returns a list with the monthly collection of each social work on the specified dates
    */
    public function getCollectionSocialWork($social_work_id, $start_date, $end_date) 
    {
        return $this->model
            ->select(DB::raw('MONTH(protocols.completion_date) as month'), DB::raw('YEAR(protocols.completion_date) as year'), DB::raw('SUM(practices.amount) as total'))
            ->join('plans', 'protocols.plan_id', '=', 'plans.id')
            ->join('social_works', 'plans.social_work_id', '=', 'social_works.id')
            ->join('practices', 'protocols.id', '=', 'practices.protocol_id')
            ->where('social_works.id', $social_work_id)
            ->where('protocols.type', 'our')
            ->whereBetween('protocols.completion_date', [$start_date, $end_date])
            ->groupBy(DB::raw("MONTH(protocols.completion_date)"), DB::raw("YEAR(protocols.completion_date)"))
            ->orderBy('protocols.completion_date', 'asc')
            ->get();
    }

    /*
    * Returns a list with the monthly flow of patients on the specified dates
    */
    public function getPatientFlow($start_date, $end_date) 
    {
        return $this->model
            ->select(DB::raw('MONTH(protocols.completion_date) as month'), DB::raw('YEAR(protocols.completion_date) as year'), DB::raw('COUNT(*) as total'))
            ->where('protocols.type', 'our')
            ->whereBetween('protocols.completion_date', [$start_date, $end_date])
            ->groupBy(DB::raw('MONTH(protocols.completion_date)'), DB::raw('YEAR(protocols.completion_date)'))
            ->orderBy('protocols.completion_date', 'asc')
            ->get();
    }

    /*
    * Returns a list the monthly collection of the laboratory on the specified dates
    */
    public function getTrackIncome($start_date, $end_date) 
    {
        return $this->model
            ->select(DB::raw("MONTH(protocols.completion_date) as month"), DB::raw("YEAR(protocols.completion_date) as year"), DB::raw('SUM(practices.amount) as total'))
            ->join('practices', 'protocols.id', '=', 'practices.protocol_id')
            ->whereBetween('protocols.completion_date', [$start_date, $end_date])
            ->groupBy(DB::raw('MONTH(protocols.completion_date)'), DB::raw('YEAR(protocols.completion_date)'), 'practices.amount')
            ->orderBy('protocols.completion_date', 'asc')
            ->get();
    }

    /*
    * Verify that all the practices belong to the same protocol, in some cases also check that the patient is linked to the user
    */
    public function verifyPractices($filter_practices, $family_members) 
    {
        $count = $this->model->select('protocols.id as id')
            ->join('patients', 'protocols.patient_id', '=', 'patients.id')
            ->whereIn('patients.id', $family_members)
            ->join('practices', 'protocols.id', '=', 'practices.protocol_id')
            ->whereIn('practices.id', $filter_practices)
            ->groupBy('protocols.id')
            ->count();

        return $count == 1 ? true : false;      
    }
}
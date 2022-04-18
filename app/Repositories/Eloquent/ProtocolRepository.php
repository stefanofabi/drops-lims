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
            ->select('protocols.id', 'protocols.completion_date', 'protocols.closed', 'protocols.patient_id', 'patients.full_name as patient')
            ->join('patients', 'protocols.patient_id', '=', 'patients.id')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("protocols.id", "like", "$filter%")
                        ->orWhere("patients.full_name", "like", "%$filter%")
                        ->orWhere("patients.identification_number", "like", "$filter%")
                        ->orWhere("patients.owner", "like", "%$filter%");
                }
            })
            ->orderBy('completion_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /*
    * Returns a list of protocols between two specified dates
    */
    public function getProtocolsInDatesRange($initial_date, $ended_date) 
    {
        return $this->model
            ->whereBetween('completion_date', [$initial_date, $ended_date])
            ->orderBy('completion_date', 'ASC')
            ->get();
    }

/*
    * Returns a list of protocols between two specified dates for a particular patient
    */
    public function getProtocolsForPatient($initial_date, $ended_date, $patient_id) 
    {
        return $this->model
            ->whereBetween('completion_date', [$initial_date, $ended_date])
            ->orderBy('completion_date', 'ASC')
            ->where('patient_id', $patient_id)
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

    public function getPendingProtocols() {
        return $this->model
            ->where('closed', null)
            ->get();
    }

    public function getSumOfAllSocialWorksProtocols() {
        $practices = DB::table('practices')
            ->select('protocol_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('protocol_id');
      
        return $this->model
            ->select(DB::raw('SUM(practices.total_amount) as total_amount'))
            ->joinSub($practices, 'practices', function ($join) {
                $join->on('internal_protocols.id', '=', 'practices.protocol_id');
            })
            ->whereNotNull('internal_protocols.plan_id')
            ->get()
            ->first();
    }

    public function closeProtocol($id) {
        $protocol = $this->model->findOrFail($id);

        return $protocol->update(['closed' => date('Y-m-d H:m:s')]);
    }
}
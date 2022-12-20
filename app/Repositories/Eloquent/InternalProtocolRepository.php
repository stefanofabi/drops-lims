<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;

use App\Models\InternalProtocol; 

final class InternalProtocolRepository implements InternalProtocolRepositoryInterface
{
    protected $model;

    /**
     * InternalProtocolRepository constructor.
     *
     * @param InternalProtocol $protocol
     */
    public function __construct(InternalProtocol $protocol)
    {
        $this->model = $protocol;
    }

    public function all()
    {
        return $this->model->orderBy('completion_date', 'DESC')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        // eloquent will modify only the $fillable fields declared in the model
        
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
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
            ->select('internal_protocols.id', 'internal_protocols.completion_date', 'internal_protocols.closed', 'internal_protocols.internal_patient_id', 'internal_patients.full_name as patient', 'prescribers.full_name as prescriber')
            ->join('internal_patients', 'internal_protocols.internal_patient_id', '=', 'internal_patients.id')
            ->join('prescribers', 'internal_protocols.prescriber_id', '=', 'prescribers.id')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("internal_protocols.id", "like", "$filter%")
                        ->orWhere("internal_patients.full_name", "ilike", "%$filter%")
                        ->orWhere("internal_patients.identification_number", "like", "$filter%");
                }
            })
            ->orderBy('completion_date', 'desc')
            ->orderBy('internal_protocols.id', 'desc')
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
            ->where('internal_patient_id', $patient_id)
            ->get();
    }
    
    /*
    * Returns a list with the monthly collection of each social work on the specified dates
    */
    public function getCollectionSocialWork($social_work_id, $start_date, $end_date) 
    {
        return $this->model
            ->select(DB::raw('EXTRACT(MONTH FROM internal_protocols.completion_date) as month'), DB::raw('EXTRACT(YEAR FROM internal_protocols.completion_date) as year'), DB::raw('SUM(internal_practices.price) as total'))
            ->join('plans', 'internal_protocols.plan_id', '=', 'plans.id')
            ->join('social_works', 'plans.social_work_id', '=', 'social_works.id')
            ->join('internal_practices', 'internal_protocols.id', '=', 'internal_practices.internal_protocol_id')
            ->where('social_works.id', $social_work_id)
            ->whereBetween('internal_protocols.completion_date', [$start_date, $end_date])
            ->groupBy(DB::raw("EXTRACT(MONTH FROM internal_protocols.completion_date)"), DB::raw("EXTRACT(YEAR FROM internal_protocols.completion_date)"))
            ->orderBy(DB::raw("EXTRACT(YEAR FROM internal_protocols.completion_date)"), 'ASC')
            ->orderBy(DB::raw("EXTRACT(MONTH FROM internal_protocols.completion_date)"), 'ASC')
            ->get();
    }

    /*
    * Returns a list with the monthly flow of patients on the specified dates
    */
    public function getPatientFlow($start_date, $end_date) 
    {
        return $this->model
            ->select(DB::raw('EXTRACT(MONTH FROM internal_protocols.completion_date) as month'), DB::raw('EXTRACT(YEAR FROM internal_protocols.completion_date) as year'), DB::raw('COUNT(*) as total'))
            ->whereBetween('internal_protocols.completion_date', [$start_date, $end_date])
            ->groupBy(DB::raw('EXTRACT(MONTH FROM internal_protocols.completion_date)'), DB::raw('EXTRACT(YEAR FROM internal_protocols.completion_date)'))
            ->orderBy(DB::raw("EXTRACT(YEAR FROM internal_protocols.completion_date)"), 'ASC')
            ->orderBy(DB::raw("EXTRACT(MONTH FROM internal_protocols.completion_date)"), 'ASC')
            ->get();
    }

    /*
    * Returns a list the monthly collection of the laboratory on the specified dates
    */
    public function getTrackIncome($start_date, $end_date) 
    {
        return $this->model
            ->select(DB::raw("EXTRACT(MONTH FROM internal_protocols.completion_date) as month"), DB::raw("EXTRACT(YEAR FROM internal_protocols.completion_date) as year"), DB::raw('SUM(internal_practices.price) as total'))
            ->join('internal_practices', 'internal_protocols.id', '=', 'internal_practices.internal_protocol_id')
            ->whereBetween('internal_protocols.completion_date', [$start_date, $end_date])
            ->groupBy(DB::raw('EXTRACT(MONTH FROM internal_protocols.completion_date)'), DB::raw('EXTRACT(YEAR FROM internal_protocols.completion_date)'))
            ->orderBy(DB::raw("EXTRACT(YEAR FROM internal_protocols.completion_date)"), 'ASC')
            ->orderBy(DB::raw("EXTRACT(MONTH FROM internal_protocols.completion_date)"), 'ASC')
            ->get();
    }

    public function getPendingProtocols() 
    {
        return $this->model
            ->where('closed', null)
            ->get();
    }

    public function getSumOfAllSocialWorksProtocols() 
    {
        $practices = DB::table('internal_practices')
            ->select('internal_protocol_id', DB::raw('SUM(price) as total_amount'))
            ->groupBy('internal_protocol_id');
      
        return $this->model
            ->select(DB::raw('SUM(internal_practices.total_amount) as total_amount'))
            ->joinSub($practices, 'internal_practices', function ($join) {
                $join->on('internal_protocols.id', '=', 'internal_practices.internal_protocol_id');
            })
            ->whereNotNull('internal_protocols.plan_id')
            ->get()
            ->first();
    }

    public function increment($id, $attribute, $value)
    {
        $this->model->where('id', $id)->increment($attribute, $value);
    }

    public function decrement($id, $attribute, $value)
    {
        $this->model->where('id', $id)->decrement($attribute, $value);
    }
    
    /*
    * Returns true if it was able to close the protocol, false otherwise
    */
    public function close($id) 
    {
        // closed field is protected by the eloquent model
        $protocol = $this->model->findOrFail($id);
        $protocol->closed = date('Y-m-d H:m:s');

        return $protocol->save();
    }
}
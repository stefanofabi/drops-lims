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
        // patient id is protected against mass allocation
        $this->model->completion_date = $data['completion_date'];
        $this->model->internal_patient_id = $data['internal_patient_id'];
        $this->model->plan_id = $data['plan_id'];
        $this->model->prescriber_id = $data['prescriber_id'];
        $this->model->quantity_orders = $data['quantity_orders'];
        $this->model->billing_period_id = $data['billing_period_id'] ?? NULL;

        $this->model->save();

        return $this->model;
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
            ->orderBy('id', 'ASC')
            ->get();
    }

    /*
    * Returns a list of protocols between two specified dates for a particular patient
    */
    public function getProtocolsForPatient($initial_date, $ended_date, $patient_id) 
    {
        return $this->model
            ->whereBetween('completion_date', [$initial_date, $ended_date])
            ->orderBy('completion_date', 'DESC')
            ->where('internal_patient_id', $patient_id)
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

    public function incrementPracticePrice($id, $value)
    {
        $this->model->where('id', $id)->increment('total_price', $value);
    }

    public function decrementPracticePrice($id, $value)
    {
        $this->model->where('id', $id)->decrement('total_price', $value);
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
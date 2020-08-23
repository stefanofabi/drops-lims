<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Practice;

class Protocol extends Model
{
    //

    protected function index($filter, $offset, $length) {

    	/* ID - COMPLETION_DATE - PATIENT_ID - PATIENT - TYPE */
	 	$derived_protocols = DB::table('protocols')
	 	->select('protocols.id', 'protocols.completion_date', 'derived_patients.id as patient_id', 'derived_patients.full_name as patient', DB::raw('"derived" as type'))
		->join('derived_protocols', 'protocols.id', '=', 'derived_protocols.protocol_id')
		->join('derived_patients', 'derived_protocols.patient_id', '=', 'derived_patients.id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("protocols.id", "like", "$filter%")
				->orWhere("derived_patients.full_name", "like", "%$filter%")
				->orWhere("derived_patients.key", "like", "$filter%");
			}
		});


		$protocols = DB::table('our_protocols')
		->select('protocols.id', 'protocols.completion_date as completion_date', 'patients.id as patient_id', 'patients.full_name as patient', DB::raw('"our" as type'))
		->join('patients', 'patients.id', '=', 'our_protocols.patient_id')
		->join('protocols', 'protocols.id', '=', 'our_protocols.protocol_id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("protocols.id", "like", "$filter%")
				->orWhere("patients.full_name", "like", "%$filter%")
				->orWhere("patients.key", "like", "$filter%")
				->orWhere("patients.owner", "like", "%$filter%");
			}
		})
		->whereNull('patients.deleted_at')
		->whereNull('protocols.deleted_at')
		->union($derived_protocols)
		->orderBy('id', 'desc')
		->get();


		return $protocols;
	}


	protected function count_index($filter) {
	 	$derived_protocols_count = DB::table('protocols')
		->join('derived_protocols', 'protocols.id', '=', 'derived_protocols.protocol_id')
		->join('derived_patients', 'derived_protocols.patient_id', '=', 'derived_patients.id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("derived_patients.full_name", "like", "%$filter%")
				->orWhere("derived_patients.key", "like", "$filter%");
			}
		})
		->count();


		$our_protocols_count = DB::table('our_protocols')
		->join('patients', 'patients.id', '=', 'our_protocols.patient_id')
		->join('protocols', 'protocols.id', '=', 'our_protocols.protocol_id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("protocols.id", "like", "$filter%")
				->orWhere("patients.full_name", "like", "%$filter%")
				->orWhere("patients.key", "like", "$filter%")
				->orWhere("patients.owner", "like", "%$filter%");
			}
		})
		->whereNull('patients.deleted_at')
		->whereNull('protocols.deleted_at')
		->count();

		$total_count = $our_protocols_count + $derived_protocols_count;

		return $total_count;
	}

	public function practices()
    {
        return $this->hasMany('App\Practice', 'protocol_id');
    }

    public function scopePractices($query) {
		return $query->join('practices', 'protocols.id', '=', 'practices.protocol_id');
	}

    public function scopeOurProtocol($query) {
        return $query->join('our_protocols', 'protocols.id', '=', 'our_protocols.protocol_id');
    }

    public function scopePatient($query) {
        return $query->join('patients', 'our_protocols.patient_id', '=', 'patients.id');
    }
}

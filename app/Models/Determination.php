<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Report;

class Determination extends Model
{
    //

	use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $fillable = ['nomenclator_id', 'code', 'name', 'position', 'biochemical_unit'];

    /**
     * Get the determinations for the query.
     */
	protected function index($nomenclator_id, $filter, $offset, $length) {
		return DB::table('determinations')
            ->where('nomenclator_id', '=', $nomenclator_id)
            ->where(function ($query) use ($filter) {
                if (!empty($filter)) {
                    $query->orWhere("name", "like", "%$filter%")
                    ->orWhere("code", "like", "$filter%");
                }
            })
            ->whereNull('deleted_at')
            ->orderBy('code', 'asc')
            ->orderBy('name', 'asc')
            ->offset($offset)
            ->limit($length)
            ->get();
	}

    /**
     * Get the reports for the determination.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get the nomenclator associated with the determination.
     */
	public function nomenclator() {
		return $this->belongsTo('App\Models\Nomenclator');
	}
}

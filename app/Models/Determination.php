<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Determination extends Model
{
    //

	use HasFactory;

    use LogsActivity;

	protected $fillable = [
        'nomenclator_id', 
        'code', 
        'name', 
        'position', 
        'report',
        'biochemical_unit',
    ];

    /**
     * Get the nomenclator associated with the determination.
     */
	public function nomenclator() 
    {
		return $this->belongsTo(Nomenclator::class);
	}

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}

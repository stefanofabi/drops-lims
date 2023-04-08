<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\GenerateReplacementVariables;

class Determination extends Model
{
    //

	use HasFactory;

    use LogsActivity;

    use GenerateReplacementVariables;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'code', 
        'name', 
        'position',
        'biochemical_unit',
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'template_variables' => 'json',
    ];

    /**
     * Get the nomenclator associated with the determination.
     */
	public function nomenclator() 
    {
		return $this->belongsTo(Nomenclator::class);
	}

    public function getPrice($nbu_price) 
    {
        return $this->biochemical_unit * $nbu_price;
    }

    public function getReplacementVariables() 
    {
        return $this->generateReplacementVariables($this->template_variables);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}

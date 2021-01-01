<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    //

    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'full_name',
        'key',
        'sex',
        'birth_date',
        'city',
        'address',
        'owner',
        'business_name',
        'tax_condition',
        'start_activity',
        'type',
    ];

    protected function index($filter, $offset, $length, $type)
    {
        $patients = DB::table('patients')->where('type', $type)->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("full_name", "like", "%$filter%")->orWhere("key", "like", "$filter%")->orWhere("owner", "like", "%$filter%");
                }
            })->whereNull('deleted_at')->orderBy('full_name', 'asc')->offset($offset)->limit($length)->get();

        return $patients;
    }

    /**
     * Get the phones for the patient.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Get the emails for the patient.
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Get the affiliates for the patient.
     */
    public function affiliates()
    {
        return $this->hasMany(Affiliate::class);
    }
}

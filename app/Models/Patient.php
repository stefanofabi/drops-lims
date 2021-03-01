<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends Model
{
    //

    use HasFactory;

    use LogsActivity;

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

    protected static $logAttributes = ['full_name', 'key', 'owner', 'business_name', 'type'];

    protected function index($filter, $offset, $length, $type)
    {
        $patients = DB::table('patients')->where('type', $type)
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("full_name", "like", "%$filter%")
                        ->orWhere("key", "like", "$filter%")
                        ->orWhere("owner", "like", "%$filter%");
                }
            })
            ->orderBy('full_name', 'asc')
            ->offset($offset)
            ->limit($length)
            ->get();

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

    /**
     * Get the security code associated with the patient.
     */
    public function security_code()
    {
        return $this->hasOne(SecurityCode::class);
    }

    public function age()
    {

        $age = null;

        $date = $this->birth_date;

        if (! empty($date)) {
            $birth_date = new \DateTime(date('Y/m/d', strtotime($date)));
            $date_today = new \DateTime(date('Y/m/d', time()));

            if ($date_today >= $birth_date) {
                $diff = date_diff($date_today, $birth_date);

                $age = [
                    'day' => ceil($diff->format('%d')),
                    'year' => ceil($diff->format('%Y')),
                    'month' => ceil($diff->format('%m')),
                ];
            }
        }

        return $age;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Prescriber extends Model
{
    //

    use HasFactory;

    use LogsActivity;

    protected $fillable = ['full_name', 'phone', 'email', 'provincial_enrollment', 'national_enrollment'];

    protected static $logFillable = true;

    protected function index($filter, $offset, $length)
    {
        $prescribers = DB::table('prescribers')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("full_name", "like", "%$filter%")
                        ->orWhere("provincial_enrollment", "like", "$filter%")
                        ->orWhere("national_enrollment", "like", "$filter%");
                }
            })
            ->orderBy('full_name', 'asc')
            ->offset($offset)
            ->limit($length)
            ->get();

        return $prescribers;
    }
}

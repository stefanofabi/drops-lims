<?php

namespace App\Observers;

use App\Models\InternalPatient;

class InternalPatientObserver
{
    /**
     * Handle the InternalPatient "created" event.
     *
     * @param  \App\Models\InternalPatient  $internalPatient
     * @return void
     */
    public function created(InternalPatient $internalPatient)
    {
        //
    }

    /**
     * Handle the InternalPatient "updated" event.
     *
     * @param  \App\Models\InternalPatient  $internalPatient
     * @return void
     */
    public function updated(InternalPatient $internalPatient)
    {
        //
    }

    /**
     * Handle the InternalPatient "deleted" event.
     *
     * @param  \App\Models\InternalPatient  $internalPatient
     * @return void
     */
    public function deleted(InternalPatient $internalPatient)
    {
        //
    }

    /**
     * Handle the InternalPatient "restored" event.
     *
     * @param  \App\Models\InternalPatient  $internalPatient
     * @return void
     */
    public function restored(InternalPatient $internalPatient)
    {
        //
    }

    /**
     * Handle the InternalPatient "force deleted" event.
     *
     * @param  \App\Models\InternalPatient  $internalPatient
     * @return void
     */
    public function forceDeleted(InternalPatient $internalPatient)
    {
        //
    }

    /**
     * Handle the InternalPatient "saving" event.
     *
     * @param  \App\Models\InternalPatient  $internalPatient
     * @return void
     */
    public function saving(InternalPatient $internalPatient)
    {
        //

        $internalPatient->full_name = "$internalPatient->last_name $internalPatient->name";
    }
}

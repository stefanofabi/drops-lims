<?php

namespace App\Observers;

use App\Models\Prescriber;

class PrescriberObserver
{
    /**
     * Handle the Prescriber "created" event.
     *
     * @param  \App\Models\Prescriber  $prescriber
     * @return void
     */
    public function created(Prescriber $prescriber)
    {
        //
    }

    /**
     * Handle the Prescriber "updated" event.
     *
     * @param  \App\Models\Prescriber  $prescriber
     * @return void
     */
    public function updated(Prescriber $prescriber)
    {
        //
    }

    /**
     * Handle the Prescriber "deleted" event.
     *
     * @param  \App\Models\Prescriber  $prescriber
     * @return void
     */
    public function deleted(Prescriber $prescriber)
    {
        //
    }

    /**
     * Handle the Prescriber "restored" event.
     *
     * @param  \App\Models\Prescriber  $prescriber
     * @return void
     */
    public function restored(Prescriber $prescriber)
    {
        //
    }

    /**
     * Handle the Prescriber "force deleted" event.
     *
     * @param  \App\Models\Prescriber  $prescriber
     * @return void
     */
    public function forceDeleted(Prescriber $prescriber)
    {
        //
    }

    /**
     * Handle the Prescriber "saving" event.
     *
     * @param  \App\Models\Prescriber  $prescriber
     * @return void
     */
    public function saving(Prescriber $prescriber)
    {
        //

        $prescriber->full_name = "$prescriber->last_name $prescriber->name";
    }
}

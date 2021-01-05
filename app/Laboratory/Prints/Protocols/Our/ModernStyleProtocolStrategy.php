<?php

namespace App\Laboratory\Prints\Protocols\Our;

use App\Models\OurProtocol;
use App\Laboratory\Prints\Protocols\PrintProtocolStrategyInterface;

use PDF;
use Lang;

class ModernStyleProtocolStrategy implements PrintProtocolStrategyInterface
{
    /**
     * Returns a report in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print($protocol_id, $filter_practices = [])
    {
        $our_protocol = OurProtocol::findOrFail($protocol_id);
        $protocol = $our_protocol->protocol;
        $practices = $protocol->practices;

        if (! empty($filter_practices)) {
            $practices = $practices->whereIn('id', $filter_practices);
        }

        if ($this->haveResults($practices)) {
            return Lang::get('protocols.empty_protocol');
        }

        $pdf = PDF::loadView('pdf/protocols/modern_style', [
            'our_protocol' => $our_protocol,
            'practices' => $practices,
        ]);

        $protocol_name = "protocol_$protocol->id";

        if ($protocol->practices->count() != $practices->count()) {
            $protocol_name = 'partial_'.$protocol_name;
        }

        return $pdf->stream($protocol_name);
    }

    public function haveResults($practices)
    {
        /* Returns true if there is at least one reported practice, false otherwise */
        $have_results = false;

        foreach ($practices as $practice) {
            if ($practice->results->isNotEmpty()) {
                $have_results = true;
            }
        }

        return $have_results;
    }
}

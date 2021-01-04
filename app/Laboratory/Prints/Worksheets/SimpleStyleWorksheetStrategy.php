<?php

namespace App\Laboratory\Prints\Worksheets;

use App\Laboratory\Prints\Worksheets\PrintWorksheetStrategyInterface;
use App\Models\OurProtocol;

use Lang;
use PDF;

class SimpleStyleWorksheetStrategy implements PrintWorksheetStrategyInterface
{
    /**
     * Returns a worksheet in pdf
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

        $pdf = PDF::loadView('pdf/worksheets/simple_style', [
            'our_protocol' => $our_protocol,
            'practices' => $practices,
        ]);

        return $pdf->stream('worksheet_'.$protocol->id.'.pdf');
    }
}

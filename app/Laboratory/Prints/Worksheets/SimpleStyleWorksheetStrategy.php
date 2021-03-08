<?php

namespace App\Laboratory\Prints\Worksheets;

use App\Laboratory\Prints\Worksheets\PrintWorksheetStrategyInterface;
use App\Repositories\Eloquent\ProtocolRepository;

use PDF;

final class SimpleStyleWorksheetStrategy implements PrintWorksheetStrategyInterface
{

    /** @var \App\Laboratory\Repositories\Protocols\ProtocolRepository */
    private $protocolRepository;    
    
    public function __construct () 
    {
        $this->protocolRepository = resolve(ProtocolRepository::class);
    }   

    /**
     * Returns a worksheet in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print($protocol_id, $filter_practices = [])
    {
        $protocol = $this->protocolRepository->findOrFail($protocol_id);

        if (empty($filter_practices)) {
            $practices = $protocol->practices;
        } else {
            $practices = $practices->whereIn('id', $filter_practices);
        }

        $pdf = PDF::loadView('pdf/worksheets/simple_style', [
            'protocol' => $protocol,
            'practices' => $practices,
        ]);

        return $pdf->stream('worksheet_'.$protocol->id.'.pdf');
    }
}

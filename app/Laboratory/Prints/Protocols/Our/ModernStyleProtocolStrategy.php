<?php

namespace App\Laboratory\Prints\Protocols\Our;

use App\Laboratory\Prints\Protocols\PrintProtocolStrategyInterface;
use App\Models\Protocol;

use PDF;

class ModernStyleProtocolStrategy implements PrintProtocolStrategyInterface
{

    /** @var \App\Models\Protocol */
    private $protocol;    
    
    private $filter_practices;

    public function __construct (Protocol $protocol, array $filter_practices = []) 
    {
        $this->protocol = $protocol;
        $this->filter_practices = $filter_practices;
    }   

    /**
     * Returns a report in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print()
    {

        $practices = $this->protocol->practices;

        if (! empty($this->filter_practices)) {
            $practices = $practices->whereIn('id', $this->filter_practices);
        }

        $pdf = PDF::loadView('pdf/protocols/modern_style', [
            'protocol' => $this->protocol,
            'practices' => $practices,
        ]);

        $protocol_name = 'protocol_'.$this->protocol->id.'.pdf';
        $protocol_path = storage_path("app/protocols/$protocol_name");
        $pdf->save($protocol_path);
        
        return $pdf->stream($protocol_name);
    }
}

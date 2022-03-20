<?php

namespace App\Laboratory\Prints\Protocols\Our;

use App\Laboratory\Prints\Protocols\PrintProtocolStrategyInterface;
use App\Repositories\Eloquent\ProtocolRepository;

use PDF;
use Lang;

class ModernStyleProtocolStrategy implements PrintProtocolStrategyInterface
{

    /** @var \App\Laboratory\Repositories\Protocols\ProtocolRepository */
    private $protocolRepository;    
    
    public function __construct () 
    {
        $this->protocolRepository = resolve(ProtocolRepository::class);
    }   

    /**
     * Returns a report in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function printProtocol($protocol_id, $filter_practices = [])
    {
        $protocol = $this->protocolRepository->findOrFail($protocol_id);

        $practices = $protocol->practices;

        if (! empty($filter_practices)) {
            $practices = $practices->whereIn('id', $filter_practices);
        }
        
        if (! $this->practicesHaveSignatures($practices)) {
            return Lang::get('protocols.empty_protocol');
        }

        $pdf = PDF::loadView('pdf/protocols/modern_style', [
            'protocol' => $protocol,
            'practices' => $practices,
        ]);

        $protocol_name = "protocol_$protocol->id";

        if ($protocol->practices->count() != $practices->count()) {
            $protocol_name = 'partial_'.$protocol_name;
        }

        return $pdf->stream($protocol_name);
    }

    private function practicesHaveSignatures($practices)
    {
        /* Returns true if all selected practices are signed, false otherwise */
        $have_signatures = true;

        foreach ($practices as $practice) {
            if ($practice->signs->isEmpty()) {
                $have_signatures = false;
                break;
            }
        }

        return $have_signatures;
    }
}

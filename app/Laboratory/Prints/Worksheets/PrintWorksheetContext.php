<?php

namespace App\Laboratory\Prints\Worksheets;

use App\Laboratory\Prints\Worksheets\PrintWorksheetStrategyInterface;
use App\Laboratory\Prints\Worksheets\SimpleStyleWorksheetStrategy;

use RuntimeException;

final class PrintWorksheetContext
{
    const STRATEGIES = [
        'simple_style' => SimpleStyleWorksheetStrategy::class,
    ];

    private $strategy;

    /**
     * Call strategy print() method.
     */
    public function printWorksheet($protocol_id, $filter_practices = [])
    {
        if (is_null($this->strategy)) {
            throw new RuntimeException('Missing strategy');    
        }

        return $this->strategy->printWorksheet($protocol_id, $filter_practices);
    }

    public function setStrategy(PrintWorksheetStrategyInterface $strategy) {
        $this->strategy = $strategy;
    }

    public function getStrategy() { 
        return $this->strategy; 
    } 
}

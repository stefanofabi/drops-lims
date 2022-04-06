<?php

namespace App\Laboratory\Prints\Protocols\Our;

use App\Laboratory\Prints\Protocols\PrintProtocolStrategyInterface;
use App\Laboratory\Prints\Protocols\Our\ModernStyleProtocolStrategy;

use RuntimeException;

final class PrintOurProtocolContext
{
    const STRATEGIES = [
        'modern_style' => ModernStyleProtocolStrategy::class,
    ];

    /**
     * Call strategy print() method.
     */
    public function print()
    {
        if (is_null($this->strategy)) {
            throw new RuntimeException('Missing strategy');    
        }

        return $this->strategy->print();
    }

    public function setStrategy(PrintProtocolStrategyInterface $strategy) 
    {
        $this->strategy = $strategy;
    }

    public function getStrategy() 
    { 
        return $this->strategy; 
    } 
}

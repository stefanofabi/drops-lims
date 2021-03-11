<?php

namespace App\Laboratory\Prints\SecurityCodes;

use App\Laboratory\Prints\SecurityCodes\PrintSecurityCodeStrategyInterface;
use App\Laboratory\Prints\SecurityCodes\ModernStyleStrategy;

use RuntimeException;

final class PrintSecurityCodeContext
{
    const STRATEGIES = [
        'modern_style' => ModernStyleStrategy::class,
    ];

    /**
     * Call strategy print() method.
     */
    public function print_security_code($patient, $security_code, $expiration_date)
    {
        if (is_null($this->strategy)) {
            throw new RuntimeException('Missing strategy');    
        }

        return $this->strategy->print_security_code($patient, $security_code, $expiration_date);
    }

    public function setStrategy(PrintSecurityCodeStrategyInterface $strategy) 
    {
        $this->strategy = $strategy;
    }

    public function getStrategy() 
    { 
        return $this->strategy; 
    } 
}

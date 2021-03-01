<?php

namespace App\Laboratory\Prints\SecurityCodes;

final class PrintSecurityCodeContext
{
    const STRATEGIES = [
        'modern_style' => ModernStyleStrategy::class,
    ];
}

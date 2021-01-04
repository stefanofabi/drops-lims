<?php

namespace App\Laboratory\Prints\SecurityCodes;

final class PrintSecurityCodeContext
{
    const STRATEGIES = [
        'basic_style' => BasicStyleStrategy::class,
    ];
}

<?php

namespace App\Helpers;

use App\Contracts\Repository\SystemParameterRepositoryInterface;

class Drops 
{
    public static function getSystemParameterValueByKey($parameter_key) {
        $systemParameterRepository = resolve(SystemParameterRepositoryInterface::class);

        return $systemParameterRepository->findByKeyOrFail($parameter_key)->value;
    }
}
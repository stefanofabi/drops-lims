<?php

namespace App\Laboratory\Prints\SecurityCodes;

interface PrintSecurityCodeStrategyInterface
{
    /**
     * Print a protocol allowing filtering by practices
     *
     * @param $protocol_id
     * @param array $filter_practices
     * @return \Illuminate\Http\Response
     */
    public function print_security_code($patient, $security_code, $expiration_date);
}

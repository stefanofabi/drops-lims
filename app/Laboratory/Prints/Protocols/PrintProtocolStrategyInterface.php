<?php

namespace App\Laboratory\Prints\Protocols;

interface PrintProtocolStrategyInterface
{
    /**
     * Print a protocol
     *
     * @param $protocol_id
     * @param array $filter_practices
     * @return \Illuminate\Http\Response
     */
    public function print();
}

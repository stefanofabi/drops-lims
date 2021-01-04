<?php

namespace App\Laboratory\Prints\Worksheets;

interface PrintWorksheetStrategyInterface
{
    /**
     * Print a protocol allowing filtering by practices
     *
     * @param $protocol_id
     * @param array $filter_practices
     * @return \Illuminate\Http\Response
     */
    public function print($protocol_id, $filter_practices = []);
}

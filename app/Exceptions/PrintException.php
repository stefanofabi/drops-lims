<?php

namespace App\Exceptions;

use Exception;

class PrintException extends Exception
{
    //

    /**
     * Render an exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
    	return $this->getMessage();
    }
}

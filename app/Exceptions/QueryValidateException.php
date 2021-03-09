<?php

namespace App\Exceptions;

use Exception;

class QueryValidateException extends Exception
{
    //

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
    	return back()->withInput($request->all())->withErrors($this->getMessage());
    }
}

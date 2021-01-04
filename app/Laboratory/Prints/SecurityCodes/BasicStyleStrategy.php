<?php

namespace App\Laboratory\Prints\SecurityCodes;

use Lang;
use PDF;

class BasicStyleStrategy implements PrintSecurityCodeStrategyInterface
{
    /**
     * Returns a security code to patient in pdf
     *
     * @param $patient
     * @param $security_code
     * @param $expiration_date
     * @return \Illuminate\Http\Response
     */
    public function print_security_code($patient, $security_code, $expiration_date)
    {

        $pdf = PDF::loadView('pdf/security_codes/basic_style', [
            'patient' => $patient,
            'security_code' => $security_code,
            'expiration_date' => $expiration_date,
        ]);

        return $pdf->stream('security_code_for'.$patient->id.'.pdf');
    }
}

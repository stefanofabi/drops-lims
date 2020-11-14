<?php

namespace App\Http\Traits;

use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

use Lang;

trait PrintSecurityCode {
    /**
     * Returns a report in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_security_code($patient_id, $patient_full_name, $security_code, $expiration_date)
    {
        try {
            ob_start();
            include('Templates/Others/security_code_001.php');
            $content = ob_get_clean();

            $html2pdf = new Html2Pdf('P', 'A4', str_replace('_', '-', app()->getLocale()));
            $html2pdf->pdf->SetTitle(Lang::get('patients.security_code_for', ['id' => $patient_id]));
            $html2pdf->setDefaultFont('Arial');

            $html2pdf->writeHTML($content);
            $html2pdf->output(Lang::get('patients.security_code_for', ['id' => $patient_id]).'.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}

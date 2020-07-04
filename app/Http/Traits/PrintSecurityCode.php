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
            include('pdf/security_code_001.php');
            $content = ob_get_clean();

            $html2pdf = new Html2Pdf('P', 'A4', str_replace('_', '-', app()->getLocale()));
            $html2pdf->pdf->SetTitle(Lang::get('protocols.report_for_protocol')." #$patient_id");
            $html2pdf->setDefaultFont('Arial');

            $html2pdf->writeHTML($content);
            $html2pdf->output("security_code_for_patient_$patient_id.pdf");
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}

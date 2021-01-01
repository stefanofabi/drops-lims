<?php

namespace App\Http\Traits;

use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

use App\Models\OurProtocol;

use Lang;

trait PrintWorksheet {

    /**
     * Returns a worksheet in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_worksheet($protocol_id)
    {
        $our_protocol = OurProtocol::findOrFail($protocol_id);
        $protocol = $our_protocol->protocol;
        $prescriber = $our_protocol->prescriber;
        $patient = $our_protocol->patient;
        $plan = $our_protocol->plan;
        $social_work = $plan->social_work;
        $practices = $our_protocol->protocol->practices;
        $phone = $patient->phones->first();

        try {
            ob_start();
            include('Templates/Worksheets/worksheet_001.php');
            $content = ob_get_clean();

            $html2pdf = new Html2Pdf('P', 'A4', str_replace('_', '-', app()->getLocale()));
            $html2pdf->pdf->SetTitle(Lang::get('protocols.worksheet_for_protocol')." #$protocol_id");
            $html2pdf->setDefaultFont('Arial');

            $html2pdf->writeHTML($content);
            $html2pdf->output("protocol_$protocol_id.pdf");
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

}

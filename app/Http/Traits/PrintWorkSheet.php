<?php

namespace App\Http\Traits;

use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

use App\Models\OurProtocol;

use Lang;

trait PrintWorkSheet {

    /**
     * Returns a worksheet in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_worksheet($protocol_id)
    {
        $protocol = OurProtocol::protocol()->findOrFail($protocol_id);
        $prescriber = $protocol->prescriber()->first();
        $patient = $protocol->patient()->first();
        $plan = $protocol->plan()->first();
        $social_work = $plan->social_work()->first();
        $practices = $protocol->practices;
        $phone = $patient->phone()->first();

        try {
            ob_start();
            include('pdf/worksheet_001.php');
            $content = ob_get_clean();

            $html2pdf = new Html2Pdf('P', 'A4', str_replace('_', '-', app()->getLocale()));
            $html2pdf->pdf->SetTitle(Lang::get('protocols.worksheet_for_protocol')." #$protocol->id");
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

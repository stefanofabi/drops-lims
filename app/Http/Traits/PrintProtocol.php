<?php

namespace App\Http\Traits;

use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

use App\Models\OurProtocol;

use Lang;

trait PrintProtocol {

    /**
     * Returns a report in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print($protocol_id, $filter_practices = array())
    {
        $protocol = OurProtocol::protocol()->findOrFail($protocol_id);
        $prescriber = $protocol->prescriber()->first();
        $patient = $protocol->patient()->first();
        $plan = $protocol->plan()->first();
        $social_work = $plan->social_work()->first();

        try {
            if (empty($filter_practices)) {
                $practices = $protocol->practices()->get();
            } else {
                $practices = $protocol->practices()->get()->whereIn('id', $filter_practices);
            }

            if (!$this->haveResults($practices)) {
            	exit('No hay practicas informadas');
            }

            $phone = $patient->phone()->first();

            ob_start();
            include('Templates/Reports/report_001.php');
            $content = ob_get_clean();

            $html2pdf = new Html2Pdf('P', 'A4', str_replace('_', '-', app()->getLocale()));
            $html2pdf->pdf->SetTitle(Lang::get('protocols.report_for_protocol')." #$protocol->id");
            $html2pdf->setDefaultFont('Arial');

            $html2pdf->writeHTML($content);
            $html2pdf->output("protocol_$protocol_id.pdf");
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

    public function haveResults($practices) {
    	/* Returns true if there is at least one reported practice, false otherwise */
    	
    	$count = 0;

        foreach($practices as $practice) {
        	$count += $practice->results->count();

        	if ($count) {
            	break;
            }
        }

        return $count > 0;
    }
}

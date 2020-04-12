<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

use App\Patient;
use App\Affiliate;
use App\Protocol;
use App\OurProtocol;
use App\Prescriber;
use Lang;

class OurProtocolController extends Controller
{

	private const RETRIES = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $patient_id = $request->patient_id;
        $patient = Patient::find($patient_id);

        $social_works = Affiliate::get_social_works($patient_id);

        return view('protocols/our/create')
        ->with('patient', $patient)
        ->with('social_works', $social_works);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = DB::transaction(function () use ($request) {

            $protocol = Protocol::insertGetId([
                'completion_date' => $request->completion_date, 
                'observations' => $request->observations,
            ]);

            OurProtocol::insert([
            	'protocol_id' => $protocol,
                'patient_id' => $request->patient_id, 
                'plan_id' => $request->plan_id,
                'prescriber_id' => $request->prescriber_id,
                'quantity_orders' => $request->quantity_orders,
                'diagnostic' => $request->diagnostic,
            ]);

            return $protocol;
        }, self::RETRIES);


        return redirect()->action('OurProtocolController@show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $protocol = OurProtocol::protocol()->findOrFail($id);
        $prescriber = $protocol->prescriber()->first();
        $patient = $protocol->patient()->first();
        $plan = $protocol->plan()->first();
        $social_work = $plan->social_work()->first();

        $practices = $protocol->practices;

        return view('protocols/our/show')
        ->with('protocol', $protocol)
        ->with('patient', $patient)
        ->with('social_work', $social_work)
        ->with('plan', $plan)
        ->with('prescriber', $prescriber)
        ->with('practices', $practices);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $protocol = OurProtocol::protocol()->findOrFail($id);
        $prescriber = $protocol->prescriber()->first();
        $patient = $protocol->patient()->first();
        $plan = $protocol->plan()->first();

        $practices = $protocol->practices;

        $social_works = Affiliate::get_social_works($patient->id);

        return view('protocols/our/edit')
        ->with('protocol', $protocol)
        ->with('patient', $patient)
        ->with('plan', $plan)
        ->with('social_works', $social_works)
        ->with('prescriber', $prescriber)
        ->with('practices', $practices);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        DB::transaction(function () use ($request, $id) {
            Protocol::where('id', $id)
            ->update(
                [
                    'completion_date' => $request->completion_date,
                    'observations' => $request->observations,
                ]
            );

            OurProtocol::where('protocol_id', $id)
            ->update(
                [
                    'plan_id' => $request->plan_id,
                    'prescriber_id' => $request->prescriber_id,
                    'quantity_orders' => $request->quantity_orders,
                    'diagnostic' => $request->diagnostic,
                ]
            );

        }, self::RETRIES);


        return redirect()->action('OurProtocolController@show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Returns a list of filtered patients
     *
     * @return \Illuminate\Http\Response
     */
    public function load_patients(Request $request)
    {
        // label column is required
        $filter = $request->filter;

        $patients = Patient::select('full_name as label', 'id')
        ->where(function ($query) use ($filter) {
            if (!empty($filter)) {
                $query->orWhere("full_name", "like", "%$filter%")
                ->orWhere("key", "like", "$filter%")
                ->orWhere("owner", "like", "%$filter%");
            }
        })
        ->get()
        ->toJson();

        return $patients;
    }

    /**
     * Returns a list of filtered prescribers
     *
     * @return \Illuminate\Http\Response
     */
    public function load_prescribers(Request $request)
    {
        // label column is required
        $filter = $request->filter;

        $prescribers = Prescriber::select('full_name as label', 'id')
        ->where(function ($query) use ($filter) {
            if (!empty($filter)) {
                $query->orWhere("full_name", "like", "%$filter%")
                ->orWhere("provincial_enrollment", "like", "$filter%")
                ->orWhere("national_enrollment", "like", "$filter%");
            }
        })
        ->get()
        ->toJson();

        return $prescribers;
    }

    /**
     * Returns a view for add practices
     *
     * @return \Illuminate\Http\Response
     */
    public function add_practices($protocol_id)
    {
            
        $protocol = OurProtocol::protocol()->findOrFail($protocol_id);
        $plan = $protocol->plan->first();
        $nomenclator = $plan->nomenclator; 

        return view('protocols/our/add_practices')
        ->with('protocol', $protocol)
        ->with('nomenclator', $nomenclator);
    }

    /**
     * Returns a list of practices for a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public static function get_practices($protocol_id) {
        $protocol = OurProtocol::protocol()->findOrFail($protocol_id);

        return $protocol->practices;
    }

    /**
     * Returns a worksheet in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_worksheet($protocol_id)
    {

        try {
            $protocol = OurProtocol::protocol()->findOrFail($protocol_id);
            $prescriber = $protocol->prescriber()->first();
            $patient = $protocol->patient()->first();
            $plan = $protocol->plan()->first();
            $social_work = $plan->social_work()->first();
            $practices = $protocol->practices;
            $phone = $patient->phone()->first();

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


    /**
     * Returns a report in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print($protocol_id)
    {

        try {
            $protocol = OurProtocol::protocol()->findOrFail($protocol_id);
            $prescriber = $protocol->prescriber()->first();
            $patient = $protocol->patient()->first();
            $plan = $protocol->plan()->first();
            $social_work = $plan->social_work()->first();
            $practices = $protocol->practices;
            $phone = $patient->phone()->first();

            ob_start();
            include('pdf/report_001.php');
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
}

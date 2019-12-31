<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shunt;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $shunts = Shunt::all();
        
        return view('patients/patients')->with('shunts', $shunts);
    }

    /**
	* Load patients from a shunt
    * @param   \Illuminate\Http\Request  $request
    * @return View $view
    */
    public function load(Request $request) {
        $patient_type = $request['type'];
        
        switch($patient_type) {
            case 'animals': {
            	$controller = new AnimalController();
                $view = $controller->index($request);
                break;
            }
            case 'humans': {
                $controller = new HumanController();
                $view = $controller->index($request);
                break;
            }
            case 'industrials': {
                $controller = new IndustrialController();
                $view = $controller->index($request);
                break;
            }
            default: { 
            	$shunts = Shunt::all();
                $view = view('patients/patients')->with('shunts', $shunts);
                break;
            }
        }


        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('patients/create');
    }
}

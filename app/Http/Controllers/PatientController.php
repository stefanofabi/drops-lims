<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Animal;
use App\Human;
use App\Industrial;

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
        return view('patients/patients');
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
                $view = view('patients/patients');
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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if (Animal::find($id)) {
            $redirect = redirect()->action('AnimalController@show', ['id' => $id]);
        } else if (Human::find($id)) {
            $redirect = redirect()->action('HumanController@show', ['id' => $id]);
        } else if (Industrial::find($id)) {
            $redirect = redirect()->action('IndustrialController@show', ['id' => $id]);
        } else {
            $redirect = redirect()->action('PatientController@index');
        }

        return $redirect;
    }
}

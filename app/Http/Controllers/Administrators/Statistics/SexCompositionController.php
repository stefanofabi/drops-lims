<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalPatientRepositoryInterface;

class SexCompositionController extends Controller
{
    //

    /** @var \App\Contracts\Repository\InternalPatientRepositoryInterface */
    private $internalPatientRepository;

    public function __construct (InternalPatientRepositoryInterface $internalPatientRepository) 
    {
        $this->internalPatientRepository = $internalPatientRepository;
    }

    public function index()
    {
        return view('administrators.statistics.sex_composition');
    }

    public function generateChart(Request $request)
    {

        $sex_composition = $this->internalPatientRepository->getSexComposition();

        return view('administrators.statistics.sex_composition')
            ->with('sex_composition', $sex_composition);
    }
}

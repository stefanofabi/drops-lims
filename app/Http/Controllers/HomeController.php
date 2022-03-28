<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\PracticeRepositoryInterface;
use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;

class HomeController extends Controller
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;

    /** @var \App\Contracts\Repository\PaymentSocialWorkRepositoryInterface */
    private $paymentSocialWorkRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProtocolRepositoryInterface $protocolRepository, 
        PracticeRepositoryInterface $practiceRepository,
        PaymentSocialWorkRepositoryInterface $paymentSocialWorkRepository,
    ) {
        $this->middleware('auth');

        $this->protocolRepository = $protocolRepository;
        $this->practiceRepository = $practiceRepository;
        $this->paymentSocialWorkRepository = $paymentSocialWorkRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function patientHome()
    {
        return view('patients/home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $pending_protocols = $this->protocolRepository->getPendingProtocols();

        $practices_not_signed = $this->practiceRepository->getPracticesNotSigned();
        
 
        $protocols = $this->protocolRepository->getSumOfAllSocialWorksProtocols();
        $payments = $this->paymentSocialWorkRepository->getSumOfAllPayments();
        $debt_social_works = $protocols->total_amount - $payments->total_amount; 
    
        
        return view('administrators/home')
            ->with('pending_protocols', $pending_protocols)
            ->with('practices_not_signed', $practices_not_signed)
            ->with('debt_social_works', $debt_social_works);
    }
}

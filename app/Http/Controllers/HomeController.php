<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\InternalPracticeRepositoryInterface;
use App\Contracts\Repository\PaymentSocialWorkRepositoryInterface;

class HomeController extends Controller
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\InternalPracticeRepositoryInterface */
    private $internalPracticeRepository;

    /** @var \App\Contracts\Repository\PaymentSocialWorkRepositoryInterface */
    private $paymentSocialWorkRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        InternalProtocolRepositoryInterface $internalProtocolRepository, 
        InternalPracticeRepositoryInterface $internalPracticeRepository,
        PaymentSocialWorkRepositoryInterface $paymentSocialWorkRepository,
    ) {
        $this->middleware('auth');

        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->internalPracticeRepository = $internalPracticeRepository;
        $this->paymentSocialWorkRepository = $paymentSocialWorkRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $pending_protocols = $this->internalProtocolRepository->getPendingProtocols();
        
        $practices_not_signed = $this->internalPracticeRepository->getPracticesNotSigned();
        
        $protocols = $this->internalProtocolRepository->getSumOfAllSocialWorksProtocols();
        $payments = $this->paymentSocialWorkRepository->getSumOfAllPayments();
        $debt_social_works = $protocols->total_amount - $payments->total_amount; 

        return view('administrators/dashboard')
            ->with('pending_protocols', $pending_protocols)
            ->with('practices_not_signed', $practices_not_signed)
            ->with('debt_social_works', $debt_social_works);
    }
}
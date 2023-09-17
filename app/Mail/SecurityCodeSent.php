<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\InternalPatient;

class SecurityCodeSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The protocol instance.
     *
     * @var \App\Models\InternalPatient
     */
    public $patient; 
    
    public $security_code;

    public $expiration_date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(InternalPatient $patient, $security_code, $expiration_date)
    {
        //

        $this->patient = $patient;
        $this->security_code = $security_code;
        $this->expiration_date = $expiration_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails/internal_patients/security_code_sent');
    }
}

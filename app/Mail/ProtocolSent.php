<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Protocol;

class ProtocolSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The protocol instance.
     *
     * @var \App\Models\Protocol
     */
    public $protocol; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Protocol $protocol)
    {
        //

        $this->protocol = $protocol;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id = $this->protocol->id;
        $protocol_path = storage_path("app/protocols/protocol_$id.pdf");

        return $this->view('emails.protocols.protocol_sent')
            ->attach($protocol_path);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Dulce;

class Congratulation extends Mailable
{
    use Queueable, SerializesModels;

    public $dulce;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Dulce $dulce)
    {
        $this->dulce = $dulce;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@larabikes.com')
                    ->subject('¡Felicidades!')
                    ->view('emails.congratulation');
    }
}

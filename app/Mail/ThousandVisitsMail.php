<?php

namespace App\Mail;

use App\Models\Dulce;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ThousandVisitsMail extends Mailable
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
                    ->subject('¡1000 visitas!')
                    ->view('emails.thousandVisits');
    }
}

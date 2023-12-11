<?php

namespace App\Mail;

use App\Models\AlertConfiguration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyAlertNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $alert;
    public $totalQuantity;

    /**
     * Create a new message instance.
     *
     * @param AlertConfiguration $alert
     * @param int $totalQuantity
     */
    public function __construct(AlertConfiguration $alert, $totalQuantity)
    {
        $this->alert = $alert;
        $this->totalQuantity = $totalQuantity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.daily_alert')
            ->subject('Daily Alert Notification')
            ->with([
                'alert' => $this->alert,
                'totalQuantity' => $this->totalQuantity,
            ]);
    }
}

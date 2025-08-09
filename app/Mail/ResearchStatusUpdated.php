<?php

namespace App\Mail;

use App\Models\Research;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResearchStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $research;

    public function __construct(Research $research)
    {
        $this->research = $research;
    }

    public function build()
    {
        $status = ucfirst($this->research->approval_status);
        $subject = "Update on your research submission: {$status}";

        return $this->subject($subject)
                    ->markdown('emails.research-status');
    }
}
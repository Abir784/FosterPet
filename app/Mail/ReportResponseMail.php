<?php

namespace App\Mail;

use App\Models\MessageReport;
use App\Models\ReportResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $response;

    public function __construct(MessageReport $report, ReportResponse $response)
    {
        $this->report = $report;
        $this->response = $response;
    }

    public function build()
    {
        return $this->markdown('emails.report-response')
                    ->subject('Response to Your Report - FosterPet');
    }
}

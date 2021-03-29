<?php
namespace App\Http\Services\Sender\EmailLetters;

use App\Models\UserRequests;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCostRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $toEmails;
    /** @var UserRequests */
    private $userRequest;

    public function __construct($to, UserRequests $userRequest)
    {

        $this->toEmails = $to;
        $this->userRequest = $userRequest;
    }

    public function build()
    {
        return $this
            ->to($this->toEmails)
            ->subject('Новая заявка на расчет стоимости')
            ->view('mail.user_cost_request')
            ->with(
                [
                    'full_name' => $this->userRequest->full_name,
                    'phone' => $this->userRequest->phone,
                    'from' => $this->userRequest->from,
                    'to' => $this->userRequest->to,
                    'length' => $this->userRequest->length,
                    'width' => $this->userRequest->width,
                    'height' => $this->userRequest->height,
                    'weight' => $this->userRequest->weight,
                    'cargo_type' => $this->userRequest->cargo_type,
                ]);
    }
}

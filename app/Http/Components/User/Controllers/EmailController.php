<?php
namespace App\Http\Components\User\Controllers;

use App\Http\Components\User\Email\UseCase\ResetConfirm;
use App\Http\Components\User\Email\UseCase\ResetRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * @param Request $request
     * @param ResetRequest $resetRequest
     */
    public function request(Request $request, ResetRequest $resetRequest)
    {
        $newEmail = $request->input('new_email');
        $resetRequest->reset($newEmail);
    }

    /**
     * @param Request $request
     * @param ResetConfirm $resetConfirm
     * @return \App\Http\Components\User\Entities\User|null
     */
    public function confirm(Request $request, ResetConfirm $resetConfirm)
    {
        $activationCode = $request->input('code');
        return $resetConfirm->confirm($activationCode);
    }

}
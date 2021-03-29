<?php
namespace App\Http\Components\User\Controllers;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\SignUp\Services\TokenGenerator;
use App\Http\Components\User\SignUp\UseCase\CodeResent;
use App\Http\Components\User\SignUp\UseCase\Confirm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    /**
     * @param Request $request
     * @param \App\Http\Components\User\SignUp\UseCase\Request $signUp
     * @return User|null
     * @throws \Exception
     */
    public function request(Request $request, \App\Http\Components\User\SignUp\UseCase\Request $signUp)
    {
        $user = new User();
        $user->fill($request->all());
        return $signUp->handle($user, $request->input('register_type'));
    }

    /**
     * @param Request $request
     * @param Confirm $confirm
     * @param TokenGenerator $generator
     * @return \App\Http\Components\User\Entities\UserToken
     */
    public function confirm(Request $request, Confirm $confirm, TokenGenerator $generator)
    {
        $token = $generator->generate();
        $token->user_id = (int)$request->input('user_id');
        $token->ip = $request->ip();
        $token->user_agent = $request->userAgent();
        $code = $request->input('code');
        return $confirm->confirm($code, $token);
    }

    /**
     * @param Request $request
     * @param CodeResent $codeResent
     */
    public function codeResent(Request $request, CodeResent $codeResent)
    {
        $userId = (int)$request->input('user_id');
        $codeResent->resent($userId);
    }

}

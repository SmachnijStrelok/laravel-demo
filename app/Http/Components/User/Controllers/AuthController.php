<?php
namespace App\Http\Components\User\Controllers;

use App\Http\Components\User\Auth\UseCase\Login;
use App\Http\Components\User\Auth\UseCase\Logout;
use App\Http\Components\User\Auth\UseCase\Refresh;
use App\Http\Components\User\SignUp\Services\TokenGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * @param Login $loginer
     * @param TokenGenerator $generator
     * @return array
     */
    public function login(Request $request, Login $loginer, TokenGenerator $generator)
    {
        $login = $request->input('login');
        $password = $request->input('password');
        $token = $generator->generate();
        $token->ip = $request->ip();
        $token->user_agent = $request->userAgent();
        return $loginer->login($login, $password, $token);
    }

    /**
     * @param Request $request
     * @param Logout $logout
     */
    public function logout(Request $request, Logout $logout)
    {
        $accessToken = $request->header('Authentication');
        $logout->logout($accessToken);
    }

    /**
     * @param Request $request
     * @param Refresh $refresh
     * @param TokenGenerator $generator
     * @return Entities\UserToken|null
     */
    public function refreshToken(Request $request, Refresh $refresh, TokenGenerator $generator)
    {
        $refreshToken = $request->input('refresh_token');
        $newToken = $generator->generate();
        $newToken->ip = $request->ip();
        $newToken->user_agent = $request->userAgent();
        return $refresh->refresh($refreshToken, $newToken);
    }

}

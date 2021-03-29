<?php
namespace App\Http\Components\User\Controllers;

use App\Http\Components\User\Password\UseCase\ResetConfirm;
use App\Http\Components\User\Password\UseCase\ResetRequest;
use App\Http\Components\User\Password\UseCase\Update;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\Repositories\UserRepository;
use App\Http\Components\User\SignUp\Services\TokenGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
{
    /**
     * @param Request $request
     * @param ResetRequest $resetRequest
     */
    public function reset(Request $request, ResetRequest $resetRequest)
    {
        $login = (string)$request->input('login');
        $resetType = (string)$request->input('reset_type');
        $resetRequest->reset($login, $resetType);
    }

    /**
     * @param Request $request
     * @param ResetConfirm $resetConfirm
     * @param TokenGenerator $generator
     * @param IUserRepository $userRepository
     * @return \App\Http\Components\User\Entities\UserToken
     */
    public function confirm(Request $request, ResetConfirm $resetConfirm, TokenGenerator $generator, IUserRepository $userRepository)
    {
        if(!$user = $userRepository->getByLogin($request->input('login'))){
            throw new NotFoundHttpException('Пользователь не найден');
        }
        $token = $generator->generate();
        $token->ip = $request->ip();
        $token->user_agent = $request->userAgent();
        $token->user_id = $user->id;
        $code = $request->input('code');
        $password = $request->input('password');
        return $resetConfirm->confirm($code, $token, $password);
    }

    /**
     * @param Request $request
     * @param Update $updater
     * @param TokenGenerator $generator
     * @param UserRepository $userRepository
     * @return \App\Http\Components\User\Entities\UserToken|null
     */
    public function update(Request $request, Update $updater, TokenGenerator $generator, UserRepository $userRepository)
    {
        $userId = $user = $userRepository->me()->id;
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');

        $token = $generator->generate();
        $token->ip = $request->ip();
        $token->user_agent = $request->userAgent();
        $token->user_id = $userId;

        return $updater->update($userId, $oldPassword, $newPassword, $token);
    }

}
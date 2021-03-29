<?php
namespace App\Http\Components\User\Controllers;

use App\Http\Components\User\Create\UseCase\Create;
use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserInfo;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\UserInfo\UseCase\Edit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @param Create $create
     * @return User|null
     * @throws \Exception
     */
    public function create(Request $request, Create $create)
    {
        $registerType = $request->input('register_type');
        $user = new User();
        $user->surname = $request->input('surname');
        $user->name = $request->input('name');
        $user->patronymic = $request->input('patronymic');
        $user->email = $request->input('email');
        $user->mobile_phone = $request->input('mobile_phone');
        $user->password_hash = $request->input('password');
        return $create->create($user, $registerType);
    }

    /**
     * @param Request $request
     * @param IUserRepository $userRepository
     * @return User[]|array|null
     */
    public function get(Request $request, IUserRepository $userRepository)
    {
        if(!Auth::user()->isAdmin()){
            throw new AccessDeniedException('access denied');
        }
        $role = (string)$request->route('role');
        return $userRepository->getByRole($role);
    }

    /**
     * @param Request $request
     * @param Edit $edit
     * @return User
     */
    public function edit(Request $request, Edit $edit)
    {
        $userId = $request->input('user_id');
        $userInfo = new UserInfo(
            (string)$request->input('surname'),
            (string)$request->input('name'),
            (string)$request->input('patronymic')
        );
        return $edit->edit($userId, $userInfo);
    }

}
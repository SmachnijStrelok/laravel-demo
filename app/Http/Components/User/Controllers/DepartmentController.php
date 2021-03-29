<?php
namespace App\Http\Components\User\Controllers;

use App\Http\Components\User\Department\UseCase\Join as Join;
use App\Http\Components\User\Department\UseCase\Detach as Detach;
use App\Http\Components\User\Entities\DepartmentToUser;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    /**
     * @param Join\JoinUserToDepartmentRequest $request
     * @param Join\Handler $handler
     * @return DepartmentToUser
     */
    public function join(Join\JoinUserToDepartmentRequest $request, Join\Handler $handler)
    {
        return $handler->handle($request->get('user_id'), $request->get('department_id'));
    }

    /**
     * @param DepartmentToUser $dtu
     * @param Detach\Handler $handler
     * @return string
     */
    public function detach(DepartmentToUser $dtu, Detach\Handler $handler)
    {
        $handler->handle($dtu);
        return 'ok';
    }

}
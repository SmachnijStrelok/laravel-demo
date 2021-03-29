<?php
namespace App\Http\Components\User\SignUp\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Services\PasswordHasher;
use App\Http\Components\User\SignUp\Services\SignUpFactory;
use Illuminate\Support\Facades\DB;

class Request
{
    private $hasher;
    private $factory;
    private $userRepository;

    public function __construct(
        SignUpFactory $factory,
        PasswordHasher $hasher,
        IUserRepository $userRepository
    )
    {
        $this->hasher = $hasher;
        $this->factory = $factory;
        $this->userRepository = $userRepository;
    }

    public function handle(User $user, string $registerType = 'sms')
    {
        // TODO убрать фасады, заменить на внедрение зависимостей
        DB::beginTransaction();
        try{
            $user = $this->fillModel($user);
            $signUpHandler = $this->factory->makeSignUpRequestHandler($registerType);
            $user = $signUpHandler->register($user);
            $this->createStartReplenishment($user->id);
        } catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $this->userRepository->getById($user->id);
    }

    private function fillModel(User $user)
    {
        $user->state = $user::STATE_UNCONFIRMED;
        $user->role = $user::ROLE_USER;
        $user->password_hash = $this->hasher->hash($user->password_hash);
        return $user;
    }

    private function createStartReplenishment(int $userId)
    {
        $this->replenisher->createStartReplenishment($userId);
    }
}
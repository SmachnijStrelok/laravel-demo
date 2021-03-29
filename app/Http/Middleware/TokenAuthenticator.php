<?php
namespace App\Http\Middleware;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokenAuthenticator
{
    private $token;

    public function __construct(IUserTokenRepository $token)
    {
        $this->token = $token;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @param string $isRequired
     * @return mixed
     * @internal param IUserRepository $user
     * @internal param string $isAuthRequired
     */
    public function handle($request, Closure $next, $isRequired = 'true')
    {
        $accessToken = (string)$request->header('Authentication');
        $accessToken = strlen($accessToken) > 5 ? $accessToken : $_COOKIE['access_token'];

        if($isRequired == 'true' || $accessToken){
            $token = $this->token->getByAccessToken((string)$accessToken);
            $this->validateToken($token);
            $this->validateUser($token->user);
            $this->authenticate($token->user, $accessToken);
        }

        return $next($request);
    }

    private function validateToken(?UserToken $token)
    {
        if(!$token){
            throw new UnauthorizedHttpException('', 'Передан несуществующий токен');
        }

        if(time() > strtotime($token->expires_in)){
            throw new UnauthorizedHttpException('', 'Время жизни токена истекло');
        }
    }

    private function validateUser(?User $user)
    {
        if(!$user){
            throw new NotFoundHttpException('Пользователь не найден');
        }

        if ($user->state == $user::STATE_UNCONFIRMED) {
            throw new UnauthorizedHttpException('', 'Ваш аккаунт не подтвержден');
        }
    }

    private function authenticate(User $user, string $accessToken)
    {
        Auth::setUser($user);
    }
}

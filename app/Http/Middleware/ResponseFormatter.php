<?php

namespace App\Http\Middleware;

use App\Http\Resources\ExceptionResource;
use Closure;
use Illuminate\Http\Response;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class ResponseFormatter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        $currentResponse = json_decode($response->content(), true);
        /*if ($currentResponse === null && !$response->exception) {
            return $response;
        }*/

        $formattedContent = $currentResponse;
        $formattedContent['state'] = $response->isSuccessful() ? 'ok' : 'error';
        /*$formattedContent = [
            'state' => $response->isSuccessful() ? 'ok' : 'error',
            'data' => []
        ];*/
        if ($response->exception) {
            $formattedContent = [];
            $trace = $response->exception->getTrace();
            $formattedContent['message'] = $response->exception->getMessage();
            $formattedContent['error'] = $trace;
            $response->setContent(json_encode($formattedContent));
            $response->setStatusCode($response->exception->getCode() ?: 400);
            return $response;
        }

        /*if (is_array($currentResponse)) {
            $formattedContent['data'] = $currentResponse;
        }*/

        $response->setContent(json_encode($formattedContent));
        return $response;
    }
}

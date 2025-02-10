<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Eğer yanıt bir hata içeriyorsa (validation error gibi)
        if ($response instanceof Response && $response->getStatusCode() >= 400) {
            // Hata mesajlarını JSON formatında döndür
            $content = [
                'error' => true,
                'status_code' => $response->getStatusCode(),
            ];
        }

        return $response;
    }
}

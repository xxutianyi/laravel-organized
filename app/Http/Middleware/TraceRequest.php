<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use WhichBrowser\Parser;

class TraceRequest
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = (string)Str::uuid();

        $requestLog = [
            'traceId' => $traceId,
            'method' => $request->method(),
            'path' => $request->path(),
            'query' => $request->query(),
            'params' => $request->file() ? '<file>' : $request->all(),
            'ip' => $request->ips(),
            'ua' => $request->userAgent(),
        ];

        Log::channel('request')->info($traceId, $requestLog);

        $request->merge(['traceId' => $traceId]);

        return $next($request);
    }
}

<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Response extends JsonResponse
{

    public function __construct(Request $request, $data = [], string $message = "success", ShowType $showType = ShowType::SILENT, int $status = 200, $headers = [])
    {

        $success = $status == 200;
        $host = config('app.host');

        /** Set Status 204 when no content */
        if (empty($data)) {
            $status = 204;
        }

        $response = [
            'success' => $success,
            'errorCode' => $status,
            'errorMessage' => $message,
            'showType' => $showType,
            'traceId' => $request->input('traceId'),
            'host' => $host,
            'data' => $data,
        ];

        parent::__construct($response, $status, $headers);
    }
}

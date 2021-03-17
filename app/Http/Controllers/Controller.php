<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $isOnlyBody = false;

    public function onlyBody() {
        $this->isOnlyBody = true;
    }

    public function responseError($payload = null,string $message= "",int $statusCode = 422,array $headers = []) {
        if ($this->isOnlyBody) {
            return [
                'error' => true,
                'message' => $message,
                'payload' => $payload
            ];
        } else {
            return response()->json([
                'error' => true,
                'message' => $message,
                'payload' => $payload
            ],$statusCode,$headers);
        }
    }

    /**
     * Response json with success status
     *
     * @param array|null $payload
     * @param string $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse| array
     */
    public function responseSuccess($payload = null,string $message = "",int $statusCode = 200,array $headers = []) {
        if ($this->isOnlyBody) {
            return [
                'error' => false,
                'message' => $message,
                'payload' => $payload
            ];
        }else {
            return response()->json([
                'error' => false,
                'message' => $message,
                'payload' => $payload
            ],$statusCode,$headers);
        }
    }
}

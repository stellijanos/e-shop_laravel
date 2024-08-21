<?php

namespace App\Utils;

class Response
{

    private $status;
    private $message;
    private $data;
    private $statusCode;

    public function __construct(string $status, string $message, int $statusCode = 200, array $data = [])
    {
        $this->status = $status;
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function get()
    {
        $body = [
            'status' => $this->status,
            'message' => $this->message
        ];
        if ($this->data) {
            $body['data'] = $this->data;
        }
        return response()->json($body, $this->statusCode);
    }
}

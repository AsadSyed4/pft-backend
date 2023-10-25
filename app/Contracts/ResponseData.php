<?php

namespace App\Contracts;

use App\Services\Utilities\HttpCodes;
use App\Services\Utilities\HttpMessages;

class ResponseData
{
    public string|array $message;
    public HttpCodes $status_code;

    public array|string|int|null $data;

    public function __construct(string|array $message, HttpCodes $statusCode, array|string|int|null|object $data)
    {
        $this->message = $message;
        $this->status_code = $statusCode;
        $this->data = $data;
    }
}

<?php

namespace \App\Utils;


class Response {

    private $status;
    private $message;
    private $data;

    public function __construct($status, $message, $data=[]) {
        $this->status = $status;
        $this->data = $data;
    }

    public function sendResponse() {

    }
}
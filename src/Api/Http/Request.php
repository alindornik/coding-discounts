<?php

namespace Src\Api\Http;

class Request
{
    public function __construct(
        private string $method,
        private string $uri,
        private array $body) {
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getBody() {
        return $this->body;
    }
}

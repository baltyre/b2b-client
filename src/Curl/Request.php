<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Curl;

class Request extends Message
{
    private string $method;
    private string $uri;

    public function __construct(string $method, string $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
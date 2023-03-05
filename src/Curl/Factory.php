<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Curl;

class Factory
{
    public static function createRequest(string $method, string $uri): Request
    {
        return new Request($method, $uri);
    }

    public static function createClient(): Client
    {
        return new Client();
    }
}
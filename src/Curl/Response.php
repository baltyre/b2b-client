<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Curl;

use InvalidArgumentException;

class Response extends Message
{
    private int $status;
    private string $reasonPhrase;

    public function setStatus(string $statusLine): void
    {
        $parts = explode(" ", $statusLine, 3);
        if (count($parts) < 2 || !str_starts_with(strtolower($parts[0]), "http/")) {
            throw new InvalidArgumentException(
                sprintf("'%s' is not a valid HTTP status line", $statusLine)
            );
        }

        $this->status = (int)$parts[1];
        $this->reasonPhrase = count($parts) > 2 ? $parts[2] : "";
        $this->protocol = substr($parts[0], 5);
    }

    public function writeBody(string $body): void
    {
        $this->body .= $body;
    }

    public function addHeader(string $headerLine): void
    {
        $parts = explode(':', $headerLine, 2);
        if (count($parts) !== 2) {
            throw new InvalidArgumentException(
                sprintf("'%s' is not a valid HTTP header line", $headerLine)
            );
        }
        $name = trim($parts[0]);
        $value = trim($parts[1]);
        $this->headers[$name][] = $value;
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }
}
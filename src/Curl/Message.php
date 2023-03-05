<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Curl;

class Message
{
    protected string $protocol = "1.1";
    protected array $headers = [];
    protected ?string $body = null;

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function withHeader($name, $value): self
    {
        $new = clone $this;
        $new->headers[$name][] = $value;
        return $new;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function withBody(string $body): self
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }
}
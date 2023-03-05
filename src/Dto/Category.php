<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;
use Stringable;

class Category implements Stringable
{
    public string $code;
    public string $name;

    private function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public static function fromApi(?stdClass $data): ?self
    {
        if (!$data) {
            return null;
        }
        return new self($data->code, $data->name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
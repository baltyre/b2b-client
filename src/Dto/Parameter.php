<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;
use Stringable;

class Parameter implements Stringable
{
    public const NOT_AVAILABLE = "N/A";
    public string $code;
    public string $name;
    public ?string $value = null;

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
        $dto = new self($data->code, $data->name);
        $dto->value = $data->value ?? null;
        return $dto;
    }

    public function __toString(): string
    {
        return implode(": ", [$this->name, $this->value ?? self::NOT_AVAILABLE]);
    }
}
<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;
use Stringable;

class Manufacturer implements Stringable
{
    public string $code;
    public string $name;
    public ?Picture $picture = null;

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
        $dto->picture = Picture::fromApi($data->picture);
        return $dto;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;
use Stringable;

class Volume implements Stringable
{
    public string $amount;
    public string $unit;

    private function __construct(float|string $amount, string $unit)
    {
        $this->amount = (string)$amount;
        $this->unit = $unit;
    }

    public static function fromApi(?stdClass $data): ?self
    {
        if (!$data) {
            return null;
        }
        return new self($data->amount, $data->unit);
    }

    public function __toString(): string
    {
        return implode(" ", [$this->amount, $this->unit]);
    }
}
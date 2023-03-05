<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;
use Stringable;

class Price implements Stringable
{
    public string $amount;
    public string $currency;

    private function __construct(float|string $amount, string $currency)
    {
        $this->amount = (string)$amount;
        $this->currency = $currency;
    }

    public static function fromApi(?stdClass $data): ?self
    {
        if (!$data) {
            return null;
        }
        return new self($data->amount, $data->currency);
    }

    public function __toString(): string
    {
        return implode(" ", [$this->amount, $this->currency]);
    }
}
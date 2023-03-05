<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;

class PricePolicy
{
    public Price $sale;
    public Price $purchase;

    private function __construct(Price $sale, Price $purchase)
    {
        $this->sale = $sale;
        $this->purchase = $purchase;
    }

    public static function fromApi(?stdClass $data): self
    {
        return new self(Price::fromApi($data->sale), Price::fromApi($data->purchase));
    }
}
<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;

class ProductPricing
{
    public string $code;
    public ?PricePolicy $price = null;

    private function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function fromApi(stdClass $data): self
    {
        $dto = new self($data->code);
        $dto->price = PricePolicy::fromApi($data->price);
        return $dto;
    }
}
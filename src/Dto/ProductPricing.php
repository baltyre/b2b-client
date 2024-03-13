<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;

class ProductPricing
{
    public string $code;
    public string $cdb;
    public ?string $plu = null;
    public ?PricePolicy $price = null;

    private function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function fromApi(stdClass $data): self
    {
        $dto = new self($data->code);
        $dto->cdb = $data->cdb;
        $dto->plu = $data->plu ?? null;
        $dto->price = PricePolicy::fromApi($data->price);
        return $dto;
    }
}
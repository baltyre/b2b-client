<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;

class ProductStocks
{
    public string $code;
    public ?ResourceCollection $stock = null;

    private function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function fromApi(stdClass $data): self
    {
        $dto = new self($data->code);
        $dto->stock = ResourceCollection::fromApi($data->stock);
        return $dto;
    }
}
<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;

class StockResource
{
    public string $code;
    public string $name;
    public int $days;
    public int $quantity;
    public bool $moreThanQuantity = false;

    private function __construct(string $code, string $name, int $days, int|string $quantity)
    {
        $this->code = $code;
        $this->name = $name;
        $this->days = $days;
        $quantity = (string)$quantity;
        if (str_ends_with($quantity, "+")) {
            $quantity = str_replace("+", "", $quantity);
            $this->moreThanQuantity = true;
        }
        $this->quantity = (int)$quantity;
    }

    public static function fromApi(stdClass $data): self
    {
        return new self($data->code, $data->name, $data->days, $data->quantity);
    }
}
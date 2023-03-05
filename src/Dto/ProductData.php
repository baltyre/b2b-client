<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;

class ProductData
{
    public string $code;
    public string $name;
    public ?string $ean = null;
    public ?string $manufacturer_code = null;
    public ?Manufacturer $manufacturer = null;
    public ?Volume $volume = null;
    public ?Weight $weight = null;
    public ?Pattern $pattern = null;
    public ?ParameterCollection $parameters = null;
    public ?CategoryCollection $categories = null;

    private function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public static function fromApi(stdClass $data): self
    {
        $dto = new self($data->code, $data->name);
        $dto->ean = $data->ean ?? null;
        $dto->manufacturer_code = $data->manufacturer_code ?? null;
        $dto->manufacturer = Manufacturer::fromApi($data->manufacturer);
        $dto->volume = Volume::fromApi($data->volume);
        $dto->weight = Weight::fromApi($data->weight);
        $dto->pattern = Pattern::fromApi($data->pattern);
        $dto->parameters = ParameterCollection::fromApi($data->parameters);
        $dto->categories = CategoryCollection::fromApi($data->categories);
        return $dto;
    }
}
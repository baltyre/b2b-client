<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use stdClass;
use Stringable;

class Pattern implements Stringable
{
    public string $name;
    public ?string $description = null;
    public ?string $season = null;
    public ?string $purpose = null;
    public ?Picture $picture = null;
    public ?PictureCollection $pictures = null;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromApi(?stdClass $data): ?self
    {
        if (!$data) {
            return null;
        }
        $dto = new self($data->name);
        $dto->description = $data->description ?? null;
        $dto->season = $data->season ?? null;
        $dto->purpose = $data->purpose ?? null;
        $dto->picture = Picture::fromApi($data->picture);
        $dto->pictures = PictureCollection::fromApi($data->pictures);
        return $dto;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
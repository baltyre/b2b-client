<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Exception;
use Traversable;

class ResourceCollection extends Collection
{
    /**
     * @return Traversable<StockResource>
     * @throws Exception
     */
    public function getIterator(): Traversable
    {
        return parent::getIterator();
    }

    public static function fromApi(?iterable $data): ?self
    {
        if (!$data) {
            return null;
        }
        $elements = [];
        foreach ($data as $resource) {
            $elements[] = StockResource::fromApi($resource);
        }
        return new self($elements);
    }
}
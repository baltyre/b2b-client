<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Exception;
use Traversable;

class PriceListCollection extends Collection
{
    /**
     * @return Traversable<ProductPricing>
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
        foreach ($data as $category) {
            $elements[] = ProductPricing::fromApi($category);
        }
        return new self($elements);
    }
}
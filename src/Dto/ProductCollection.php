<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Exception;
use Traversable;

class ProductCollection extends Collection
{
    /**
     * @return Traversable<ProductData>
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
        foreach ($data as $product) {
            $elements[] = ProductData::fromApi($product);
        }
        return new self($elements);
    }
}
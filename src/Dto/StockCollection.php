<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Exception;
use Traversable;

class StockCollection extends Collection
{
    /**
     * @return Traversable<ProductStocks>
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
        foreach ($data as $stock) {
            $elements[] = ProductStocks::fromApi($stock);
        }
        return new self($elements);
    }
}
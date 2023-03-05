<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Exception;
use Traversable;

class CategoryCollection extends Collection
{
    /**
     * @return Traversable<Category>
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
            $elements[] = Category::fromApi($category);
        }
        return new self($elements);
    }
}
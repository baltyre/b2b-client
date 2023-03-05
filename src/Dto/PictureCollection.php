<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Exception;
use Traversable;

class PictureCollection extends Collection
{
    /**
     * @return Traversable<Picture>
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
            $elements[] = Picture::fromApi($category);
        }
        return new self($elements);
    }
}
<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Exception;
use Traversable;

class ParameterCollection extends Collection
{
    /**
     * @return Traversable<Parameter>
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
        foreach ($data as $parameter) {
            $elements[] = Parameter::fromApi($parameter);
        }
        return new self($elements);
    }
}
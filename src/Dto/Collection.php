<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

abstract class Collection implements Countable, IteratorAggregate, ArrayAccess
{
    private array $elements = [];

    protected function __construct(iterable $elements = [])
    {
        foreach ($elements as $element) {
            $this->elements[] = $element;
        }
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function offsetExists(mixed $offset): bool
    {
        return key_exists($offset, $this->elements);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->elements[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (isset($offset)) {
            $this->elements[$offset] = $value;
        } else {
            $this->elements[] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->elements[$offset]);
        }
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function toArray(): array
    {
        return $this->elements;
    }
}
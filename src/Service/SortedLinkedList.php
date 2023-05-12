<?php

namespace App\Service;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class SortedLinkedList extends \SplDoublyLinkedList
{
    /**
     * @throws InvalidTypeException
     */
    private function findInsertionIndex(mixed $value): ?int
    {
        if($this->isEmpty()) {
            return null;
        }
        $this->setIteratorMode($this::IT_MODE_FIFO);
        $this->rewind();
        switch(gettype($value)) {
            case "integer":
                while ($this->valid() && $this->current() < $value) {
                    $this->next();
                }
                break;
            case "string":
                while ($this->valid() && strcmp($this->current(), $value) < 0) {
                    $this->next();
                }
                break;
            default:
                throw new InvalidTypeException("SortedLinkedList supports only int and string values for now");
        }
        return $this->key();
    }

    public function insert(mixed $value): void
    {
        $index = $this->findInsertionIndex($value);
        if($index === null) {
            $this->push($value);
        } else {
            $this->add($index, $value);
        }
    }

    public function find(mixed $value): ?int
    {
        $index = $this->findInsertionIndex($value);
        $offsetValue = $index !== null ? $this->offsetGet($index) : null;
        return  $offsetValue === $value ? $index : null;
    }

    public function remove(mixed $value): void
    {
        $index = $this->find($value);
        if ($index !== null) {
            $this->offsetUnset($index);
        }
    }
}
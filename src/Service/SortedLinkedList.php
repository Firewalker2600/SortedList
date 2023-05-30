<?php

namespace App\Service;

/**
 * @template TValue
 * @extends \SplDoublyLinkedList<TValue>
 * @implements SortedLinkedListInterface<TValue>
 */
abstract class SortedLinkedList extends \SplDoublyLinkedList implements SortedLinkedListInterface
{
    /**
     * @param mixed $value
     * @return int|null
     */
    abstract function findValueIndex($value): ?int;

    /**
     * @param mixed $value
     * @return void
     */
   public function insert($value): void
    {
        $index = $this->findValueIndex($value);
        if($index !== null) {
            $this->add($index, $value);
        } else {
            $this->push($value);
        }
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function remove($value): void
    {
        $index = $this->findValueIndex($value);
        if ($index !== null && $this->offsetGet($index) === $value) {
           $this->offsetUnset($index);
        }
    }
}

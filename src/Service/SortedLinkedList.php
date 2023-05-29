<?php

namespace App\Service;

/**
 * @template TValue
 * @extends \SplDoublyLinkedList<TValue>
 * @implements SortedLinkedListInterface<TValue>
 */
abstract class SortedLinkedList extends \SplDoublyLinkedList implements SortedLinkedListInterface
{
   abstract function findValueIndex($value): ?int;

    public function insert($value): void
    {
        $index = $this->findValueIndex($value);
        if($index !== null) {
            $this->add($index, $value);
        } else {
            $this->push($value);
        }
    }

    public function remove($value): void
    {
        $index = $this->findValueIndex($value);
        if ($index !== null && $this->offsetGet($index) === $value) {
           $this->offsetUnset($index);
        }
    }
}

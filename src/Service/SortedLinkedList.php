<?php

namespace App\Service;

abstract class SortedLinkedList extends \SplDoublyLinkedList
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

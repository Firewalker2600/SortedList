<?php declare(strict_types=1);

namespace App\Service;

class IntegerSortedLinkedList extends SortedLinkedList
{
    public function findValueIndex($value): ?int
    {
        if(!is_int($value)) {
            throw new \InvalidArgumentException("IntegerSortedLinkedList nodes can only be integer");
        }
        if($this->isEmpty()) {
            return null;
        }
        $this->setIteratorMode($this::IT_MODE_FIFO);
        $this->rewind();

        while ($this->valid() && $this->current() < $value) {
            $this->next();
        }
        return $this->valid() ? $this->key(): null;
        }
}

<?php declare(strict_types=1);

namespace App\Service;

/**
 * @extends SortedLinkedList<int>
 */
class IntegerSortedLinkedList extends SortedLinkedList
{
    public function findValueIndex($value): ?int
    {
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

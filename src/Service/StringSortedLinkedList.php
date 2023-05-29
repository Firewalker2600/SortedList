<?php declare(strict_types=1);

namespace App\Service;

/**
 * @extends SortedLinkedList<string>
 */
class StringSortedLinkedList extends SortedLinkedList
{
    public function findValueIndex($value): ?int
    {
        if($this->isEmpty()) {
            return null;
        }
        $this->setIteratorMode($this::IT_MODE_FIFO);
        $this->rewind();

        while ($this->valid() && strcmp($this->current(), $value) < 0) {
            $this->next();
        }

        return $this->valid() ? $this->key() : null;
    }
}

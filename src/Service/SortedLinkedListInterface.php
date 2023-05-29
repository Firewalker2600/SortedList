<?php

namespace App\Service;

/**
 * @template TValue
 */
interface SortedLinkedListInterface
{
    /**
     * @param TValue $value
     * @return int|null
     */
    function findValueIndex($value): ?int;

    /**
     * @param TValue $value
     * @return void
     */
    function insert($value): void;

    /**
     * @param TValue $value
     * @return void
     */
    function remove($value): void;
}

<?php

namespace App\Tests\Service;

use App\Service\StringSortedLinkedList;
use PHPUnit\Framework\TestCase;

class StringSortedLinkedListTest extends TestCase
{
    public function testStringSortedLinkedList()
    {
        $list = new StringSortedLinkedList();

        // Test empty list
        $this->assertTrue($list->isEmpty());

        $list->insert('banana');
        $list->insert('apple');
        $list->insert('carrot');

        // Test positive findValueIndex
        $this->assertEquals(1, $list->findValueIndex('banana'));

        // Test negative findValueIndex
        $this->assertEquals(null, $list->findValueIndex('melon'));

        // Test insertion
        $this->assertEquals('apple', $list->offsetGet(0));
        $this->assertEquals('banana', $list->offsetGet(1));
        $this->assertEquals('carrot', $list->offsetGet(2));

        // Test removal
        $list->remove('banana');
        $this->assertEquals('apple', $list->offsetGet(0));
        $this->assertEquals('carrot', $list->offsetGet(1));

        // Test invalid argument
        $this->expectException(\InvalidArgumentException::class);
        $list->insert(123);
    }
}

<?php

namespace App\Tests\Service;

use App\Service\IntegerSortedLinkedList;
use PHPUnit\Framework\TestCase;

class IntegerSortedLinkedListTest extends TestCase
{
    public function testIntegerSortedLinkedList()
    {
        $list = new IntegerSortedLinkedList();

        // Test empty list
        $this->assertTrue($list->isEmpty());

        $list->insert(5);
        $list->insert(1);
        $list->insert(3);

        // Test positive findValueIndex
        $this->assertEquals(1, $list->findValueIndex(3));

        // Test negative findValueIndex
        $this->assertEquals(null, $list->findValueIndex(40));

        // Test insertion
        $this->assertEquals(1, $list->offsetGet(0));
        $this->assertEquals(3, $list->offsetGet(1));
        $this->assertEquals(5, $list->offsetGet(2));

        // Test removal
        $list->remove(1);
        $this->assertEquals(3, $list->offsetGet(0));
        $this->assertEquals(5, $list->offsetGet(1));

        // Test invalid argument
        $this->expectException(\InvalidArgumentException::class);
        $list->insert('not an integer');
    }
}

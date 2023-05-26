<?php

namespace App\Tests\Controller;

use App\Service\IntegerSortedLinkedList;
use App\Service\StringSortedLinkedList;
use App\Tests\Helpers\SessionHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SortedListControllerTest extends WebTestCase
{

use SessionHelper;

    public function testHomePositive()
    {
        $client = static::createClient();
        $session = $this->createSession($client);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        // Fill out the insert form with valid integer input
        $form = $crawler->filter('#insert_form')->form();
        $form['insert_form[integer]'] = 5;
        $form['insert_form[string]'] = 'apple';
        $client->submit($form);

        $intList = $session->get('intList');
        $strList = $session->get('strList');

        // Assert that the integer and string are inserted into the integer list
        $this->assertEquals(5, $intList->bottom());
        $this->assertEquals('apple', $strList->bottom());
    }
    public function testHomeNegative()
    {
        $client = static::createClient();
        $session = $this->createSession($client);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        // Fill out the insert form with invalid integer and string input
        $form = $crawler->filter('#insert_form')->form();
        $form['insert_form[integer]'] = 'not an integer';
        $form['insert_form[string]'] = 10;
        $client->submit($form);

        $intList = $session->get('intList');
        $strList = $session->get('strList');

        // Assert that the integer and string lists were not created
        $this->assertSame(null, $intList);
        $this->assertSame(null, $strList);
    }
        public function testIntRemovePositive(): void
    {
        $client = static::createClient();

        $intList = new IntegerSortedLinkedList();
        $intList->insert(10);
        $intList->insert(20);
        $intList->insert(30);
        $session = $this->createSession($client, ['intList' => $intList]);

        // Make a DELETE request to the endpoint
        $client->request('DELETE', '/api/int-remove/20');

        // Assert that the response is successful
        $this->assertResponseIsSuccessful();

        // Retrieve the updated session from the container
        $updatedList = $session->get('intList');

        $this->assertCount(2, $updatedList);
        $this->assertSame(10, $updatedList[0]);
        $this->assertSame(30, $updatedList[1]);
    }

    public function testIntRemoveNegative(): void
    {
        $client = static::createClient();

        $intList = new IntegerSortedLinkedList();
        $intList->insert(10);
        $intList->insert(20);
        $intList->insert(5);
        $session = $this->createSession($client, ['intList' => $intList]);

        // Make a DELETE request to the endpoint
        $client->request('DELETE', '/api/int-remove/30');
        $this->assertResponseIsSuccessful();

        // Assert the list is unchanged and everything is in order
        $updatedList = $session->get('intList');
        $this->assertCount(3, $updatedList);
        $this->assertEquals(5, $updatedList[0]);
        $this->assertEquals(10, $updatedList[1]);
        $this->assertEquals(20, $updatedList[2]);
    }

    public function testStrRemovePositive(): void
    {
        $client = static::createClient();

        $strList = new StringSortedLinkedList();
        $strList->insert('car');
        $strList->insert('woods');
        $strList->insert('zebra');
        $session = $this->createSession($client, ['strList' => $strList]);

        // Make a DELETE request to the endpoint and assert response is successful
        $client->request('DELETE', '/api/str-remove/woods');
        $this->assertResponseIsSuccessful();

        //Assert the strList is in order and 'woods' has been removed
        $updatedList = $session->get('strList');
        $this->assertCount(2, $updatedList);
        $this->assertSame('car', $updatedList[0]);
        $this->assertSame('zebra', $updatedList[1]);
    }

    public function testRemoveStrNegative(): void
    {
        $client = static::createClient();

        $strList = new StringSortedLinkedList();
        $strList->insert('mock');
        $strList->insert('tree');
        $strList->insert('one');
        $session = $this->createSession($client, ['strList' => $strList]);

        // Make a DELETE request to the endpoint and assert response is successful
        $client->request('DELETE', '/api/str-remove/giant');
        $this->assertResponseIsSuccessful();

        //Assert the strList is in order and unchanged
        $updatedList = $session->get('strList');
        $this->assertCount(3, $updatedList);
        $this->assertSame('mock', $updatedList[0]);
        $this->assertSame('one', $updatedList[1]);
        $this->assertSame('tree', $updatedList[2]);
    }
}

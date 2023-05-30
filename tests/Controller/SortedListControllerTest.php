<?php

namespace App\Tests\Controller;

use App\Service\IntegerSortedLinkedList;
use App\Service\StringSortedLinkedList;
use App\Tests\Helpers\SessionHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SortedListControllerTest extends WebTestCase
{

use SessionHelper;

    public function testIntegerFormPositive()
    {
        $client = static::createClient();
        $session = $this->createSession($client);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $intForm = $crawler->filter('#integer_form')->form();
        $intForm['integer_form[integer]'] = 5;
        $client->submit($intForm);
        $intList = $session->get('intList');
        $this->assertEquals(5, $intList->bottom());
    }
    public function testHomeIntegerNegative()
    {
        $client = static::createClient();
        $session = $this->createSession($client);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        // Fill out the insert form with invalid integer and string input
        $intForm = $crawler->filter('#integer_form')->form();
        $intForm['integer_form[integer]'] = 'not an integer';
        $client->submit($intForm);
        $intList = $session->get('intList');
        $this->assertSame(null, $intList);
    }
    public function testHomeStringPositive(): void
    {
        $client = static::createClient();
        $session = $this->createSession($client);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $strForm = $crawler->filter('#string_form')->form();
        $strForm['string_form[string]'] = 'apple';
        $client->submit($strForm);
        $strList = $session->get('strList');
        $this->assertEquals('apple', $strList->bottom());
    }

    public function testHomeStringNegative(): void
    {
        $client = static::createClient();
        $session = $this->createSession($client);
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $strForm = $crawler->filter('#string_form')->form();
        $strForm['string_form[string]'] = null;
        $client->submit($strForm);
        $strList = $session->get('strList');
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

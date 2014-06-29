<?php

namespace JiraApi\Tests\Clients;

use GuzzleHttp\Message\Response;
use JiraApi\Clients\IssueClient;
use JiraApi\Tests\ClientTestCase;

class IssueClientTest extends ClientTestCase
{
    public function testGet()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/get.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $issueData = $issueClient->get(10002);
        $response = $issueData->json();

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals(10002, $response['id']);
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     */
    public function testGetError()
    {
        $issueClient = $this->getIssueClientExceptionMock();
        $issueClient->get(345);
    }

    public function testCreate()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/create.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $response = $issueClient->create(array())->json();

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals(10000, $response['id']);
        $this->assertArrayHasKey('key', $response);
        $this->assertEquals('TST-24', $response['key']);
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     */
    public function testCreateError()
    {
        $issueClient = $this->getIssueClientExceptionMock();
        $issueClient->create(array())->json();
    }

    public function testDelete()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(204));
        $response = $issueClientMock->delete(1);

        $this->assertEquals(204, $response->getCode());
        $this->assertNull($response->json());
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     */
    public function testDeleteError()
    {
        $issueClientMock = $this->getIssueClientExceptionMock();
        $issueClientMock->delete(101);
    }

    public function testUpdate()
    {
        $issueClient = $this->getIssueClientMock($this->getResponseMock(200));
        $response = $issueClient->update(10002, array());

        $this->assertEquals(200, $response->getCode());
        $this->assertNull($response->json());
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     */
    public function testUpdateError()
    {
        $issueClientMock = $this->getIssueClientExceptionMock();
        $issueClientMock->update(101, array());
    }

    public function testGetTransitions()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/transitions.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $transitions = $issueClient->getTransitions(10002)->json();

        $this->assertArrayHasKey('transitions', $transitions);
        $this->assertCount(2, $transitions['transitions']);
        $this->assertArrayHasKey('id', $transitions['transitions'][0]);
        $this->assertEquals(2, $transitions['transitions'][0]['id']);
    }

    public function testCreateTransition()
    {
        $issueClient = $this->getIssueClientMock($this->getResponseMock(204));
        $response = $issueClient->createTransition(10002, array());

        $this->assertEquals(204, $response->getCode());
        $this->assertNull($response->json());
    }

    protected function getIssueClientMock(Response $response)
    {
        $issueClientMock = $this
            ->getMockBuilder('JiraApi\Clients\IssueClient')
            ->disableOriginalConstructor()
            ->setMethods(array('getClient'))
            ->getMock();

        $issueClientMock
            ->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->getGuzzleClientMock($response)));

        return $issueClientMock;
    }

    protected function getIssueClientExceptionMock()
    {
        $issueClientMock = $this
            ->getMockBuilder('JiraApi\Clients\IssueClient')
            ->disableOriginalConstructor()
            ->setMethods(array('getClient'))
            ->getMock();

        $issueClientMock
            ->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->getGuzzleClientMockException()));

        return $issueClientMock;
    }
}

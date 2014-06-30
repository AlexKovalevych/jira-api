<?php

namespace JiraApi\Tests\Clients;

use GuzzleHttp\Message\Response;
use JiraApi\Clients\ProjectClient;
use JiraApi\Tests\ClientTestCase;

class ProjectClientTest extends ClientTestCase
{
    public function testGetAll()
    {
        $jsonFile = __DIR__ . '/../fixtures/project/getAll.json';
        $projectClient = $this->getProjectClientMock($this->getJsonResponseMock($jsonFile));
        $projects = $projectClient->getAll()->json();

        $this->assertCount(2, $projects);
        $this->assertArrayHasKey('id', $projects[0]);
        $this->assertEquals(10000, $projects[0]['id']);
        $this->assertArrayHasKey('name', $projects[0]);
        $this->assertEquals('Example', $projects[0]['name']);
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     */
    public function testGetAllException()
    {
        $projectClient = $this->getProjectClientExceptionMock();
        $projectClient->getAll();
    }

    public function testGet()
    {
        $jsonFile = __DIR__ . '/../fixtures/project/get.json';
        $projectClient = $this->getProjectClientMock($this->getJsonResponseMock($jsonFile));
        $project = $projectClient->get(10000)->json();

        $this->assertArrayHasKey('id', $project);
        $this->assertEquals(10000, $project['id']);
    }

    public function testGetVersions()
    {
        $jsonFile = __DIR__ . '/../fixtures/project/versions.json';
        $projectClient = $this->getProjectClientMock($this->getJsonResponseMock($jsonFile));
        $versions = $projectClient->getVersions(10000)->json();

        $this->assertCount(2, $versions);
        $this->assertArrayHasKey('id', $versions[0]);
        $this->assertEquals(10000, $versions[0]['id']);
    }

    public function testGetStatuses()
    {
        $jsonFile = __DIR__ . '/../fixtures/project/statuses.json';
        $projectClient = $this->getProjectClientMock($this->getJsonResponseMock($jsonFile));
        $statuses = $projectClient->getVersions(10000)->json();

        $this->assertCount(1, $statuses);
        $this->assertArrayHasKey('id', $statuses[0]);
        $this->assertEquals(3, $statuses[0]['id']);
        $this->assertArrayHasKey('statuses', $statuses[0]);
        $this->assertCount(2, $statuses[0]['statuses']);
        $this->assertArrayHasKey('id', $statuses[0]['statuses'][0]);
        $this->assertEquals(10000, $statuses[0]['statuses'][0]['id']);
    }

    protected function getProjectClientExceptionMock()
    {
        $issueClientMock = $this
            ->getMockBuilder('JiraApi\Clients\ProjectClient')
            ->disableOriginalConstructor()
            ->setMethods(array('getClient'))
            ->getMock();

        $issueClientMock
            ->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->getGuzzleClientMockException()));

        return $issueClientMock;
    }

    protected function getProjectClientMock(Response $response)
    {
        $projectClientMock = $this
            ->getMockBuilder('JiraApi\Clients\ProjectClient')
            ->disableOriginalConstructor()
            ->setMethods(array('getClient'))
            ->getMock();

        $projectClientMock
            ->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->getGuzzleClientMock($response)));

        return $projectClientMock;
    }
}

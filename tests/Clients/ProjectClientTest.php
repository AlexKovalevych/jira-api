<?php

namespace JiraApi\Tests\Clients;

use JiraApi\Clients\ProjectClient;
use JiraApi\Tests\ClientTestCase;

class ProjectClientTest extends ClientTestCase
{
    public function testGetAll()
    {
        $jsonFile = __DIR__ . '/../fixtures/project/getAll.json';

        $projectClient = $this->getProjectClientMock($jsonFile);
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

        $projectClient = $this->getProjectClientMock($jsonFile);
        $projectData = $projectClient->get(10000);
        $project = $projectData->json();

        $this->assertArrayHasKey('id', $project);
        $this->assertEquals(10000, $project['id']);
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

    protected function getProjectClientMock($jsonFile)
    {
        $response = $this->getJsonResponseMock($jsonFile);

        $issueClientMock = $this
            ->getMockBuilder('JiraApi\Clients\ProjectClient')
            ->disableOriginalConstructor()
            ->setMethods(array('getClient'))
            ->getMock();

        $issueClientMock
            ->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->getGuzzleClientMock($response)));

        return $issueClientMock;
    }
}

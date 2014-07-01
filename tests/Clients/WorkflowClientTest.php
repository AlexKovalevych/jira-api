<?php

namespace JiraApi\Tests\Clients;

use GuzzleHttp\Message\Response;
use JiraApi\Tests\ClientTestCase;

class WorkflowClientTest extends ClientTestCase
{
    public function testGetAll()
    {
        $jsonFile = __DIR__ . '/../fixtures/workflow/getAll.json';
        $workflowClient = $this->getWorkflowClientMock($this->getJsonResponseMock($jsonFile));
        $workflows = $workflowClient->getAll()->json();

        $this->assertCount(4, $workflows);
        $this->assertArrayHasKey('name', $workflows[0]);
        $this->assertEquals('jira', $workflows[0]['name']);
        $this->assertArrayHasKey('default', $workflows[0]);
        $this->assertTrue($workflows[0]['default']);
    }

    protected function getWorkflowClientMock(Response $response)
    {
        $workflowClientMock = $this
            ->getMockBuilder('JiraApi\Clients\WorkflowClient')
            ->disableOriginalConstructor()
            ->setMethods(array('getClient'))
            ->getMock();

        $workflowClientMock
            ->expects($this->any())
            ->method('getClient')
            ->will($this->returnValue($this->getGuzzleClientMock($response)));

        return $workflowClientMock;
    }
}

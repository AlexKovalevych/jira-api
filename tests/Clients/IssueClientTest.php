<?php

namespace JiraApi\Tests\Clients;

use JiraApi\Clients\IssueClient;
use JiraApi\Search\SearchBuilder;
use GuzzleHttp\Message\Response;
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

    public function testGetComments()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/comments.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $comments = $issueClient->getComments(10002)->json();

        $this->assertCount(4, $comments);
        $this->assertArrayHasKey('comments', $comments);
        $this->assertCount(1, $comments['comments']);
    }

    public function testGetCommentsError()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(404));
        $response = $issueClientMock->getComments(1);

        $this->assertEquals(404, $response->getCode());
    }

    public function testCreateComment()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/comment.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $response = $issueClient->createComment(10000, array())->json();

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals(10000, $response['id']);
        $this->assertArrayHasKey('author', $response);
        $this->assertArrayHasKey('body', $response);
    }

    public function testCreateCommentError()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(400));
        $response = $issueClientMock->createComment(1, array());

        $this->assertEquals(400, $response->getCode());
    }

    public function testUpdateComment()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/comment.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $response = $issueClient->updateComment(10000, 10000, array())->json();

        $this->assertArrayHasKey('id', $response);
        $this->assertEquals(10000, $response['id']);
        $this->assertArrayHasKey('author', $response);
        $this->assertArrayHasKey('body', $response);
    }

    public function testUpdateCommentError()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(400));
        $response = $issueClientMock->updateComment(1, 1, array());

        $this->assertEquals(400, $response->getCode());
        $this->assertNull($response->json());
    }

    public function testDeleteComment()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(204));
        $response = $issueClientMock->deleteComment(10002, 10000);

        $this->assertEquals(204, $response->getCode());
        $this->assertNull($response->json());
    }

    public function testDeleteCommentError()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(404));
        $response = $issueClientMock->deleteComment(10002, 10000);

        $this->assertEquals(404, $response->getCode());
        $this->assertNull($response->json());
    }

    public function testGetFullWorklog()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/fullWorklog.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $worklogs = $issueClient->getFullWorklog(10002)->json();

        $this->assertArrayHasKey('worklogs', $worklogs);
        $this->assertCount(1, $worklogs['worklogs']);
        $this->assertArrayHasKey('id', $worklogs['worklogs'][0]);
        $this->assertEquals(100028, $worklogs['worklogs'][0]['id']);
    }

    public function testCreateWorklog()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(200));
        $response = $issueClientMock->createWorklog(10002, array());

        $this->assertEquals(200, $response->getCode());
    }

    public function testCreateWorklogError()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(400));
        $response = $issueClientMock->createWorklog(10002, array());

        $this->assertEquals(400, $response->getCode());
    }

    public function testGetWorklog()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/worklog.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $worklog = $issueClient->getWorklog(10002, 100028)->json();

        $this->assertArrayHasKey('id', $worklog);
        $this->assertEquals(100028, $worklog['id']);
    }

    public function testUpdateWorklog()
    {
        $jsonFile = __DIR__ . '/../fixtures/issue/worklog.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $worklog = $issueClient->updateWorklog(10002, 100028, array())->json();

        $this->assertArrayHasKey('id', $worklog);
        $this->assertEquals(100028, $worklog['id']);
    }

    public function testUpdateWorklogError()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(400));
        $response = $issueClientMock->updateWorklog(10002, 100028, array());

        $this->assertEquals(400, $response->getCode());
    }

    public function testDeleteWorklog()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(204));
        $response = $issueClientMock->deleteWorklog(10002, 100028);

        $this->assertEquals(204, $response->getCode());
    }

    public function testDeleteWorklogError()
    {
        $issueClientMock = $this->getIssueClientMock($this->getResponseMock(400));
        $response = $issueClientMock->deleteWorklog(10002, 100028);

        $this->assertEquals(400, $response->getCode());
    }

    public function testSearch()
    {
        $builder = new SearchBuilder();
        $builder->setJql('project = PROJ');

        $jsonFile = __DIR__ . '/../fixtures/issue/search.json';
        $issueClient = $this->getIssueClientMock($this->getJsonResponseMock($jsonFile));
        $searchResults = $issueClient->search($builder)->json();

        $this->assertArrayHasKey('issues', $searchResults);
        $this->assertCount(1, $searchResults['issues']);
        $this->assertArrayHasKey('id', $searchResults['issues'][0]);
        $this->assertEquals(10001, $searchResults['issues'][0]['id']);
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

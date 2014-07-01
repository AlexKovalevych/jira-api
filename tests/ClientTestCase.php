<?php

namespace JiraApi\Tests;

use GuzzleHttp\Exception\BadResponseException;

class ClientTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getGuzzleClientMock($response)
    {
        $guzzleClientMock = $this
            ->getMockBuilder('GuzzleHttp\Client')
            ->setMethods(array('send'))
            ->getMock();

        $guzzleClientMock
            ->expects($this->any())
            ->method('send')
            ->will($this->returnValue($response));

        return $guzzleClientMock;
    }

    protected function getGuzzleClientMockException()
    {
        $requestMock = $this->getMock('GuzzleHttp\Message\RequestInterface');

        $guzzleClientMock = $this
            ->getMockBuilder('GuzzleHttp\Client')
            ->setMethods(array('send'))
            ->getMock();

        $guzzleClientMock
            ->expects($this->any())
            ->method('send')
            ->will(
                $this->throwException(new BadResponseException('', $requestMock))
            );

        return $guzzleClientMock;
    }

    protected function getResponseMock($code = 200, $body = null)
    {
        $response = $this
            ->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->setMethods(array('getCode', 'getBody'))
            ->getMock();

        $response
            ->expects($this->any())
            ->method('getCode')
            ->will($this->returnValue($code));

        $response
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue($body));

        return $response;
    }

    protected function getJsonResponseMock($jsonFile)
    {
        $jsonResponseMock = new JsonResponseMock($jsonFile);

        return $this->getResponseMock(200, $jsonResponseMock->getData());
    }
}

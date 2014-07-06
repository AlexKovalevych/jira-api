<?php

/**
 * This file is part of Jira API package.
 *
 * (c) 2014 Alex Kovalevych <alexkovalevych@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace JiraApi\Clients;

class WorkflowClient extends AbstractClient
{
    /**
     * Returns all workflows
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e576
     *
     * @return \GuzzleHttp\Message\Response
     */
    public function getAll()
    {
        return $this->getRequest('workflow');
    }
}

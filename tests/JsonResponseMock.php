<?php

/**
 * This file is part of Jira API package.
 *
 * (c) 2014 Alex Kovalevych <alexkovalevych@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace JiraApi\Tests;

class JsonResponseMock
{
    /**
     * @var string
     */
    protected $data;

    /**
     * @param string $jsonFile
     */
    public function __construct($jsonFile)
    {
        $this->data = file_get_contents($jsonFile);
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function json()
    {
        return json_decode($this->data, true);
    }
}

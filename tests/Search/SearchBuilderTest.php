<?php

namespace JiraApi\Tests\Search;

use JiraApi\Search\SearchBuilder;

class SearchBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testSetPage()
    {
        $builder = new SearchBuilder();

        $builder->setPage(1);
        $this->assertEquals(0, $builder->getSkip());

        $builder->setPage(10);
        $this->assertEquals($builder->getLimit() * 9, $builder->getSkip());
    }

    public function testExecute()
    {
        $builder = new SearchBuilder();

        $this->assertEquals(
            [
                'jql'           => null,
                'startAt'       => null,
                'maxResults'    => $builder->getLimit(),
                'validateQuery' => true,
                'fields'        => null,
                'expand'        => null
            ],
            $builder->execute()
        );

        $builder
            ->setJql('project = test')
            ->setPage(5)
            ->setValidateQuery(false)
            ->setFields(['id', 'key', 'assignee'])
            ->setExpandFields(['assignee'])
        ;
        $this->assertEquals(
            [
                'jql'           => 'project = test',
                'startAt'       => 80,
                'maxResults'    => $builder->getLimit(),
                'validateQuery' => false,
                'fields'        => ['id', 'key', 'assignee'],
                'expand'        => ['assignee']
            ],
            $builder->execute()
        );
    }
}

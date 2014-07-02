<?php

namespace JiraApi\Search;

class SearchBuilder
{
    /**
     * @var string
     */
    protected $jql;

    /**
     * @var int
     */
    protected $skip;

    /**
     * @var int
     */
    protected $limit = 20;

    /**
     * @var boolean
     */
    protected $validateQuery = true;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $expandFields;

    /**
     * @return string
     */
    public function getJql()
    {
        return $this->jql;
    }

    /**
     * @param string $jql
     *
     * @return  self
     */
    public function setJql($jql)
    {
        $this->jql = $jql;

        return $this;
    }

    /**
     * @return int
     */
    public function getSkip()
    {
        return $this->skip;
    }

    /**
     * @param int $skip
     *
     * @return  self
     */
    public function setSkip($skip)
    {
        $this->skip = $skip;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return  self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getValidateQuery()
    {
        return $this->validateQuery;
    }

    /**
     * @param boolean $validateQuery
     *
     * @return  self
     */
    public function setValidateQuery($validateQuery)
    {
        $this->validateQuery = $validateQuery;

        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     *
     * @return  self
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return array
     */
    public function getExpandFields()
    {
        return $this->expandFields;
    }

    /**
     * @param array $expandFields
     *
     * @return  self
     */
    public function setExpandFields(array $expandFields)
    {
        $this->expandFields = $expandFields;

        return $this;
    }

    /**
     * @param int $page
     *
     * @return  self
     */
    public function setPage($page)
    {
        $this->skip = ($page - 1) * $this->limit;

        return $this;
    }

    /**
     * @return array
     */
    public function execute()
    {
        return array(
            'jql'           => $this->jql,
            'startAt'       => $this->skip,
            'maxResults'    => $this->limit,
            'validateQuery' => $this->validateQuery,
            'fields'        => $this->fields,
            'expand'        => $this->expandFields
        );
    }
}

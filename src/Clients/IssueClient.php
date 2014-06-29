<?php

namespace JiraApi\Clients;

use JiraApi\Clients\AbstractClient;

class IssueClient extends AbstractClient
{
    /**
     * Returns issue by id or key.
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1375
     *
     * @param  integer|string $idOrKey
     * @param  array          $fields array of fields to be returns (return all by default)
     *
     * @return GuzzleHttp\Message\Response
     */
    public function get($idOrKey, array $fields = null)
    {
        $parameters = $fields ? sprintf('?%s', $this->createUriParameters(array(
            'fields' => implode(',', $fields)
        ))) : '';

        return $this->getRequest(sprintf('issue/%s%s', $idOrKey, $parameters));
    }

    /**
     * Creates a new issue or a sub-task
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1079
     *
     * @param  array $data
     *
     * @return GuzzleHttp\Message\Response
     */
    public function create(array $data)
    {
        return $this->postRequest('issue', $data);
    }

    /**
     * Deletes an issue by id or key
     *
     * @link https://docs.atlassian.com/jira/REST/latest/#d2e1401
     *
     * @param  integer|string  $idOrKey
     * @param  boolean         $deleteSubtasks
     *
     * @return GuzzleHttp\Message\Response
     */
    public function delete($idOrKey, $deleteSubtasks = false)
    {
        $parameters = sprintf('?deleteSubtasks=%s', $deleteSubtasks);

        return $this->deleteRequest(sprintf('issue/%s%s', $idOrKey, $parameters));
    }

    /**
     * Updates issue by id or key with given data
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1424
     *
     * @param  integer|string $idOrKey
     * @param  array          $data
     *
     * @return GuzzleHttp\Message\Response
     */
    public function update($idOrKey, array $data)
    {
        return $this->putRequest(sprintf('issue/%s', $idOrKey), $data);
    }

    /**
     * Get a list of the possible transitions
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1289
     *
     * @param  integer|string $idOrKey
     *
     * @return GuzzleHttp\Message\Response
     */
    public function getTransitions($idOrKey)
    {
        return $this->getRequest(sprintf('issue/%s/transitions', $idOrKey));
    }

    /**
     * Updates issue transition by its id or key
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1312
     *
     * @param  integer|string $idOrKey
     * @param  array          $data
     *
     * @return GuzzleHttp\Message\Response
     */
    public function createTransition($idOrKey, array $data)
    {
        return $this->postRequest(sprintf('issue/%s/transitions', $idOrKey), $data);
    }
}

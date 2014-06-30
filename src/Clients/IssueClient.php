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

    /**
     * Returns comments by issue id or key
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1143
     *
     * @param  integer|string $idOrKey
     *
     * @return GuzzleHttp\Message\Response
     */
    public function getComments($idOrKey)
    {
        return $this->getRequest(sprintf('issue/%s/comment', $idOrKey));
    }

    /**
     * Creates a new comment by issue id or key
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1164
     *
     * @param  integer|string $idOrKey
     * @param  array          $data
     *
     * @return GuzzleHttp\Message\Response
     */
    public function createComment($idOrKey, array $data)
    {
        return $this->postRequest(sprintf('issue/%s/comment', $idOrKey), $data);
    }

    /**
     * Updates a comment by issue id or key, comment id with given data
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1221
     *
     * @param  integer|string $idOrKey
     * @param  integer        $commentId
     * @param  array          $data
     *
     * @return GuzzleHttp\Message\Response
     */
    public function updateComment($idOrKey, $commentId, array $data)
    {
        return $this->putRequest(sprintf('issue/%s/comment/%s', $idOrKey, $commentId), $data);
    }

    /**
     * Deletes a comment by issue id or key, comment id
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1250
     *
     * @param  integer|string $idOrKey
     * @param  integer        $commentId
     *
     * @return GuzzleHttp\Message\Response
     */
    public function deleteComment($idOrKey, $commentId)
    {
        return $this->deleteRequest(sprintf('issue/%s/comment/%s', $idOrKey, $commentId));
    }

    /**
     * Returns full worklog for the issue by issue id or key
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1771
     *
     * @param  integer|string $idOrKey
     *
     * @return GuzzleHttp\Message\Response
     */
    public function getFullWorklog($idOrKey)
    {
        return $this->getRequest(sprintf('issue/%s/worklog', $idOrKey));
    }

    /**
     * Creates worklog for the issue by issue id or key
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1788
     *
     * @param  integer|string $idOrKey
     * @param  array          $data
     * @param  string         $adjustEstimate ("new", "leave", "manual", "auto")
     * @param  string         $newEstimate    (required for "new" adjustEstimate)
     * @param  string         $reduceBy       (required for "manual" adjustEstimate)
     *
     * @return GuzzleHttp\Message\Response
     */
    public function createWorklog($idOrKey, array $data, $adjustEstimate = null, $newEstimate = null, $reduceBy = null)
    {
        $parameters = http_build_query(array(
            'adjustEstimate' => $adjustEstimate,
            'newEstimate'    => $newEstimate,
            'reduceBy'       => $reduceBy,
        ));

        if ($parameters) {
            $parameters = sprintf('?%s', $parameters);
        }

        return $this->postRequest(sprintf('issue/%s/worklog%s', $idOrKey, $parameters), $data);
    }

    /**
     * Returns worklog for the issue by issue id or key and worklog id
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1826
     *
     * @param  integer|string $idOrKey
     * @param  integer        $worklogId
     *
     * @return GuzzleHttp\Message\Response
     */
    public function getWorklog($idOrKey, $worklogId)
    {
        return $this->getRequest(sprintf('issue/%s/worklog/%s', $idOrKey, $worklogId));
    }

    /**
     * Updates worklog for the issue by issue id or key and worklog id
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1843
     *
     * @param  integer|string $idOrKey
     * @param  integer        $worklogId
     * @param  array          $data
     * @param  string         $adjustEstimate
     * @param  string         $newEstimate
     *
     * @return GuzzleHttp\Message\Response
     */
    public function updateWorklog($idOrKey, $worklogId, array $data, $adjustEstimate = null, $newEstimate = null)
    {
        $parameters = http_build_query(array(
            'adjustEstimate' => $adjustEstimate,
            'newEstimate'    => $newEstimate,
        ));

        if ($parameters) {
            $parameters = sprintf('?%s', $parameters);
        }

        return $this->putRequest(sprintf('issue/%s/worklog/%s%s', $idOrKey, $worklogId, $parameters), $data);
    }

    /**
     * Deletes worklog for the issue by issue id or key and worklog id
     *
     * @link  https://docs.atlassian.com/jira/REST/latest/#d2e1878
     *
     * @param  integer|string $idOrKey
     * @param  integer        $worklogId
     * @param  string         $adjustEstimate
     * @param  string         $newEstimate
     * @param  string         $increaseBy
     *
     * @return GuzzleHttp\Message\Response
     */
    public function deleteWorklog($idOrKey, $worklogId, $adjustEstimate = null, $newEstimate = null, $increaseBy = null)
    {
        $parameters = http_build_query(array(
            'adjustEstimate' => $adjustEstimate,
            'newEstimate'    => $newEstimate,
            'increaseBy'     => $increaseBy,
        ));

        if ($parameters) {
            $parameters = sprintf('?%s', $parameters);
        }

        return $this->deleteRequest(sprintf('issue/%s/worklog/%s%s', $idOrKey, $worklogId, $parameters));
    }
}

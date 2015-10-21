![Build status](https://travis-ci.org/AlexKovalevych/jira-api.svg?branch=master)

# Usage

Create a client providing your jira api `url`, `username` and `password`:

```php
$client = new IssueClient('https://myproject.atlassian.com/rest/api/latest', 'login', 'password');
```

Now you're able to run api requests with that client:

```php
$issue = json_decode($client->get($issueId))->getBody()->getContents());
```

And don't forget about error handling (check [guzzle documentation](http://docs.guzzlephp.org/en/latest/quickstart.html#exceptions) about more information):

```php
try {
	$response = $client->getIssue($issueId);
} catch (RequestException $e) {
	...
}
```

### Supported clients

- Issue
- Workflow
- Project

### TODO

- Cover more api endpoints

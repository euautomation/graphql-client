<?php

namespace EUAutomation\GraphQL;

use EUAutomation\GraphQL\Exceptions\GraphQLInvalidResponse;
use EUAutomation\GraphQL\Exceptions\GraphQLMissingData;

class Client
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * Client constructor.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->guzzle = new \GuzzleHttp\Client();
    }

    /**
     * Set the URL to query against
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Set an instance of guzzle to use
     *
     * @param \GuzzleHttp\Client $guzzle
     */
    public function setGuzzle(\GuzzleHttp\Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * Make a GraphQL Request and get the raw guzzle response.
     *
     * @param string $query
     * @param array $variables
     * @param array $headers
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function raw($query, $variables = [], $headers = [])
    {
        return $this->guzzle->request('POST', $this->url, [
            'json' => [
                'query' => $query,
                'variables' => $variables
            ],
            'headers' => $headers
        ]);
    }

    /**
     * Make a GraphQL Request and get the response body in JSON form.
     *
     * @param string $query
     * @param array $variables
     * @param array $headers
     * @param bool $assoc
     *
     * @return mixed
     *
     * @throws GraphQLInvalidResponse
     * @throws GraphQLMissingData
     */
    public function json($query, $variables = [], $headers = [], $assoc = false)
    {
        $response = $this->raw($query, $variables, $headers);

        $responseJson = json_decode($response->getBody()->getContents(), $assoc);

        if ($responseJson === null) {
            throw new GraphQLInvalidResponse('GraphQL did not provide a valid JSON response. Please make sure you are pointing at the correct URL.');
        } else if (!isset($responseJson->data)) {
            throw new GraphQLMissingData('There was an error with the GraphQL response, no data key was found.');
        }

        return $responseJson;
    }

    /**
     * Make a GraphQL Request and get the guzzle response .
     *
     * @param string $query
     * @param array $variables
     * @param array $headers
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function response($query, $variables = [], $headers = [])
    {
        $response = $this->json($query, $variables, $headers);

        return new Response($response);
    }
}
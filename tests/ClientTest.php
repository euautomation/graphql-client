<?php

namespace Tests;

use EUAutomation\GraphQL\Client;
use EUAutomation\GraphQL\Exceptions\GraphQLInvalidResponse;
use EUAutomation\GraphQL\Exceptions\GraphQLMissingData;
use EUAutomation\GraphQL\Response;
use GuzzleHttp\ClientInterface;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testClientReturnsRaw()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}}}';

        $stream = \Mockery::mock(\Psr\Http\Message\StreamInterface::class);
        $stream->shouldReceive('getContents')->andReturn($data);

        $responseMessage = \Mockery::mock(\Psr\Http\Message\ResponseInterface::class);
        $responseMessage->shouldReceive('getBody')->andReturn($stream);

        $guzzleClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $guzzleClient->shouldReceive('request')->andReturn($responseMessage);

        $client = new Client('SomeWebsite');
        $client->setGuzzle($guzzleClient);
        $client->setUrl('');
        $response = $client->raw('')->getBody()->getContents();

        static::assertEquals($data, $response);
    }

    public function testClientReturnsJson()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}}}';

        $stream = \Mockery::mock(\Psr\Http\Message\StreamInterface::class);
        $stream->shouldReceive('getContents')->andReturn($data);

        $responseMessage = \Mockery::mock(\Psr\Http\Message\ResponseInterface::class);
        $responseMessage->shouldReceive('getBody')->andReturn($stream);

        $guzzleClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $guzzleClient->shouldReceive('request')->andReturn($responseMessage);

        $client = new Client('SomeWebsite');
        $client->setGuzzle($guzzleClient);
        $response = $client->json('');

        static::assertEquals(json_decode($data), $response);
    }

    public function testClientReturnsInvalidJsonException()
    {
        $data = '{"data":{"On';

        $stream = \Mockery::mock(\Psr\Http\Message\StreamInterface::class);
        $stream->shouldReceive('getContents')->andReturn($data);

        $responseMessage = \Mockery::mock(\Psr\Http\Message\ResponseInterface::class);
        $responseMessage->shouldReceive('getBody')->andReturn($stream);

        $guzzleClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $guzzleClient->shouldReceive('request')->andReturn($responseMessage);

        $client = new Client('SomeWebsite');
        $client->setGuzzle($guzzleClient);

        static::expectException(GraphQLInvalidResponse::class);
        $response = $client->json('');

        static::assertEquals(json_decode($data), $response);
    }

    public function testClientReturnsJsonMissingDataException()
    {
        $data = '{}';

        $stream = \Mockery::mock(\Psr\Http\Message\StreamInterface::class);
        $stream->shouldReceive('getContents')->andReturn($data);

        $responseMessage = \Mockery::mock(\Psr\Http\Message\ResponseInterface::class);
        $responseMessage->shouldReceive('getBody')->andReturn($stream);

        $guzzleClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $guzzleClient->shouldReceive('request')->andReturn($responseMessage);

        $client = new Client('SomeWebsite');
        $client->setGuzzle($guzzleClient);

        static::expectException(GraphQLMissingData::class);
        $response = $client->json('');

        static::assertEquals(json_decode($data), $response);
    }

    public function testClientReturnsResponse()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}}}';

        $json = json_decode($data);

        $stream = \Mockery::mock(\Psr\Http\Message\StreamInterface::class);
        $stream->shouldReceive('getContents')->andReturn($data);

        $responseMessage = \Mockery::mock(\Psr\Http\Message\ResponseInterface::class);
        $responseMessage->shouldReceive('getBody')->andReturn($stream);

        $guzzleClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $guzzleClient->shouldReceive('request')->andReturn($responseMessage);

        $client = new Client('SomeWebsite');
        $client->setGuzzle($guzzleClient);
        $response = $client->response('');

        static::assertInstanceOf(Response::class, $response);
    }
}
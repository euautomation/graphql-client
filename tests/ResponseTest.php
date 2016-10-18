<?php

namespace Tests;

use EUAutomation\GraphQL\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    private $data;

    public function setUp()
    {
        parent::setUp();
    }

    public function testResponseReturnsAllData()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}},"errors":[{"message":"Error",' .
            '"locations":[{"line":1,"column":28}]},{"message":"Error","locations":[{"line":1,"column":28}]}]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertEquals($jsonObj->data, $response->all());
    }

    public function testResponseHasErrors()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}},"errors":[{"message":"Error",' .
            '"locations":[{"line":1,"column":28}]},{"message":"Error","locations":[{"line":1,"column":28}]}]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertTrue($response->hasErrors());
    }

    public function testResponseHasNoErrors()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}}}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertNotTrue($response->hasErrors());
    }

    public function testResponseReturnsErrors()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}},"errors":[{"message":"Error",' .
            '"locations":[{"line":1,"column":28}]},{"message":"Error","locations":[{"line":1,"column":28}]}]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertEquals($jsonObj->errors, $response->errors());
    }


    public function testResponseReturnsNoErrors()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}}}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertEquals([], $response->errors());
    }

    public function testResponseReturnsJson()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}},"errors":[{"message":"Error",' .
            '"locations":[{"line":1,"column":28}]},{"message":"Error","locations":[{"line":1,"column":28}]}]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertEquals(json_encode($jsonObj->data), $response->toJson());
    }

    public function testCanGetValueFromResponse()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}},"errors":[{"message":"Error",' .
            '"locations":[{"line":1,"column":28}]},{"message":"Error","locations":[{"line":1,"column":28}]}]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertEquals('sv', $response->One->translations[0]->code);
        static::assertEquals('Two Name', $response->Two->name);
    }

    public function testIssetReturnsCorrectly()
    {
        $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
            '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}},"errors":[{"message":"Error",' .
            '"locations":[{"line":1,"column":28}]},{"message":"Error","locations":[{"line":1,"column":28}]}]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertTrue(isset($response->One->translations[0]->code));
        static::assertNotTrue(isset($response->Two->translations[0]->code));
    }
}
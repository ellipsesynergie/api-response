<?php

namespace EllipseSynergie\ApiResponse\Tests;

use EllipseSynergie\ApiResponse\Tests\ResponseFaker as Response;
use League\Fractal\Manager;

/**
 * Class ResponseTest
 *
 * @package EllipseSynergie\ApiResponse\Tests
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->response = new Response(new Manager());
    }

    public function testSetStatusCodeWorkProperly()
    {
        $this->response->setStatusCode(201);

        $this->assertSame(201, $this->response->getStatusCode());
    }

    public function testDefaultStatusCodeIs200()
    {
        $this->assertSame(200, $this->response->getStatusCode());
    }

    public function testErrorForbiddenStatusCodeIs403()
    {
        $response = $this->response->errorForbidden();
        $this->assertSame(403, $response['status']);
    }

    public function testErrorInternalErrorStatusCodeIs500()
    {
        $response = $this->response->errorInternalError();
        $this->assertSame(500, $response['status']);
    }

    public function testErrorNotFoundStatusCodeIs404()
    {
        $response = $this->response->errorNotFound();
        $this->assertSame(404, $response['status']);
    }

    public function testErrorUnauthorizedStatusCodeIs401()
    {
        $response = $this->response->errorUnauthorized();
        $this->assertSame(401, $response['status']);
    }

    public function testErrorWrongArgsStatusCodeIs400()
    {
        $response = $this->response->errorWrongArgs();
        $this->assertSame(400, $response['status']);
    }

    public function testErrorGoneStatusCodeIs410()
    {
        $response = $this->response->errorGone();
        $this->assertSame(410, $response['status']);
    }

    public function testErrorMethodNotAllowedStatusCodeIs405()
    {
        $response = $this->response->errorMethodNotAllowed();
        $this->assertSame(405, $response['status']);
    }

    public function testErrorUnwillingToProcessStatusCodeIs405()
    {
        $response = $this->response->errorUnwillingToProcess();
        $this->assertSame(431, $response['status']);
    }

    public function testWithItemReturnDataProperly()
    {
        $item = ['foo' => 'bar'];

        $response = $this->response->withItem($item, function($data){
            return $data;
        });

        $this->assertSame('bar', $response['data']['foo']);
    }

    public function testWithCollecrtionReturnDataProperly()
    {
        $item = [
            ['foo' => 'bar'],
            ['foo' => 'maxime'],
        ];

        $response = $this->response->withCollection($item, function($data){
            return $data;
        });

        $this->assertSame('bar', $response['data'][0]['foo']);
        $this->assertSame('maxime', $response['data'][1]['foo']);
    }
}
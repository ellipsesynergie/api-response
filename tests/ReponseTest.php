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

    public function testErrorForbiddenStatusCode()
    {
        $response = $this->response->errorForbidden();
        $this->assertSame(403, $response['status']);
    }

    public function testErrorInternalErrorStatusCode()
    {
        $response = $this->response->errorInternalError();
        $this->assertSame(500, $response['status']);
    }

    public function testErrorNotFoundStatusCode()
    {
        $response = $this->response->errorNotFound();
        $this->assertSame(404, $response['status']);
    }

    public function testErrorUnauthorizedStatusCode()
    {
        $response = $this->response->errorUnauthorized();
        $this->assertSame(401, $response['status']);
    }

    public function testErrorWrongArgsStatusCode()
    {
        $response = $this->response->errorWrongArgs();
        $this->assertSame(400, $response['status']);
    }

    public function testErrorGoneStatusCode()
    {
        $response = $this->response->errorGone();
        $this->assertSame(410, $response['status']);
    }

    public function testErrorMethodNotAllowedStatusCode()
    {
        $response = $this->response->errorMethodNotAllowed();
        $this->assertSame(405, $response['status']);
    }
}
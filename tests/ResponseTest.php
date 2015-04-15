<?php

namespace EllipseSynergie\ApiResponse\Tests;

use EllipseSynergie\ApiResponse\Tests\ResponseFaker as Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;

/**
 * Class ResponseTest
 *
 * @package EllipseSynergie\ApiResponse\Tests
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    protected $response;

    public function setUp()
    {
        $this->response = new Response(new Manager());
    }

    public function testImplementContractProperly()
    {
        $this->assertInstanceOf('EllipseSynergie\ApiResponse\Contracts\Response', $this->response);
    }

    public function testGetManager()
    {
        $this->assertInstanceOf('League\Fractal\Manager', $this->response->getManager());
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

        $response = $this->response->withItem($item, function ($data) {
            return $data;
        });

        $this->assertSame('bar', $response['data']['foo']);
    }

    public function testWithItemReturnMetaProperly()
    {
        $item = ['foo' => 'bar'];

        $response = $this->response->withItem($item, function ($data) {
            return $data;
        }, 'data', ['foo' => 'bar']);

        $this->assertSame('bar', $response['meta']['foo']);
    }

    public function testWithCollectionReturnDataProperly()
    {
        $item = [
            ['foo' => 'bar'],
            ['foo' => 'maxime'],
        ];

        $response = $this->response->withCollection($item, function ($data) {
            return $data;
        });

        $this->assertSame('bar', $response['data'][0]['foo']);
        $this->assertSame('maxime', $response['data'][1]['foo']);
    }

    public function testWithCollectionReturnMetaProperly()
    {
        $item = [
            ['foo' => 'bar'],
            ['foo' => 'maxime'],
        ];

        $response = $this->response->withCollection($item, function ($data) {
            return $data;
        }, null, null, ['foo' => 'bar']);

        $this->assertSame('bar', $response['meta']['foo']);
    }

    public function testWithCollectionReturnCursorProperly()
    {
        $item = [
            ['foo' => 'bar'],
            ['foo' => 'maxime'],
        ];

        $response = $this->response->withCollection($item, function ($data) {
            return $data;
        }, null, new Cursor(100, 1, 200, 300), ['foo' => 'bar']);

        $this->assertSame(
            [
                'current' => 100,
                'prev' => 1,
                'next' => 200,
                'count' => 300,
            ],
            $response['meta']['cursor']
        );
    }
}

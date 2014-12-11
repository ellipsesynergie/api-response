<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

use League\Fractal\Manager;
use Mockery as m;

/**
 * Class ResponseTest
 *
 * @package EllipseSynergie\ApiResponse\Tests
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorWrongArgsValidator()
    {
        $messageBag = m::mock('Illuminate\Support\MessageBag');
        $messageBag->shouldReceive('toArray')->andReturn(['foo' => 'bar']);

        $validator = m::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('messages')->once()->andReturn($messageBag);
        $response = new Response(new Manager());

        $response->errorWrongArgsValidator($validator);
    }

    public function testWithPaginatorWorkProperly()
    {
        $paginator = m::mock('Illuminate\Pagination\Paginator');
        $paginator->shouldReceive('getCollection')->andReturn([['foo' => 'bar']]);
        $paginator->shouldReceive('getCurrentPage')->andReturn(1);
        $paginator->shouldReceive('getLastPage')->andReturn(2);
        $paginator->shouldReceive('getTotal')->andReturn(3);
        $paginator->shouldReceive('getPerPage')->andReturn(1);
        $paginator->shouldReceive('getUrl')->andReturn('localhost');
        $paginator->shouldReceive('count')->andReturn(3);

        $response = new Response(new Manager());

        $result = $response->withPaginator($paginator, function ($data) {
            return $data;
        }, 'data', ['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $result['data'][0]);
        $this->assertSame('bar', $result['meta']['foo']);
        $this->assertSame(
            [
                'total' => 3,
                'count' => 3,
                'per_page' => 1,
                'current_page' => 1,
                'total_pages' => 2,
                'links' => [
                    'next' => 'localhost'
                ],
            ],
            $result['meta']['pagination']
        );
    }

    public function tearDown()
    {
        m::close();
    }
}

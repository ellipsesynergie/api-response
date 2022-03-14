<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

use League\Fractal\Manager;
use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseTest
 *
 * @package EllipseSynergie\ApiResponse\Tests\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseTest extends TestCase
{
    public function testErrorWrongArgsValidator()
    {
        $messageBag = m::mock('Illuminate\Support\MessageBag');
        $messageBag->shouldReceive('toArray')->andReturn(['foo' => 'bar']);

        $validator = m::mock('Illuminate\Contracts\Validation\Validator');
        $validator->shouldReceive('getMessageBag')->once()->andReturn($messageBag);
        $response = new ResponseFake(new Manager());

        $response->errorWrongArgsValidator($validator);

        $this->assertSame(400, $response->getStatusCode());
    }

    public function testWithPaginatorWorkProperly()
    {
        $paginator = m::mock('Illuminate\Contracts\Pagination\LengthAwarePaginator');
        $paginator->shouldReceive('items')->andReturn([['foo' => 'bar']]);
        $paginator->shouldReceive('currentPage')->andReturn(1);
        $paginator->shouldReceive('lastPage')->andReturn(2);
        $paginator->shouldReceive('total')->andReturn(3);
        $paginator->shouldReceive('perPage')->andReturn(1);
        $paginator->shouldReceive('url')->andReturn('localhost');
        $paginator->shouldReceive('count')->andReturn(3);
        $paginator->shouldReceive('appends')->andReturn([['foo' => 'bar']]);

        $response = new ResponseFake(new Manager());

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

    public function tearDown(): void
    {
        m::close();
    }
}

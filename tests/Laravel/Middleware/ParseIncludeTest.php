<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel\Middleware;

use EllipseSynergie\ApiResponse\Laravel\Middleware\ParseInclude;
use EllipseSynergie\ApiResponse\Laravel\Response;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use PHPUnit\Framework\TestCase;

class ParseIncludeTest extends TestCase
{
    public function testHandleWorkProperly()
    {
        $manager = new Manager();

        $response = new Response($manager);

        $middleware = new ParseInclude($response);

        $request = Request::create('foo', 'GET', ['include' => 'foo,bar']);

        $result = $middleware->handle($request, function (Request $request) {
            $this->assertInstanceOf('Illuminate\Http\Request', $request);
            return 'callback working !';
        });

        $includes = $response->getManager()->getRequestedIncludes();

        $this->assertSame($manager, $response->getManager());
        $this->assertSame([
            'foo',
            'bar'
        ], $includes);
        $this->assertSame('callback working !', $result);
    }
}

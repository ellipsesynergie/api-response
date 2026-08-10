<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

use EllipseSynergie\ApiResponse\Contracts\Response as ResponseContract;
use EllipseSynergie\ApiResponse\Laravel\Response;
use EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider;
use EllipseSynergie\ApiResponse\Serializer\Serializer;
use EllipseSynergie\ApiResponse\Tests\Serializer\OptionalKeySerializer;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class ResponseServiceProviderTest
 *
 * @package EllipseSynergie\ApiResponse\Tests\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseServiceProviderTest extends TestCase
{
    public function testResponseIsResolvableFromTheContainer()
    {
        $container = $this->registerProvider();

        $response = $container->make(ResponseContract::class);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testIncludesAreParsedFromCsvString()
    {
        $container = $this->registerProvider(['include' => 'author,comments']);

        $response = $container->make(ResponseContract::class);

        $this->assertSame(['author', 'comments'], $response->getManager()->getRequestedIncludes());
    }

    public function testIncludesAreParsedFromArray()
    {
        $container = $this->registerProvider(['include' => ['author', 'comments']]);

        $response = $container->make(ResponseContract::class);

        $this->assertSame(['author', 'comments'], $response->getManager()->getRequestedIncludes());
    }

    public function testMissingIncludeParameterParsesNothing()
    {
        $container = $this->registerProvider();

        $response = $container->make(ResponseContract::class);

        $this->assertSame([], $response->getManager()->getRequestedIncludes());
    }

    public function testResponseIsBuiltLazilyFromTheCurrentRequest()
    {
        $container = new Container();
        (new ResponseServiceProvider($container))->register();

        // The request is bound after the provider is registered, like the kernel does when
        // handling a request. The response must be built from it anyway.
        $container->instance('request', Request::create('/', 'GET', ['include' => 'author']));

        $response = $container->make(ResponseContract::class);

        $this->assertSame(['author'], $response->getManager()->getRequestedIncludes());
    }

    public function testBindingIsScoped()
    {
        $container = $this->registerProvider();

        $response = $container->make(ResponseContract::class);

        $this->assertSame($response, $container->make(ResponseContract::class));

        $container->forgetScopedInstances();

        $this->assertNotSame($response, $container->make(ResponseContract::class));
    }

    public function testDefaultSerializerIsUsed()
    {
        $container = $this->registerProvider();

        $response = $container->make(ResponseContract::class);

        $this->assertInstanceOf(Serializer::class, $response->getManager()->getSerializer());
    }

    public function testSerializerCanBeOverridden()
    {
        $container = new Container();
        $container->instance('request', Request::create('/', 'GET'));
        (new ResponseServiceProviderFake($container))->register();

        $response = $container->make(ResponseContract::class);

        $this->assertInstanceOf(OptionalKeySerializer::class, $response->getManager()->getSerializer());
    }

    public function testDeprecatedApiMacroResolvesTheResponseFromTheContainer()
    {
        $container = new Container();
        $container->instance('request', Request::create('/', 'GET'));

        // Macroable stand-in for the response factory behind the Response facade
        $responseFactory = new class {
            use \Illuminate\Support\Traits\Macroable;
        };
        $container->instance(\Illuminate\Contracts\Routing\ResponseFactory::class, $responseFactory);

        \Illuminate\Support\Facades\Facade::setFacadeApplication($container);

        try {
            $provider = new ResponseServiceProvider($container);
            $provider->register();
            $provider->boot();

            $this->assertSame($container->make(ResponseContract::class), $responseFactory->api());
        } finally {
            \Illuminate\Support\Facades\Facade::clearResolvedInstances();
            \Illuminate\Support\Facades\Facade::setFacadeApplication(null);
        }
    }

    /**
     * Register the service provider on a fresh container holding a request built with the given query
     *
     * @param array $query
     * @return Container
     */
    private function registerProvider(array $query = []): Container
    {
        $container = new Container();
        $container->instance('request', Request::create('/', 'GET', $query));

        (new ResponseServiceProvider($container))->register();

        return $container;
    }
}

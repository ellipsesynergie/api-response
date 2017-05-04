<?php

namespace EllipseSynergie\ApiResponse\Testing\Laravel;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Class AddTestingSupportForInclude
 * @package EllipseSynergie\ApiResponse\Testing\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
trait AddTestingSupportForInclude
{
    /**
     * Call the given URI and return the Response.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array   $parameters
     * @param  array   $cookies
     * @param  array   $files
     * @param  array   $server
     * @param  string  $content
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

        $this->currentUri = $this->prepareUrlForRequest($uri);

        $this->resetPageContext();

        $symfonyRequest = SymfonyRequest::create(
            $this->currentUri, $method, $parameters,
            $cookies, $this->filterFiles($files), array_replace($this->serverVariables, $server), $content
        );

        $request = Request::createFromBase($symfonyRequest);

        $response = app(\EllipseSynergie\ApiResponse\Contracts\Response::class);

        $response
            ->getManager()
            ->parseIncludes(explode(',', $request->get('include')));

        $response = $kernel->handle($request);

        $kernel->terminate($request, $response);

        return $this->response = $response;
    }
}

<?php

namespace EllipseSynergie\ApiResponse\Laravel\Middleware;

use Closure;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;

/**
 * Class ParseInclude
 * @package EllipseSynergie\ApiResponse\Laravel\Middleware
 */
class ParseInclude 
{
    /**
     * @var Response
     */
    private $response;

    /**
     * ParseInclude constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Handle middleware
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Are we going to try and include embedded data?
        $this->response->getManager()->parseIncludes(explode(',', $request->get('include')));

        return $next($request);
    }
}

<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseFake extends \EllipseSynergie\ApiResponse\Laravel\Response
{
    /**
     * @param array $array
     * @param array $headers
     * @return ResponseFactory
     */
    public function withArray(array $array, array $headers = array())
    {
        return (new ResponseFactoryFake())->json($array);
    }
}

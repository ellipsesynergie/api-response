<?php

namespace EllipseSynergie\ApiResponse\Tests\ZF2;

use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseFake extends \EllipseSynergie\ApiResponse\ZF2\Response
{
    /**
     * @param array $array
     * @param array $headers
     * @return ResponseFactory
     */
    public function withArray(array $array, array $headers = array())
    {
        return (new \EllipseSynergie\ApiResponse\Tests\Laravel\ResponseFactoryFake())->json($array);
    }
}

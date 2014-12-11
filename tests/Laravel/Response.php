<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

class Response extends \EllipseSynergie\ApiResponse\Laravel\Response
{
    /**
     * @param array $array
     * @param array $headers
     * @return \Illuminate\Http\Response
     */
    public function withArray(array $array, array $headers = array())
    {
        return $array;
    }
}

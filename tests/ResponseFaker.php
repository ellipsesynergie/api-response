<?php

namespace EllipseSynergie\ApiResponse\Tests;

use EllipseSynergie\ApiResponse\AbstractResponse;

/**
 * Class ResponseFaker
 *
 * @package EllipseSynergie\ApiResponse\Tests
 */
class ResponseFaker extends AbstractResponse
{
    /**
     * @param array $array
     * @param array $headers
     */
    public function withArray(array $array, array $headers = array())
    {
        return [
            'data' => $array,
            'status' => $this->statusCode,
            'headers' => $headers
        ];
    }
} 
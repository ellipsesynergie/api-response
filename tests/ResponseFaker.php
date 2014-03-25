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
        $response = [
            'status' => $this->statusCode,
            'headers' => $headers
        ];

        return array_merge($response, $array);
    }
} 
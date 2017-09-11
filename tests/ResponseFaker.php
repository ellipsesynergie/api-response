<?php

namespace EllipseSynergie\ApiResponse\Tests;

use EllipseSynergie\ApiResponse\AbstractResponse;

/**
 * Class ResponseFaker
 *
 * @package EllipseSynergie\ApiResponse\Tests
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseFaker extends AbstractResponse
{
    /**
     * @param array $array
     * @param array $headers
     * @param int $json_options
     * @return array
     */
    public function withArray(array $array, array $headers = array(), $json_options = 0)
    {
        $response = [
            'status' => $this->statusCode,
            'headers' => $headers
        ];

        return array_merge($response, $array);
    }
}

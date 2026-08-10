<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

/**
 * Class ResponseFactoryFake
 *
 * Fake of \Illuminate\Contracts\Routing\ResponseFactory exposing only the json() method used by
 * the tests. It deliberately does not implement the contract, so new contract methods added by
 * future Laravel versions cannot break the test suite.
 *
 * @package EllipseSynergie\ApiResponse\Tests\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseFactoryFake
{
    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array $data
     * @param  int $status
     * @param  array $headers
     * @param  int $options
     * @return mixed
     */
    public function json($data = array(), $status = 200, array $headers = array(), $options = 0)
    {
        return $data;
    }
}

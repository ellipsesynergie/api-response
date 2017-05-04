<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class ResponseFake
 * @package EllipseSynergie\ApiResponse\Tests\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
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

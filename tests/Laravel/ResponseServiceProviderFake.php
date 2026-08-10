<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

use EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider;
use EllipseSynergie\ApiResponse\Tests\Serializer\OptionalKeySerializer;

/**
 * Class ResponseServiceProviderFake
 *
 * Service provider overriding the serializer, as documented on ResponseServiceProvider::getSerializer().
 *
 * @package EllipseSynergie\ApiResponse\Tests\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseServiceProviderFake extends ResponseServiceProvider
{
    /**
     * @return OptionalKeySerializer
     */
    protected function getSerializer()
    {
        return new OptionalKeySerializer();
    }
}

<?php

namespace EllipseSynergie\ApiResponse\Serializer;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class Serializer
 * @package EllipseSynergie\ApiResponse\Serializer
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class Serializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return [$resourceKey ? $resourceKey: 'data' => $data];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return [$resourceKey ? $resourceKey: 'data' => $data];
    }
}

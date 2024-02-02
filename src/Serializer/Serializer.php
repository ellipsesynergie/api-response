<?php

namespace EllipseSynergie\ApiResponse\Serializer;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class Serializer
 * @package EllipseSynergie\ApiResponse\Serializer
 * @author Maxime Beaudoin <maxime.beaudoin@optania.com>
 */
class Serializer extends ArraySerializer
{
    public const RESOURCE_KEY = 'data';

    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function collection(?string $resourceKey, array $data): array
    {
        if (empty($resourceKey)) {
            $resourceKey = static::RESOURCE_KEY;
        }
        return $resourceKey ? [$resourceKey => $data] : $data;
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function item(?string $resourceKey, array $data): array
    {
        if (empty($resourceKey)) {
            $resourceKey = static::RESOURCE_KEY;
        }
        return $resourceKey ? [$resourceKey => $data] : $data;
    }
}

<?php

namespace EllipseSynergie\ApiResponse\Tests;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class TransformerFaker
 *
 * @package EllipseSynergie\ApiResponse\Tests
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class TransformerFaker extends TransformerAbstract
{
    protected array $availableIncludes = ['author'];

    /**
     * @param array $data
     * @return array
     */
    public function transform(array $data): array
    {
        return $data;
    }

    /**
     * @param array $data
     * @return Item
     */
    public function includeAuthor(array $data): Item
    {
        return $this->item(['name' => 'Maxime'], function ($author) {
            return $author;
        });
    }
}

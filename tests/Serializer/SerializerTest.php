<?php

namespace EllipseSynergie\ApiResponse\Tests\Serializer;

use EllipseSynergie\ApiResponse\Serializer\Serializer;
use PHPUnit_Framework_TestCase;

/**
 * Class SerializerTest
 * @package EllipseSynergie\ApiResponse\Tests\Serializer
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class SerializerTest extends PHPUnit_Framework_TestCase
{
    public function testCollectionWithDefaultResourceKey()
    {
        $serializer = new Serializer();
        $result = $serializer->collection(null, ['foo']);

        $this->assertSame([
            'data' => ['foo']
        ], $result);
    }

    public function testCollectionWithCustomResourceKey()
    {
        $serializer = new Serializer();
        $result = $serializer->collection('custom', ['foo']);

        $this->assertSame([
            'custom' => ['foo']
        ], $result);
    }

    public function testItemWithDefaultResourceKey()
    {
        $serializer = new Serializer();
        $result = $serializer->item(null, ['foo']);

        $this->assertSame([
            'data' => ['foo']
        ], $result);
    }

    public function testITemWithCustomResourceKey()
    {
        $serializer = new Serializer();
        $result = $serializer->collection('custom', ['foo']);

        $this->assertSame([
            'custom' => ['foo']
        ], $result);
    }
}

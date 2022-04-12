<?php

namespace EllipseSynergie\ApiResponse\Tests\Serializer;

use EllipseSynergie\ApiResponse\Serializer\Serializer;
use PHPUnit\Framework\TestCase;

/**
 * Class SerializerTest
 * @package EllipseSynergie\ApiResponse\Tests\Serializer
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class SerializerTest extends TestCase
{
    public function testCollectionWithDefaultResourceKey()
    {
        $data = ['foo'];
        $serializer = new Serializer();
        $result = $serializer->collection('', $data);

        $this->assertSame(['data' => $data], $result);
    }

    public function testCollectionWithCustomResourceKey()
    {
        $data = ['foo'];
        $serializer = new Serializer();
        $result = $serializer->collection('custom', $data);

        $this->assertSame(['custom' => $data], $result);
    }

    public function testCollectionWithOptionalResourceKey()
    {
        $data = ['foo'];
        $serializer = new OptionalKeySerializer();
        $result = $serializer->collection('', $data);

        $this->assertSame($data, $result);

        $result = $serializer->collection('optional', $data);

        $this->assertSame(['optional' => $data], $result);
    }

    public function testItemWithDefaultResourceKey()
    {
        $data = ['foo'];
        $serializer = new Serializer();
        $result = $serializer->item('', $data);

        $this->assertSame(['data' => $data], $result);
    }

    public function testItemWithCustomResourceKey()
    {
        $data = ['foo'];
        $serializer = new Serializer();
        $result = $serializer->collection('custom', $data);

        $this->assertSame(['custom' => $data], $result);
    }

    public function testItemWithOptionalResourceKey()
    {
        $data = ['foo'];
        $serializer = new OptionalKeySerializer();
        $result = $serializer->item('', $data);

        $this->assertSame($data, $result);

        $result = $serializer->item('optional', $data);

        $this->assertSame(['optional' => $data], $result);
    }
}

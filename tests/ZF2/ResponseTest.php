<?php

namespace EllipseSynergie\ApiResponse\Tests\ZF2;

use League\Fractal\Manager;
use Zend\Http\Response as HttpResponse;
use Mockery as m;

/**
 * Class ResponseTest
 *
 * @package EllipseSynergie\ApiResponse\Tests\ZF2
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testErrorWrongArgsValidator()
    {
        $validator = m::mock('Zend\Validator\AbstractValidator');
        $validator->shouldReceive('getMessages')->once()->andReturn(array('input1' => 'wrong length'));
        $response = new ResponseFake(new Manager(), new HttpResponse());

        $result = $response->errorWrongArgsValidator($validator);
        $this->assertSame('wrong length', $result['error']['message']['input1']);
    }

    public function tearDown()
    {
        m::close();
    }
}

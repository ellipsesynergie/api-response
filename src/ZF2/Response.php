<?php

namespace EllipseSynergie\ApiResponse\ZF2;

use EllipseSynergie\ApiResponse\AbstractResponse;
use Zend\Http\Response as HttpResponse;
use League\Fractal\Manager;
use Zend\Validator\AbstractValidator as Validator;

/**
 * Class Response
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse\ZF2
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class Response extends AbstractResponse
{
    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @param Manager $manager
     * @param HttpResponse $manager
     */
    public function __construct(Manager $manager, HttpResponse $response)
    {
        $this->response = $response;
        parent::__construct($manager);
    }

    /**
     * @param array $array
     * @param array $headers
     * @return ResponseFactory
     */
    public function withArray(array $array, array $headers = array())
    {
        $response = $this->response;
        $response->setStatusCode($this->statusCode);
        $response->getHeaders()->addHeaders($headers);
        $response->setContent(\Zend\Json\Json::encode($array));
        return $response;
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message from validator
     *
     * @param Validator $validator
     * @return ResponseFactory
     */
    public function errorWrongArgsValidator(Validator $validator)
    {
        return $this->errorWrongArgs($validator->getMessages());
    }
}
<?php

namespace EllipseSynergie\ApiResponse;

use EllipseSynergie\ApiResponse\Contracts\Response;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;

/**
 * Class Response
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 * @author Phil Sturgeon <email@philsturgeon.co.uk>
 */
abstract class AbstractResponse implements Response
{

    const CODE_WRONG_ARGS = 'GEN-WRONG-ARGS';

    const CODE_NOT_FOUND = 'GEN-NOT-FOUND';

    const CODE_INTERNAL_ERROR = 'GEN-INTERNAL-ERROR';

    const CODE_UNAUTHORIZED = 'GEN-UNAUTHORIZED';

    const CODE_FORBIDDEN = 'GEN-FORBIDDEN';

    const CODE_GONE = 'GEN-GONE';

    const CODE_METHOD_NOT_ALLOWED = 'GEN-METHOD-NOT-ALLOWED';

    const CODE_UNWILLING_TO_PROCESS = 'GEN-UNWILLING-TO-PROCESS';

    /**
     * HTTP Status code
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Fractal manager
     *
     * @var \League\Fractal\Manager
     */
    protected $manager;

    /**
     * @param \League\Fractal\Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return \League\Fractal\Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for status code
     *
     * @param int $statusCode
     * @return \EllipseSynergie\ApiResponse\AbstractResponse
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Implement this !!!
     * This method return the final response output
     *
     * @param array $array
     * @param array $headers
     */
    abstract public function withArray(array $array, array $headers = []);

    /**
     * Response for one item
     *
     * @param $data
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @param array $meta
     * @param array $headers
     * @return mixed
     */
    public function withItem($data, $transformer, $resourceKey = null, $meta = [], array $headers = [])
    {
        $resource = new Item($data, $transformer, $resourceKey);

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray(), $headers);
    }

    /**
     * Response for collection of items
     *
     * @param $data
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @param Cursor $cursor
     * @param array $meta
     * @param array $headers
     * @return mixed
     */
    public function withCollection($data, $transformer, $resourceKey = null, Cursor $cursor = null, $meta = [], array $headers = [])
    {
        $resource = new Collection($data, $transformer, $resourceKey);

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        if (!is_null($cursor)) {
            $resource->setCursor($cursor);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray(), $headers);
    }

    /**
     * Response for errors
     *
     * @param string $message
     * @param string $errorCode
     * @param array  $headers
     * @return mixed
     */
    public function withError($message, $errorCode, array $headers = [])
    {
        return $this->withArray([
                'error' => [
                    'code' => $errorCode,
                    'http_code' => $this->statusCode,
                    'message' => $message
                ]
            ],
            $headers
        );
    }

    /**
     * Generates a response with a 403 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorForbidden($message = 'Forbidden', array $headers = [])
    {
        return $this->setStatusCode(403)->withError($message, static::CODE_FORBIDDEN, $headers);
    }

    /**
     * Generates a response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorInternalError($message = 'Internal Error', array $headers = [])
    {
        return $this->setStatusCode(500)->withError($message, static::CODE_INTERNAL_ERROR, $headers);
    }

    /**
     * Generates a response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorNotFound($message = 'Resource Not Found', array $headers = [])
    {
        return $this->setStatusCode(404)->withError($message, static::CODE_NOT_FOUND, $headers);
    }

    /**
     * Generates a response with a 401 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorUnauthorized($message = 'Unauthorized', array $headers = [])
    {
        return $this->setStatusCode(401)->withError($message, static::CODE_UNAUTHORIZED, $headers);
    }

    /**
     * Generates a response with a 400 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorWrongArgs($message = 'Wrong Arguments', array $headers = [])
    {
        return $this->setStatusCode(400)->withError($message, static::CODE_WRONG_ARGS, $headers);
    }

    /**
     * Generates a response with a 410 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorGone($message = 'Resource No Longer Available', array $headers = [])
    {
        return $this->setStatusCode(410)->withError($message, static::CODE_GONE, $headers);
    }

    /**
     * Generates a response with a 405 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed', array $headers = [])
    {
        return $this->setStatusCode(405)->withError($message, static::CODE_METHOD_NOT_ALLOWED, $headers);
    }

    /**
     * Generates a Response with a 431 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorUnwillingToProcess($message = 'Server is unwilling to process the request', array $headers = [])
    {
        return $this->setStatusCode(431)->withError($message, static::CODE_UNWILLING_TO_PROCESS, $headers);
    }
}
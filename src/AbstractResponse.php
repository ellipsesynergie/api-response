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
 * @author Maxime Beaudoin <maxime.beaudoin@optania.com>
 * @author Phil Sturgeon <email@philsturgeon.co.uk>
 */
abstract class AbstractResponse implements Response
{
    public const CODE_WRONG_ARGS = 'GEN-WRONG-ARGS';
    public const CODE_NOT_FOUND = 'GEN-NOT-FOUND';
    public const CODE_INTERNAL_ERROR = 'GEN-INTERNAL-ERROR';
    public const CODE_UNAUTHORIZED = 'GEN-UNAUTHORIZED';
    public const CODE_FORBIDDEN = 'GEN-FORBIDDEN';
    public const CODE_GONE = 'GEN-GONE';
    public const CODE_METHOD_NOT_ALLOWED = 'GEN-METHOD-NOT-ALLOWED';
    public const CODE_UNWILLING_TO_PROCESS = 'GEN-UNWILLING-TO-PROCESS';
    public const CODE_UNPROCESSABLE = 'GEN-UNPROCESSABLE';


    /**
     * HTTP Status code
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Fractal manager
     *
     * @var Manager
     */
    protected $manager;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        return $this->manager;
    }

    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Setter for status code
     *
     * @param int $statusCode
     * @return AbstractResponse
     */
    public function setStatusCode($statusCode): AbstractResponse
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
     * @param int $json_options  @link http://php.net/manual/en/function.json-encode.php
     * @return mixed
     */
    abstract public function withArray(array $array, array $headers = [], $json_options = 0);

    /**
     * Response for one item
     *
     * @param mixed $data
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
     * @param mixed $data
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @param Cursor $cursor
     * @param array $meta
     * @param array $headers
     * @return mixed
     */
    public function withCollection(
        $data,
        $transformer,
        $resourceKey = null,
        Cursor $cursor = null,
        $meta = [],
        array $headers = []
    ) {
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
        return $this->withArray(
            [
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

    /**
     * Generates a Response with a 422 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorUnprocessable($message = 'Unprocessable Entity', array $headers = [])
    {
        return $this->setStatusCode(422)->withError($message, static::CODE_UNPROCESSABLE, $headers);
    }
}

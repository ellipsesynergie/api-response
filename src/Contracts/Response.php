<?php

namespace EllipseSynergie\ApiResponse\Contracts;

use League\Fractal\Pagination\Cursor;

/**
 * Interface Response
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse\Contracts
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
interface Response
{
    /**
     * @return \League\Fractal\Manager
     */
    public function getManager();

    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * Setter for status code
     *
     * @param int $statusCode
     * @return \EllipseSynergie\ApiResponse\AbstractResponse
     */
    public function setStatusCode($statusCode);

    /**
     * Implement this !!!
     * This method return the final response output
     *
     * @param array $array
     * @param array $headers
     */
    public function withArray(array $array, array $headers = []);

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
    public function withItem($data, $transformer, $resourceKey = null, $meta = [], array $headers = []);

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
    public function withCollection($data, $transformer, $resourceKey = null, Cursor $cursor = null, $meta = [], array $headers = []);

    /**
     * Response for errors
     *
     * @param string $message
     * @param string $errorCode
     * @param array  $headers
     * @return mixed
     */
    public function withError($message, $errorCode, array $headers = []);

    /**
     * Generates a response with a 403 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorForbidden($message, array $headers = []);

    /**
     * Generates a response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorInternalError($message, array $headers = []);

    /**
     * Generates a response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorNotFound($message, array $headers = []);

    /**
     * Generates a response with a 401 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorUnauthorized($message, array $headers = []);

    /**
     * Generates a response with a 400 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorWrongArgs($message, array $headers = []);

    /**
     * Generates a response with a 410 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorGone($message, array $headers = []);

    /**
     * Generates a response with a 405 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorMethodNotAllowed($message, array $headers = []);

    /**
     * Generates a Response with a 431 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorUnwillingToProcess($message, array $headers = []);
}


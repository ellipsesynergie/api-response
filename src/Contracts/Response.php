<?php

namespace EllipseSynergie\ApiResponse\Contracts;

use EllipseSynergie\ApiResponse\AbstractResponse;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;
use League\Fractal\TransformerAbstract;

/**
 * Interface Response
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse\Contracts
 * @author Maxime Beaudoin <maxime.beaudoin@optania.com>
 */
interface Response
{
    /**
     * @return Manager
     */
    public function getManager(): Manager;

    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Setter for status code
     *
     * @param int $statusCode
     * @return AbstractResponse
     */
    public function setStatusCode(int $statusCode): AbstractResponse;

    /**
     * Implement this !!!
     * This method return the final response output
     *
     * @param array $array
     * @param array $headers
     * @param int $json_options @link http://php.net/manual/en/function.json-encode.php
     * @return mixed
     */
    public function withArray(array $array, array $headers = [], int $json_options = 0);

    /**
     * Response for one item
     *
     * @param mixed $data
     * @param callable|TransformerAbstract $transformer
     * @param string|null $resourceKey
     * @param array $meta
     * @param array $headers
     * @return mixed
     */
    public function withItem($data, $transformer, string $resourceKey = null, array $meta = [], array $headers = []);

    /**
     * Response for collection of items
     *
     * @param mixed $data
     * @param callable|TransformerAbstract $transformer
     * @param string|null $resourceKey
     * @param Cursor|null $cursor
     * @param array $meta
     * @param array $headers
     * @return mixed
     */
    public function withCollection(
        $data,
        $transformer,
        string $resourceKey = null,
        Cursor $cursor = null,
        array $meta = [],
        array $headers = []
    );

    /**
     * Response for errors
     *
     * @param string $message
     * @param string $errorCode
     * @param array  $headers
     * @return mixed
     */
    public function withError(string $message, string $errorCode, array $headers = []);

    /**
     * Generates a response with a 403 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorForbidden(string $message, array $headers = []);

    /**
     * Generates a response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorInternalError(string $message, array $headers = []);

    /**
     * Generates a response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorNotFound(string $message, array $headers = []);

    /**
     * Generates a response with a 401 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorUnauthorized(string $message, array $headers = []);

    /**
     * Generates a response with a 400 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorWrongArgs(string $message, array $headers = []);

    /**
     * Generates a response with a 410 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorGone(string $message, array $headers = []);

    /**
     * Generates a response with a 405 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorMethodNotAllowed(string $message, array $headers = []);

    /**
     * Generates a Response with a 431 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorUnwillingToProcess(string $message, array $headers = []);
}

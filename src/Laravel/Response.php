<?php

namespace EllipseSynergie\ApiResponse\Laravel;

use EllipseSynergie\ApiResponse\AbstractResponse;
use Illuminate\Support\Facades\Response as IlluminateResponse;
use Illuminate\Validation\Validator;

/**
 * Class Response
 *
 * @package EllipseSynergie\ApiResponse\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class Response extends AbstractResponse
{
    /**
     * @param array $array
     * @param array $headers
     */
    public function withArray(array $array, array $headers = array())
    {
        return IlluminateResponse::json($array, $this->statusCode, $headers);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message from validator
     *
     * @param $validator
     * @return \Illuminate\Http\Response
     */
    public function errorWrongArgsValidator(Validator $validator)
    {
        return $this->errorWrongArgs($validator->messages()->toArray());
    }
} 
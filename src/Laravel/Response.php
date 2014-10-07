<?php

namespace EllipseSynergie\ApiResponse\Laravel;

use EllipseSynergie\ApiResponse\AbstractResponse;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Support\Facades\Response as IlluminateResponse;
use Illuminate\Validation\Validator;
use Illuminate\Pagination\Paginator;
use League\Fractal\Resource\Collection;

/**
 * Class Response
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class Response extends AbstractResponse
{
    /**
     * @param array $array
     * @param array $headers
     * @return \Illuminate\Http\Response
     */
    public function withArray(array $array, array $headers = array())
    {
        return IlluminateResponse::json($array, $this->statusCode, $headers);
    }

    /**
     * Respond with a paginator, and a transformer.
     *
     * @param Paginator $paginator
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @param array $meta
     * @return \Illuminate\Http\Response
     */
    public function withPaginator(Paginator $paginator, $transformer, $resourceKey = null, $meta = [])
    {
        $resource = new Collection($paginator->getCollection(), $transformer, $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray());
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

<?php

namespace EllipseSynergie\ApiResponse\Laravel;

use EllipseSynergie\ApiResponse\Serializer\Serializer;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;

/**
 * Class ResponseServiceProvider
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $response = $this->bootResponse();
        $this->registerMacro($response);
    }

    /**
     * Override this to use your own serializer.
     *
     * @return Serializer
     */
    protected function getSerializer()
    {
        return new Serializer();
    }

    /**
     * Boot response
     *
     * @return Response
     */
    protected function bootResponse()
    {
        $manager = new Manager;

        // Custom serializer because DataArraySerializer doesn't provide the opportunity to change the resource key
        $manager->setSerializer($this->getSerializer());

        //Get includes from request
        $includes = $this->app['Illuminate\Http\Request']->get('include');

        //If includes is not already a array
        if(!is_array($includes)){
            $includes = explode(',', $includes);
        }

        // Are we going to try and include embedded data?
        $manager->parseIncludes($includes);

        // Return the Response object
        $response = new Response($manager);

        //Set the response instance properly
        $this->app->instance('EllipseSynergie\ApiResponse\Contracts\Response', $response);

        return $response;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register response macro
     *
     * @deprecated We still register macro for backward compatibility, but DO NOT USE THIS MACRO ANYMORE !
     * @param Response $response
     */
    private function registerMacro($response)
    {
        \Response::macro('api', function () use ($response) {
            return $response;
        });
    }
}

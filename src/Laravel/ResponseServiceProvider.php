<?php

namespace EllipseSynergie\ApiResponse\Laravel;

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
     * Boot response
     *
     * @return Response
     */
    private function bootResponse()
    {
        $manager = new Manager;

        // If you have to customize the manager instance, like setting a custom serializer,
        // I strongly suggest you to create your own service provider and add you manager configuration action here
        // Here some example if you want to set a custom serializer :
        // $manager->setSerializer(\League\Fractal\Serializer\JsonApiSerializer);

        // Are we going to try and include embedded data?
        $manager->parseIncludes(explode(',', $this->app['Illuminate\Http\Request']->get('include')));

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
        \Response::macro('api', function() use ($response){
            return $response;
        });
    }
}

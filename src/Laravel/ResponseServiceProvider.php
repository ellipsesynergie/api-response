<?php

namespace EllipseSynergie\ApiResponse\Laravel;

use EllipseSynergie\ApiResponse\Contracts\Response as ResponseContract;
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
 * @author Maxime Beaudoin <maxime.beaudoin@optania.com>
 */
class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMacro();
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
     * Register the service provider.
     *
     * The response is bound as a scoped singleton and built lazily, on first resolution. By that
     * time the current request is bound in the container, so the include query parameter is
     * available. Parsing it at boot time instead would break in-process feature testing (the
     * application boots before the test request exists) and would leak the first request includes
     * across requests under Laravel Octane.
     *
     * @return void
     */
    public function register()
    {
        $this->app->scoped(ResponseContract::class, function ($app) {
            $manager = new Manager();

            // Custom serializer because DataArraySerializer doesn't provide the opportunity to change the resource key
            $manager->setSerializer($this->getSerializer());

            //Get includes from request
            $includes = $app['request']->get('include', '');

            //If includes is not already a array
            if (!is_array($includes)) {
                $includes = explode(',', (string) $includes);
            }

            // Are we going to try and include embedded data?
            $manager->parseIncludes(array_filter($includes));

            return new Response($manager);
        });
    }

    /**
     * Register response macro
     *
     * @deprecated We still register macro for backward compatibility, but DO NOT USE THIS MACRO ANYMORE !
     */
    private function registerMacro()
    {
        $app = $this->app;

        \Illuminate\Support\Facades\Response::macro('api', function () use ($app) {
            return $app->make(ResponseContract::class);
        });
    }
}

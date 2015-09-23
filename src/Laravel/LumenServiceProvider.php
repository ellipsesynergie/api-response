<?php

namespace EllipseSynergie\ApiResponse\Laravel;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;

/**
 * Class LumenServiceProvider
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class LumenServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $manager = new Manager;

        // If you have to customize the manager instance, like setting a custom serializer,
        // I strongly suggest you to create your own service provider and add you manager configuration action here
        // Here some example if you want to set a custom serializer :
        // $manager->setSerializer(\League\Fractal\Serializer\JsonApiSerializer);

        // Are we going to try and include embedded data?
        $manager->parseIncludes(explode(',', $this->app['Illuminate\Http\Request']->get('include')));

        //Set the response instance properly
        $this->app->instance('EllipseSynergie\ApiResponse\Contracts\Response', new Response($manager));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

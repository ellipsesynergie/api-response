<?php
namespace EllipseSynergie\ApiResponse\ZF2;

use League\Fractal\Manager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ResponseServiceProvider
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package EllipseSynergie\ApiResponse\ZF2
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseFactory implements FactoryInterface
{
    /**
     * Return an instance of the API response service
     *
     * @param  $serviceLocator ServiceLocatorInterface
     * @return EllipseSynergie\ApiResponse\ZF2\Response
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        
        $mvcEvent = $serviceLocator->get('application')->getMvcEvent();
        $response = $mvcEvent->getResponse();
        // Instantiate the fractal manager
        $manager = new Manager;
        // Set the request scope if you need embed data
        $manager->parseIncludes(explode(',', @$_GET['include']));
        // Instantiate the response object, replace the class name by your custom class
        return new \EllipseSynergie\ApiResponse\ZF2\Response($manager, $response);
    }
}
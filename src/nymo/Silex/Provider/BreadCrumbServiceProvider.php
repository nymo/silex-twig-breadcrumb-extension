<?php
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) 2014 Gregor Panek
 */
namespace nymo\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use nymo\Resources\Library\BreadCrumbCollection;

/**
 * Class BreadCrumbServiceProvider
 * @package nymo\Silex\Provider
 * @author Gregor Panek <gp@gregorpanek.de>
 */
class BreadCrumbServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['breadCrumbs'] = BreadCrumbCollection::getInstance();
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {

    }

}

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: g_panek
 * Date: 07.01.13
 * Time: 16:38
 */

namespace nymo\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use nymo\Resources\Library\BreadCrumbCollection;

class BreadCrumbServiceProvider implements ServiceProviderInterface{
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

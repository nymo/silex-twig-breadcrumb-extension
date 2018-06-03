<?php declare(strict_types=1);
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) Gregor Panek <gp@gregorpanek.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace nymo\Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
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
     * @param Container $container A Container instance
     */
    public function register(Container $container): void
    {
        $container['breadcrumbs'] = new BreadCrumbCollection();
    }
}

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

use PHPUnit\Framework\TestCase;
use nymo\Resources\Library\BreadCrumbCollection;
use Pimple\Container;

/**
 * Testcases for the BreadCrumbServiceProvider class
 * @author Gregor Panek <gp@gregorpanek.de>
 */
class BreadCrumbServiceProviderTest extends TestCase
{

    public function testRegister(): void
    {
        $container = new Container();
        $serviceProvider = new BreadCrumbServiceProvider();
        $serviceProvider->register($container);

        $this->assertInstanceOf(BreadCrumbCollection::class, $container['breadcrumbs']);
    }
}

<?php
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) Gregor Panek <gp@gregorpanek.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace nymo\Twig\Extension;

use PHPUnit\Framework\TestCase;
use nymo\Resources\Library\BreadCrumbCollection;
use Pimple\Container;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;

/**
 * Testcases for the BreadCrumbExtension class
 * @author Gregor Panek <gp@gregorpanek.de>
 */
class BreadCrumbExtensionTest extends TestCase
{

    /**
     * BreadCrumbExtension
     * @var BreadCrumbExtension
     */
    protected $extension;

    /**
     * A pimple Container
     * @var Container
     */
    protected $app;

    public function setUp()
    {
        $viewPath = __DIR__.'/../../../../../../src/nymo/Views';
        $this->app = new Container();
        $this->app['charset'] = 'utf-8';
        $this->app['debug'] = false;
        //change default separator
        $this->app['breadcrumbs.separator'] = '...:::...';
        $this->app->register(new LocaleServiceProvider());
        $this->app->register(new TranslationServiceProvider(), array(
            'locale_fallbacks' => array('en'),
        ));
        $this->app->register(new TwigServiceProvider(), array('twig.path' => $viewPath));

        $this->app['twig.loader'] = new \Twig_Loader_Chain();
        $this->extension = new BreadCrumbExtension($this->app);
    }

    public function testGetFunctions()
    {
        $functions = $this->extension->getFunctions();
        $this->assertInstanceOf(\Twig_SimpleFunction::class, $functions['renderBreadCrumbs']);
    }

    public function testRenderBreadCrumbs()
    {
        $breadCrumbs = $this->createBreadCrumbs();
        preg_match_all('/...:::.../', $breadCrumbs, $counted);
        $this->assertCount(4, current($counted));
        $this->assertRegExp('/<a href="www.amazon.de">Amazon<\/a>/', $breadCrumbs);
    }

    public function testGetName()
    {
        $this->assertEquals('renderBreadCrumbs', $this->extension->getName());
    }

    /**
     * Creates Breadcrumbs, renders them and saves the rendered file to a string
     * @return string
     */
    protected function createBreadCrumbs()
    {
        $breadCrumbs = BreadCrumbCollection::getInstance();
        $breadCrumbs->addItem('Amazon', 'www.amazon.de');
        $breadCrumbs->addItem('Something', 'www.isThere.com');
        $this->app['breadcrumbs'] = $breadCrumbs;

        return $this->extension->renderBreadCrumbs();
    }
}

<?php declare(strict_types=1);
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
use Silex\Application;
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

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $viewPath = __DIR__ . '/../../../../../../src/nymo/Views';
        $this->app = $this->getMockBuilder(Application::class)
                    ->setMethods(null)
                    ->getMock();
        $this->app['charset'] = 'utf-8';
        $this->app['debug'] = false;
        //change default separator
        $this->app['breadcrumbs.separator'] = '...:::...';
        $this->app->register(new LocaleServiceProvider());
        $this->app->register(new TwigServiceProvider(), array('twig.path' => $viewPath));

        $this->app['twig.loader'] = new \Twig_Loader_Chain();
        $this->extension = new BreadCrumbExtension($this->app);
    }

    public function testGetFunctions(): void
    {
        $functions = $this->extension->getFunctions();
        $this->assertInstanceOf(\Twig_SimpleFunction::class, $functions['renderBreadCrumbs']);
    }

    /**
     * Test should render valid breadcrumbs with activated translation service
     * and translate the link name
     */
    public function testRenderBreadCrumbsWithTranslation(): void
    {
        $this->activateTransServiceProvider();

        $this->app['translator.domains'] = array(
            'messages' => array(
                'en' => array(
                    'Amazon'     => 'Ebay',
                ),
            ),
        );

        $breadCrumbs = $this->createBreadCrumbs();
        preg_match_all('/...:::.../', $breadCrumbs, $counted);

        $this->assertCount(1, current($counted));
        $this->assertRegExp('/<a href="www.amazon.de">Ebay<\/a>/', $breadCrumbs);
    }

    /**
     * Test should pass although the translation service is not activated.
     * This tests if the translation service is optional
     */
    public function testRenderWithoutTranslation(): void
    {
        $breadCrumbs = $this->createBreadCrumbs();
        $this->assertRegExp('/<a href="www.amazon.de">Amazon<\/a>/', $breadCrumbs);
    }

    public function testGetName(): void
    {
        $this->assertEquals('renderBreadCrumbs', $this->extension->getName());
    }

    /**
     * Creates Breadcrumbs, renders them and saves the rendered file to a string
     * @return string
     */
    protected function createBreadCrumbs(): string
    {
        $breadCrumbs = new BreadCrumbCollection();
        $breadCrumbs->addItem('Amazon', 'www.amazon.de');
        $breadCrumbs->addItem('Something', 'www.isThere.com');
        $this->app['breadcrumbs'] = $breadCrumbs;

        return $this->extension->renderBreadCrumbs();
    }

    /**
     * Activates the translation service provider
     * @return void
     */
    protected function activateTransServiceProvider(): void
    {
        $this->app->register(new TranslationServiceProvider(), array(
            'locale_fallbacks' => array('en')));
    }
}

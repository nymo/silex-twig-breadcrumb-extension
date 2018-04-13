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

use Pimple\Container;

/**
 * Class BreadCrumbExtension
 * @package nymo\Twig\Extension
 * @author Gregor Panek <gp@gregorpanek.de>
 */
class BreadCrumbExtension extends \Twig_Extension
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var string
     */
    protected $separator = '>';

    /**
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        //set options
        if (isset($app['breadcrumbs.separator'])) {
            $this->separator = $app['breadcrumbs.separator'];
        }
        //create loader to load base template which can be overridden by user
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../Resources/Views');
        $this->app['twig.loader']->addLoader($loader);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            'renderBreadCrumbs' => new \Twig_SimpleFunction(
                'renderBreadCrumbs',
                [$this, 'renderBreadCrumbs'],
                ['is_safe' => ['html']]
            )
        ];
    }

    /**
     * Returns the rendered breadcrumb template
     * @return string
     */
    public function renderBreadCrumbs()
    {
        $translator = isset($this->app['translator']) ? true : false;

        return $this->app['twig']->render(
            'breadcrumbs.html.twig',
            [
                'breadcrumbs' => $this->app['breadcrumbs']->getItems(),
                'separator' => $this->separator,
                'translator' => $translator
            ]
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'renderBreadCrumbs';
    }
}

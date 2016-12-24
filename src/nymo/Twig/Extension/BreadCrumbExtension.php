<?php
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) 2014 Gregor Panek
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
        //add loader
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

        return $this->app['twig']->render(
            'breadcrumbs.html.twig',
            [
                'breadcrumbs' => $this->app['breadcrumbs']->getItems(),
                'separator' => $this->separator
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

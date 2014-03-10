<?php
/**
 * Created by JetBrains PhpStorm.
 * User: g_panek
 * Date: 19.11.12
 * Time: 16:41
 */
namespace nymo\Twig\Extension;
use Silex\Application;
class BreadCrumbExtension extends \Twig_Extension
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $separator = '>';

    /**
     * @param \Silex\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        //set options
        if(isset($app['breadcrumbs.separator'])){
           $this->separator = $app['breadcrumbs.separator'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'renderBreadCrumbs' => new \Twig_Function_Method($this, 'renderBreadCrumbs',array('is_safe'=>array('html')))
        );
    }

    public function renderBreadCrumbs()
    {

        return $this->app['twig']->render('/../../Resources/Views/breadcrumbs.html.twig', array(
            'breadcrumbs' => $this->app['breadcrumbs']->getItems(),
                'separator' => $this->separator
            ));

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

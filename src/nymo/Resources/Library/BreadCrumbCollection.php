<?php
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) Gregor Panek <gp@gregorpanek.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace nymo\Resources\Library;

/**
 * Class BreadCrumbCollection
 * @package nymo\Resources\Library
 * @author Gregor Panek <gp@gregorpanek.de>
 */
class BreadCrumbCollection
{

    /**
     * @var null|BreadCrumbCollection
     */
    protected static $bcCollection = null;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface $generator
     */
    protected $urlGen;

    /**
     * Singelton
     */
    protected function __construct()
    {
    }

    /**
     * Singelton
     */
    protected function __clone()
    {
    }

    /**
     * Create a Singelton collection class
     * @return BreadCrumbCollection
     */
    public static function getInstance()
    {
        if (self::$bcCollection === null) {
            self::$bcCollection = new self();
        }

        return self::$bcCollection;
    }

    /**
     * Add new breadcrumb item
     * @param string $linkName
     * @param string|array|null $target
     * @return void
     */
    public function addItem($linkName, $target = null)
    {
        if (is_array($target)) {
            $target = isset($target['params']) ? $this->urlGen->generate(
                $target['route'],
                $target['params']
            ) : $this->urlGen->generate($target['route']);
        }
        $this->items[] = ["linkName" => $linkName, "target" => $target];
    }

    /**
     * Return all BreadCrumbs
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $generator
     * @return void
     */
    public function setUrlGenerator(\Symfony\Component\Routing\Generator\UrlGeneratorInterface $generator)
    {
        $this->urlGen = $generator;
    }
}

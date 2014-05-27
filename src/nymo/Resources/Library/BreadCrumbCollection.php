<?php
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) 2014 Gregor Panek
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
    protected $items = array();

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
     * @param string|null $target
     * @return void
     */
    public function addItem($linkName, $target=null)
    {
        $this->items[] = array("linkName" => $linkName, "target" => $target);
    }

    /**
     * Return all BreadCrumbs
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}

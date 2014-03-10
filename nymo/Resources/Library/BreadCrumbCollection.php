<?php
/**
 * Created by JetBrains PhpStorm.
 * User: g_panek
 * Date: 07.01.13
 * Time: 16:45
 */
namespace nymo\Resources\Library;

class BreadCrumbCollection {

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
    protected  function __construct(){}

    /**
     * Singelton
     */
    protected function __clone(){}

    /**
     * Create a Singelton collection class
     * @return BreadCrumbCollection
     */
    public static function getInstance(){
        if(self::$bcCollection === null){
            self::$bcCollection = new self();
        }
        return self::$bcCollection;
    }

    /**
     * Add new BreadCrumb item
     * @param string $linkName
     * @param string $target
     * @return void
     */
    public function addItem($linkName,$target){
       $this->items[] = array("linkName"=>$linkName,"target"=>$target);
    }

    /**
     * Return all BreadCrumbs
     * @return array
     */
    public function getItems(){
        return $this->items;
    }



}

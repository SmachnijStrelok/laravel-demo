<?php

namespace App\Services;

abstract class AbstractService
{

    protected static $instances;

    /**
     * @return $this
     */
    public static function getInstance()
    {
        $class = get_called_class();
        if(!isset(static::$instances[$class])) {
            $instance = new $class;
            static::$instances[$class] = $instance;
        }
        return static::$instances[$class];
    }

    protected function __construct() {
        $this->init();
    }

    public function init() {}

    final private function __clone() { }

}
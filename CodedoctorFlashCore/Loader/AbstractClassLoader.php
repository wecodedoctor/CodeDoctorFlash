<?php


namespace CodedoctorWordpressFlashCore\Loader;

use CodedoctorWordpressFlashCore\Loader\contracts\GlobalVariables;

abstract class AbstractClassLoader
{
    use GlobalVariables;

    /**
     * ClassLoader constructor.
     * Bootstrap the class
     */
    public function __construct() {
        $this->boot();
        $this->registarer();
    }

    abstract public function boot();

    abstract public static function init();

    /**
     * @return mixed
     */
    protected function registarer() {

    }
}
<?php


namespace CodedoctorWordpressFlashCore;

use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;
use CodedoctorWordpressFlashCore\RegisterWidget\AutoLoader as AutoloadWidgets;
use CodedoctorWordpressFlashCore\RegisterPostType\AutoLoader as AutoloadPosttypes;
use CodedoctorWordpressFlashCore\LoadExtenders\Autoload as AutoloadExtender;

class Autoload extends AbstractClassLoader
{
    use ClassInitializer;

    public function boot()
    {
        AutoloadWidgets::init();
        AutoloadPosttypes::init();
	    AutoloadExtender::init();
    }
}
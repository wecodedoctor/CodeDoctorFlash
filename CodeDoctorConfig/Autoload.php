<?php


namespace CodedoctorFlashConfig;


use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class Autoload extends AbstractClassLoader
{
    use ClassInitializer;

    public function boot()
    {
        Assets::init();
        Plugins::init();
    }
}
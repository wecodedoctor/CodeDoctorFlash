<?php


namespace CodedoctorFlash;


use CodedoctorWordpressFlashCore\Autoload as CoreAutoLoad;
use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;
use CodedoctorWordpressFlashSection\Autoload as SectionAutoLoad;
use CodedoctorFlashConfig\Autoload as ConfigAutoload;

class LoadFlashTheme extends AbstractClassLoader
{
    use ClassInitializer;

    public function boot()
    {
        LoadCarbonFieldsPlugin::init();
        CoreAutoLoad::init();
        SectionAutoLoad::init();
        ConfigAutoload::init();

    }
}
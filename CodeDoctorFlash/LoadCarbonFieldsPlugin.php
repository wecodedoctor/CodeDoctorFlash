<?php


namespace CodedoctorFlash;


use Carbon_Fields\Carbon_Fields;
use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class LoadCarbonFieldsPlugin extends AbstractClassLoader
{
    use ClassInitializer;

    public function boot()
    {
        add_action('after_setup_theme', [$this, 'loadPlugin']);
    }

    public function loadPlugin() {
        Carbon_Fields::boot();
    }
}
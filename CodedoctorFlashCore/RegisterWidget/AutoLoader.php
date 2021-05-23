<?php


namespace CodedoctorWordpressFlashCore\RegisterWidget;

use CodedoctorWordpressFlashCore\Loader\AbstractAutoDirectoryFileLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class AutoLoader extends AbstractAutoDirectoryFileLoader
{
    use ClassInitializer;

    protected $path = 'Theme/Widgets';
}
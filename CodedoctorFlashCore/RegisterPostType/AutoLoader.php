<?php


namespace CodedoctorWordpressFlashCore\RegisterPostType;

use CodedoctorWordpressFlashCore\Loader\AbstractAutoDirectoryFileLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class AutoLoader extends AbstractAutoDirectoryFileLoader
{
    use ClassInitializer;

    protected $path = 'Posttypes';

}
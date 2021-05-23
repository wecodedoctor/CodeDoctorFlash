<?php


namespace CodedoctorWordpressFlashCore\LoadExtenders;


use CodedoctorWordpressFlashCore\Loader\AbstractAutoDirectoryFileLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class Autoload extends AbstractAutoDirectoryFileLoader {
	use ClassInitializer;

	protected $path = 'App';
}
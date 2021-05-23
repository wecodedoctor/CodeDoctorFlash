<?php


namespace CodedoctorWordpressFlashCore\Loader\contracts;


trait AutoDirectoryClassLoader
{
    public function boot()
    {
        $full_path = $this->_autogenerate_path();
        if($this->path && is_dir($full_path)) {
            $loaded_classes = [];
            $scanned_directory = array_diff(scandir($full_path), array('..', '.'));
            foreach ($scanned_directory as $files) {
            	if(preg_match('/\.php$/', $files)) {
		            $fileName = preg_replace('/\.php$/', '', $files);
		            $className = $this->_getClassWithNamespace($fileName);
		            $loaded_classes[] = $className::init();
	            }
            }

            $this->after_class_loaded( $loaded_classes );
        }
    }
}
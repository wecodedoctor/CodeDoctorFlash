<?php


namespace CodedoctorWordpressFlashCore\Loader;

use CodedoctorWordpressFlashCore\Loader\contracts\AutoDirectoryClassLoader;

/**
 * Class AbstractAutoDirectoryFileLoader
 * @package CodedoctorWordpressFlashCore\Loader
 */
abstract class AbstractAutoDirectoryFileLoader extends AbstractClassLoader
{
    use AutoDirectoryClassLoader;

    protected $path = '';

    /**
     * Get full path
     * @return string
     */
    protected function _autogenerate_path()
    {
        return self::theme_dir() . '/Theme/' . $this->getPath() ;
    }

    private function _getClassWithNamespace(string $className) {
        return '\\CodedoctorWordpressTheme\\' . preg_replace('[/]', '\\', $this->getPath()) . '\\' . $className;
    }

    /**
     * After class loaded
     * @param array $classes
     */
    protected function after_class_loaded(array $classes = []) {

    }

    /**
     * Get path
     * @return string|null
     */
    protected function getPath():?string {
        if(method_exists($this, 'definePath')) {
            return call_user_func_array(array($this, 'definePath'), array());
        }
        elseif(!empty($this->path)) {
            return $this->path;
        }
        return null;
    }
}
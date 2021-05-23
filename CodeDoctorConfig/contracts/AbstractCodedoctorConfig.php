<?php


namespace CodedoctorFlashConfig\contracts;


use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use function Symfony\Component\String\u;

abstract class AbstractCodedoctorConfig extends AbstractClassLoader
{
    protected $path = '';
    protected $variables = [];
    public function boot()
    {
        $this->path = $this->_autoSetpath();
        $this->variables = $this->_autoSetVariables();
        $this->registarer();
    }

    /**
     * Autoset path
     * @return string
     */
    protected function _autoSetpath() {
        $base_path = get_template_directory() . '/ThemeConfig/';
        if(empty($this->path)) {
            $class_name = get_called_class();
            return $base_path . DIRECTORY_SEPARATOR . u($class_name)->snake() . '.php';
        }
        return $base_path . DIRECTORY_SEPARATOR . $this->path . '.php';
    }

    /**
     * Auto set vaiables
     * @return array|mixed
     */
    protected function _autoSetVariables() {
        if(!empty($this->path) && file_exists($this->path)) {
            return include $this->path;
        }
        return [];
    }

    /**
     * Get variables
     * @return array
     */
    public function getVariables() {
        return $this->variables;
    }
}
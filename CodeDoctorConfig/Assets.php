<?php


namespace CodedoctorFlashConfig;


use CodedoctorFlashConfig\contracts\AbstractCodedoctorConfig;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class Assets extends AbstractCodedoctorConfig
{
    use ClassInitializer;

    protected $path = 'assets';

    public function registarer()
    {
        add_action('wp_enqueue_scripts', [$this, 'frontendLoadStyles']);
        add_action('wp_enqueue_scripts', [$this, 'frontendLoadScripts']);
        add_action('admin_enqueue_scripts', [$this, 'adminLoadStyles']);
        add_action('admin_enqueue_scripts', [$this, 'adminLoadScripts']);
    }

    /**
     * Load front-end styles
     * @return void
     */
    public function frontendLoadStyles() {
        $configs = $this->getVariables();
        if(array_key_exists('frontend_styles', $configs)) {
            $this->commonLoadStyles( $configs['frontend_styles'] );
        }
    }

    /**
     * Load front-end scripts
     * @return void
     */
    public function frontendLoadScripts() {
        $configs = $this->getVariables();
        if(array_key_exists('frontend_js', $configs)) {
            $this->commonLoadScripts( $configs['frontend_js'] );
        }
    }

    /**
     * Load admin styles
     * @return void
     */
    public function adminLoadStyles() {
        $configs = $this->getVariables();
        if(array_key_exists('admin_styles', $configs)) {
            $this->commonLoadStyles( $configs['admin_styles'] );
        }
    }

    /**
     * Load admin scripts
     * @return void
     */
    public function adminLoadScripts() {
        $configs = $this->getVariables();
        if(array_key_exists('admin_js', $configs)) {
            $this->commonLoadScripts( $configs['admin_js'] );
        }
    }

    /**
     * Common style loader
     * @param array $config
     */
    protected function commonLoadStyles(array $config = []) {
        if(is_array($config) && !empty($config)) {
            foreach ($config as $handle => $setting) {
                if(is_array($setting)) {
                    $setting = $this->_formattingConfigItem($setting);
                }
                $setting = array_merge([
                    'src' => '',
                    'deps' => array(),
                    'ver' => false,
                    'media' => 'all'
                ], $setting);
                wp_enqueue_style($handle, $setting['src'], $setting['deps'], $setting['ver'], $setting['media']);
            }
        }
    }

    /**
     * Common script loader
     * @param array $config
     */
    protected function commonLoadScripts(array $config = []) {
        if(is_array($config) && !empty($config)) {
            foreach ($config as $handle => $setting) {
                $localize_script = array_key_exists('localize_script', $setting) && !empty($setting['localize_script']) ? $setting['localize_script'] : null;
                if(is_array($setting)) {
                    $setting = $this->_formattingConfigItem($setting);
                }
                $setting = array_merge([
                    'src' => '',
                    'deps' => array(),
                    'ver' => false,
                    'in_footer' => false
                ], $setting);
                wp_enqueue_script($handle, $setting['src'], $setting['deps'], $setting['ver'], $setting['in_footer']);
                if(!empty($localize_script)) {
                    wp_localize_script($handle, $localize_script['object_name'], $localize_script['values']);
                }
            }
        }
    }

    /**
     * Format the config item
     * @param array $config
     * @return array
     */
    protected function _formattingConfigItem(array $config = []) {
        if(!empty($config)) {
            foreach ($config as $item_key => $item_value) {
                switch ($item_key) {
                    case 'src':
                        $item_value = trim($item_value);
                        if(preg_match('/^(http(s)?:)?\/\//', $item_value)) {
                            $config[$item_key] = $item_value;
                        } else {
                            $config[$item_key] = get_template_directory_uri() . '/public/' . $item_value;
                        }
                        break;
                    default:
                        break;
                }
                return $config;
            }
        }
        return [];
    }
}
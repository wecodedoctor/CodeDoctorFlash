<?php


namespace CodedoctorFlashConfig;


use CodedoctorFlashConfig\contracts\AbstractCodedoctorConfig;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class Plugins extends AbstractCodedoctorConfig
{
    use ClassInitializer;

    protected $path = 'plugins';

    public function registarer()
    {
        add_action( 'tgmpa_register', [$this, 'register_plugin_requireds'] );
    }

    public function register_plugin_requireds() {
        $plugins_in_config = $this->getVariables();
        $plugins = [];
        if(!empty($plugins_in_config)) {
            foreach ($plugins_in_config as $slug => $plugin) {
                $plugin = array_merge([
                    'name' => '',
                    'zip_name' => '',
                    'required' => false,
                    'version' => '',
                    'force_activation' => false,
                    'force_deactivation' => false,
                    'external_url' => '',
                    'is_callable' => ''
                ], $plugin);
                $plugins[] = [
                    'name'               => $plugin['name'], // The plugin name.
                    'slug'               => $slug, // The plugin slug (typically the folder name).
                    'source'             => get_template_directory() . '/ThemeResource/plugins/' . $plugin['zip_name'], // The plugin source.
                    'required'           => $plugin['required'], // If false, the plugin is only 'recommended' instead of required.
                    'version'            => $plugin['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                    'force_activation'   => $plugin['force_activation'], // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => $plugin['force_deactivation'], // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                    'external_url'       => $plugin['external_url'], // If set, overrides default API URL and points to an external URL.
                    'is_callable'        => $plugin['is_callable'], // If set, this callable will be be checked for availability to determine if a plugin is active.
                ];
            }
        }
        tgmpa($plugins, $this->plugin_activation_config());
    }

    protected function plugin_activation_config() {
        return [
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
            /*
            'strings'      => array(
                'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
                'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
                // <snip>...</snip>
                'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
            */
        ];
    }
}
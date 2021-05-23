<?php


namespace CodedoctorWordpressFlashCore\Loader\contracts;


trait GlobalVariables
{
    /**
     * Temporary storage of WP_Theme object
     * @var \WP_Theme $theme_global_information
     */
    protected static $theme_global_information = NULL;

    /**
     * Get current Theme template_widget directory path
     * @param string $path
     * @return string|null
     */
    public static function template_widget_dir(string $path): ?string {
        if(defined('CD_THEME_DIR')) {
            return CD_THEME_DIR . '/template-widgets/' . $path;
        }
        return null;
    }

    /**
     * Get Current Theme URL
     * @return string|null
     */
    public static function theme_dir(): ?string
    {
        if (defined('CD_THEME_DIR')) return CD_THEME_DIR;
        return NULL;
    }

    /**
     * Get Current Theme URL
     * @return string|null
     */
    public static function theme_url(): ?string
    {
        if (defined('CD_THEME_URL')) return CD_THEME_URL;
        return NULL;
    }

    /**
     * Get Current Theme Assets URL
     * @param string $path
     * @return string|null
     */
    public static function theme_asset_url(string $path): ?string
    {
        $theme_url = self::theme_url();
        return !empty($theme_url) ? "{$theme_url}/assets/{$path}" : NULL;
    }

    /**
     * Get Current Theme Text Domain
     * @return string|null
     */
    public static function theme_text_domain(): ?string
    {
        try {
            return self::get_template_global_info()->get('TextDomain');
        } catch (\Exception $exception) {
            return NULL;
        }
    }

    /**
     * Get Current Theme Author Name
     * @return string|null
     */
    public static function theme_author_name(): ?string
    {
        try {
            return self::get_template_global_info()->get('Author');
        } catch (\Exception $exception) {
            return NULL;
        }
    }

    /**
     * Get Current Theme Author URL
     * @return string|null
     */
    public static function theme_author_url(): ?string
    {
        try {
            return self::get_template_global_info()->get('AuthorURI');
        } catch (\Exception $exception) {
            return NULL;
        }
    }

    /**
     * Get Current Theme Description
     * @return string|null
     */
    public static function theme_description(): ?string
    {
        try {
            return self::get_template_global_info()->get('Description');
        } catch (\Exception $exception) {
            return NULL;
        }
    }

    /**
     * Get Current Theme Version
     * @return array|false|string|null
     */
    public static function theme_version()
    {
        try {
            return self::get_template_global_info()->get('Version');
        } catch (\Exception $exception) {
            return NULL;
        }
    }

    /**
     * Get template information
     * @return \WP_Theme|null
     */
    protected static function get_template_global_info(): \WP_Theme
    {
        if(!self::$theme_global_information):
            self::$theme_global_information = wp_get_theme('registernursingpath');
        endif;
        return self::$theme_global_information;
    }
}
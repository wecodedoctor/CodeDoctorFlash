<?php


namespace CodedoctorWordpressFlashSection\src\contracts;


class MetaboxFrontEndInformations
{
    protected string $metabox_view_path_base = 'ThemeResource/views/sections';
    protected string $metabox_title;
    protected string $metabox_view_path;
    protected string $metabox_screenshot;
    protected string $metabox_container_id;
    protected $metabox_section_id;

    /**
     * @param string $title
     * @return $this
     */
    public function set_metabox_title(string $title)
    {
        $this->metabox_title = $title;
        return $this;
    }

    /**
     * Set view path
     * @param string $path
     * @return $this
     */
    public function set_metabox_view_path(string $path)
    {
        $this->metabox_view_path = $path;
        return $this;
    }

    /**
     * Set metabox screenshot
     * @param string $screenshot_url
     * @return $this
     */
    public function set_metabox_screenshot(string $screenshot_url)
    {
        $this->metabox_screenshot = $screenshot_url;
        return $this;
    }

    /**
     * Set metabox container id
     * @param string $container_id
     * @return $this
     */
    public function set_metabox_container_id(string $container_id)
    {
        $this->metabox_container_id = $container_id;
        return $this;
    }

    /**
     * Section post id set
     * @param $section_id
     * @return $this
     */
    public function set_metabox_section_id($section_id) {
        $this->metabox_section_id = $section_id;
        return $this;
    }

    /**
     * Get metabox title
     * @return string
     */
    public function get_metabox_title(): string {
        return $this->metabox_title;
    }

    /**
     * Get metabox view path
     * @return string
     */
    public function get_metabox_view_path(): string {
        return $this->metabox_view_path;
    }

    /**
     * Get metabox screenshot
     * @return string
     */
    public function get_metabox_screenshot(): string {
        return $this->metabox_screenshot;
    }

    /**
     * Get metabox container id
     * @return string
     */
    public function get_metabox_container_id(): string {
        return $this->metabox_container_id;
    }

    public function getViewHtml(int $section_id, $data) {
        $this->set_metabox_section_id( $section_id );
        $view_path = get_template_directory() . DIRECTORY_SEPARATOR . $this->metabox_view_path_base . DIRECTORY_SEPARATOR . 'section-' . $this->metabox_view_path . '.php';
        if(file_exists($view_path)) {
            $attrs = [];
            $classes = [];

            $classes[] = "section-id-{$this->metabox_section_id}";
            $classes[] = "section--{$this->metabox_container_id}";
            if(is_user_logged_in() && current_user_can( 'manage_options' )) {
                $attrs[] = "data-admin-section-id=\"{$this->metabox_section_id}\"";
                $attrs[] = "data-metabox-title=\"{$this->metabox_title}\"";
            }
            get_template_part($this->metabox_view_path_base . '/section' , $this->metabox_view_path, array(
                'container_id' => $this->metabox_container_id,
                'screenshot' => $this->metabox_screenshot,
                'section_id' => $this->metabox_section_id,
                'classes' => implode(" ", $classes),
                'attrs' => implode(" ", $attrs),
	            'data' => $data
            ));
        }
    }

    /**
     * Get field data
     * @param string $field_name
     * @return mixed
     */
    public function getFieldData(string $field_name) {
        return carbon_get_post_meta($this->metabox_section_id, $field_name, $this->metabox_container_id);
    }
}
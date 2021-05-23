<?php


namespace CodedoctorWordpressFlashCore\RegisterMetabox;


use Carbon_Fields\Container;
use Carbon_Fields\Container\Container as ContainerBuider;
use Carbon_Fields\Field;
use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashSection\src\contracts\MetaboxFrontEndInformations;
use function Symfony\Component\String\u;

abstract class AbstractRegisterMetaboxPostType extends AbstractClassLoader
{
    /**
     * @var string $metabox_title
     */
    protected $metabox_title = '';
    /**
     * @var string $metabox_container_id
     */
    protected $metabox_container_id = '';
    /**
     * @var string $metabox_view_path
     */
    protected $metabox_view_path = '';
    /**
     * @var string $metabox_screenshot
     */
    protected $metabox_screenshot = '';

    public function boot()
    {
        $this->_autogenerate_metabox_title();
        $this->_autogenerate_metabox_container_id();
        $this->_autogenerate_metabox_view_path();
        add_action( 'carbon_fields_register_fields', [$this, 'metabox']);
    }

    /**
     * Metabox initialization
     * @return void
     */
    public function metabox() {
        if(!empty($this->metabox_screenshot)) {
            $screenshot_url = esc_url( get_template_directory_uri() . '/Theme/Sections/screenshot/' . $this->metabox_screenshot );
            $container_title = '<img src="' . $screenshot_url . '" alt="Preview image"/>' . __($this->metabox_title, self::theme_text_domain()) . '';
        } else {
            $container_title = __($this->metabox_title, self::theme_text_domain());
        }
        $container = Container::make( 'post_meta', $this->metabox_container_id, $container_title );
        $container = $this->displayCondition( $container )
            ->add_fields( $this->metabox_fields() );
        $this->container_configuration($container);
    }

    /**
     * Display condition
     * @param ContainerBuider $container
     * @return ContainerBuider
     */
    protected function displayCondition(ContainerBuider $container) {
        if(is_array($this->supported_posttype())) {
            $supported_post_type = $this->supported_posttype();
            $container_condition = $container->where('post_type', '=', $supported_post_type[0]);
            array_shift($supported_post_type);
            if(sizeof($supported_post_type) > 0) {
                foreach ($this->supported_posttype() as $post_type) {
                    $container_condition = $container->or_where('post_type', '=', $post_type);
                }
            }
            return $container_condition;
        } else {
            return $container->where( 'post_type', '=', $this->supported_posttype() );
        }
    }

    /**
     * Autogenerate metabox title
     * @return void
     */
    protected function _autogenerate_metabox_title() {
        if(empty($this->metabox_title)) {
            $current_class = get_called_class();
            $current_class = u($current_class)->snake();
            $current_class = preg_replace('/[_]/', ' ', $current_class);
            $this->metabox_title = u($current_class)->title();
        }
    }

    /**
     * Autogenerate metabox container id
     * @return void
     */
    protected function _autogenerate_metabox_container_id() {
        if(empty($this->metabox_container_id)) {
            $current_class = get_called_class();
            $this->metabox_container_id = u($current_class)->snake();
        }
    }

    /**
     * Autogenerate metabox view path
     * @return void
     */
    protected function _autogenerate_metabox_view_path() {
        if(empty($this->metabox_view_path)) {
            $this->metabox_view_path = $this->metabox_container_id;
        }
    }

    public function getContainerFrontend() {
        return (new MetaboxFrontEndInformations())
            ->set_metabox_container_id($this->metabox_container_id)
            ->set_metabox_screenshot($this->metabox_screenshot)
            ->set_metabox_title($this->metabox_title)
            ->set_metabox_view_path($this->metabox_view_path);
    }

    /**
     * Get Container ID
     * @return string
     */
    public function getContainerId() {
        return $this->metabox_container_id;
    }

    protected function container_configuration(ContainerBuider $container) {

    }

    /**
     * Supportted post type
     * @return string|array
     */
    public abstract function supported_posttype();

    /**
     * Get metabox fields
     * @return Field[]
     */
    public abstract function metabox_fields(): array;

}
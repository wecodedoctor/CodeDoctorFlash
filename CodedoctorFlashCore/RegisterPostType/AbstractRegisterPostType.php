<?php


namespace CodedoctorWordpressFlashCore\RegisterPostType;


use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use function Symfony\Component\String\u;

abstract class AbstractRegisterPostType extends AbstractClassLoader
{
    /**
     * @var string $post_type
     */
    protected string $post_type;
    /**
     * @var string $hook_name
     */
    protected $hook_name;

    public function boot()
    {
        $this->_autoload_posttype();
        $this->_autoload_hookname();
        add_action('init', array($this, 'register_post'), 0);
        add_filter( $this->hook_name, [$this, 'fetchQuery'], 10, 1 );
    }

    /**
     * Boot the post type registration
     * @return void
     */
    public function register_post(): void
    {
        $args = $this->register_post_type_args();
        register_post_type($this->post_type, $args);
    }

    abstract public function register_post_type_args(): array;

    /**
     * Get post listing query hook name
     * @return string
     */
    public function getHookName(): string
    {
        return $this->hook_name;
    }

    /**
     * Get the post type
     * @return string
     */
    public function getPostType(): string {
        return $this->post_type;
    }

    /**
     * Fetch the posts of the post_type
     * @param array $args
     * @return \WP_Query
     */
    public function fetchQuery(array $args = array()): \WP_Query
    {
        $args = array_merge($args, [
            'post_type' => $this->post_type
        ]);
        return new \WP_Query($args);
    }

    /**
     * Autoload post type
     * @return void
     */
    protected function _autoload_posttype(): void {
        if(empty($this->post_type)) {
            $current_class_name = get_called_class();
            $this->post_type = u($current_class_name)->snake();
        }
    }

    /**
     * Autoload hookname
     * @return void
     */
    protected function _autoload_hookname(): void {
        if($this->post_type) {
            $this->hook_name = 'get_post' . $this->post_type;
        }
    }
}
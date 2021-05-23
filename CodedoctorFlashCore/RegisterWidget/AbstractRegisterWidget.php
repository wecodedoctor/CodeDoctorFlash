<?php


namespace CodedoctorWordpressFlashCore\RegisterWidget;


use Carbon_Fields\Field;
use Carbon_Fields\Widget;
use CodedoctorWordpressFlashCore\Loader\contracts\GlobalVariables;
use function Symfony\Component\String\u;

abstract class AbstractRegisterWidget extends Widget
{
    use GlobalVariables;

    /**
     * @var string $widget_id
     */
    protected $widget_id = '';
    /**
     * @var string $widget_description
     */
    protected $widget_description = '';
    /**
     * @var string $widget_title
     */
    protected $widget_title = '';
    /**
     * @var string $widget_view_path
     */
    protected $widget_view_path = '';

    public function __construct()
    {
        $this->_autogenerate_widget_id();
        $this->_autogenerate_widget_title();
        $this->_autogenerate_widget_view_path();
        $this->setup($this->widget_id, $this->widget_title, $this->widget_description, $this->widget_fields());
    }

    /**
     * Set widget fields
     * @return Field[]
     */
    public abstract function widget_fields(): array;

    /**
     * Front end load the view
     * @param array $args
     * @param array $instance
     */
    public function front_end($args, $instance)
    {
        $GLOBALS['args'] = $args;
        $GLOBALS['instance'] = $instance;
        include $this->widget_view_path;
    }

    /**
     * Autogenerate widget ID from the class
     * @return void
     */
    protected function _autogenerate_widget_id() {
        if(empty($this->widget_id)) {
            $current_class_name = get_called_class();
            $this->widget_id = u($current_class_name)->snake();
        }
    }

    protected function _autogenerate_widget_view_path() {
        if(empty($this->widget_view_path)) {
            $current_class_name = get_called_class();
            $this->widget_view_path = self::theme_dir() . '/widget-views/' . u($current_class_name)->snake() . '.php';
        }
    }


    /**
     * Autogenerate widget title from the class
     * @return void
     */
    protected function _autogenerate_widget_title() {
        if(empty($this->widget_title)) {
            $current_class_name = get_called_class();
            $current_class_name = u($current_class_name)->snake();
            $current_class_name = preg_replace('/[_]/', ' ', $current_class_name);
            $this->widget_title = u($current_class_name)->title(true);
        }
    }
}
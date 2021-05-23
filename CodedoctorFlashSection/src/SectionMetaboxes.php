<?php


namespace CodedoctorWordpressFlashSection\src;


use CodedoctorWordpressFlashCore\Loader\AbstractAutoDirectoryFileLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;
use CodedoctorWordpressFlashCore\RegisterMetabox\AbstractRegisterMetaboxPostType;
use CodedoctorWordpressFlashSection\src\contracts\MetaboxFrontEndInformations;

class SectionMetaboxes extends AbstractAutoDirectoryFileLoader
{
    use ClassInitializer;

    /**
     * @var string $path
     */
    protected $path = 'Sections/metabox';
    /**
     * @var AbstractRegisterMetaboxPostType[] $meta_boxes
     */
    protected $meta_boxes = [];

    protected function registarer() {
        add_filter('section_metaboxes', [$this, 'getMetaboxes'], 0);
        add_filter( 'default_hidden_meta_boxes', [$this, 'hideMetaboxes'], 10, 2 );
    }
    /**
     * @param array $classes
     */
    protected function after_class_loaded(array $classes = [])
    {
        if(!empty($classes)) {
            foreach ($classes as $class) {
                if(!empty($class) && $class instanceof AbstractRegisterMetaboxPostType) {
                    $this->meta_boxes[] = call_user_func_array(array($class, 'getContainerFrontend'), array());
                }
            }
        }
    }

    public function getMetaboxes(): array
    {
        return $this->meta_boxes;
    }

    public function hideMetaboxes($hidden, $screen) {
        if($screen->id === PostType::init()->getPostType()) {
            foreach ($this->meta_boxes as $metabox) {
                if($metabox instanceof MetaboxFrontEndInformations) {
                    $hidden[] = 'carbon_fields_container_' . $metabox->get_metabox_container_id();
                }
            }
        }


        return $hidden;
    }
}
<?php


namespace CodedoctorWordpressFlashSection\src;


use Carbon_Fields\Container\Container as ContainerBuider;
use Carbon_Fields\Field;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;
use CodedoctorWordpressFlashCore\RegisterMetabox\AbstractRegisterMetaboxPostType;
use CodedoctorWordpressFlashSection\src\contracts\MetaboxFrontEndInformations;

class SelectionMetabox extends AbstractRegisterMetaboxPostType
{
    use ClassInitializer;

    protected $metabox_title = 'Layout type';

    protected $metabox_container_id = 'layout_type';

    public function supported_posttype()
    {
        return PostType::init()->getPostType();
    }

    protected function container_configuration(ContainerBuider $container)
    {
       return $container->set_context('carbon_fields_after_title');
    }

    public function metabox_fields(): array
    {
        $metaboxes = apply_filters('section_metaboxes', null);
        $metabox_list = [
            0 => 'Select'
        ];
        foreach ($metaboxes as $metabox) {
            if($metabox instanceof MetaboxFrontEndInformations) {
                $metabox_list[$metabox->get_metabox_container_id()] = $metabox->get_metabox_title();
            }
        }
        return [
            Field::make('select', 'chosen_layout_type', __('Choose layout type', self::theme_text_domain()))
                ->add_options( $metabox_list )
                ->set_required(true)
        ];
    }
}
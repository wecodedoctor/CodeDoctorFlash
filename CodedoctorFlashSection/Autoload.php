<?php


namespace CodedoctorWordpressFlashSection;


use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;
use CodedoctorWordpressFlashSection\src\contracts\MetaVariableExchangeWithTemplate;
use CodedoctorWordpressFlashSection\src\page\PageSupportMetabox;
use CodedoctorWordpressFlashSection\src\PostType;
use CodedoctorWordpressFlashSection\src\SectionMetaboxes;
use CodedoctorWordpressFlashSection\src\SelectionMetabox;

class Autoload extends AbstractClassLoader
{
    use ClassInitializer;

    public function boot()
    {
        PostType::init();
        SelectionMetabox::init();
        SectionMetaboxes::init();
        PageSupportMetabox::init();
    }
}
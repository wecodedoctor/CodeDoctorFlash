<?php


namespace CodedoctorWordpressFlashSection\contracts;


use CodedoctorWordpressFlashCore\RegisterMetabox\AbstractRegisterMetaboxPostType;
use CodedoctorWordpressFlashSection\src\PostType;

abstract class AbstractRegisterLayoutSectionMetabox extends AbstractRegisterMetaboxPostType
{
    public function supported_posttype()
    {
        return PostType::init()->getPostType();
    }
}
<?php


namespace CodedoctorWordpressFlashCore\Loader\contracts;


trait ClassInitializer
{
    public static $init = null;

    /**
     *
     * @return self
     */
    static function init()
    {
        if(!self::$init):
            self::$init = new self();
        endif;
        return self::$init;
    }
}
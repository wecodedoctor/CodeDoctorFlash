<?php
use CodedoctorWordpressFlashSection\src\contracts\MetaVariableExchangeWithTemplate;
use CodedoctorWordpressFlashSection\src\contracts\MetaboxTemplatepartData;
if(!function_exists('layout_sections_vars')) {
	/**
	 * Send data reciver function
	 * @param $id
	 * @param $container_id
	 *
	 * @return MetaVariableExchangeWithTemplate
	 */
    function layout_sections_vars($id, $container_id): MetaVariableExchangeWithTemplate {
	    return (new MetaVariableExchangeWithTemplate())
		    ->set_section_id($id)
		    ->set_container_id($container_id);
    }
}

if(!function_exists('layout_get_attrs')) {
	/**
	 * Get attrs
	 * @param array $args
	 *
	 * @return MetaboxTemplatepartData
	 */
	function layout_get_attrs(array $args): MetaboxTemplatepartData {
		return (new MetaboxTemplatepartData())->set_args($args);
	}
}
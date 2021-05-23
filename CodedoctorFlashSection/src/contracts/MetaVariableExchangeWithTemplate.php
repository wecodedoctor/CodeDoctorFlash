<?php


namespace CodedoctorWordpressFlashSection\src\contracts;


use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class MetaVariableExchangeWithTemplate extends AbstractClassLoader {
	use ClassInitializer;

	protected $section_id;
	protected $container_id;

	public function boot() {
		// TODO: Implement boot() method.
	}

	/**
	 * Set section id
	 * @param $id
	 *
	 * @return $this
	 */
	public function set_section_id($id) {
		$this->section_id = $id;
		return $this;
	}

	/**
	 * Set container ID
	 * @param $id
	 *
	 * @return $this
	 */
	public function set_container_id($id) {
		$this->container_id = $id;
		return $this;
	}

	/**
	 * Get fontend information
	 * @return MetaboxFrontEndInformations|mixed|null
	 */
	public function getFrontEndInformation(): ?MetaboxFrontEndInformations {
		$metaboxes = apply_filters('section_metaboxes', null);
		$metabox_list = [];
		foreach ($metaboxes as $metabox) {
			if($metabox instanceof MetaboxFrontEndInformations) {
				$metabox_list[$metabox->get_metabox_container_id()] = $metabox;
			}
		}
		if(array_key_exists($this->container_id, $metabox_list)) {
			return $metabox_list[ $this->container_id ];
		}
		return null;
	}

	/**
	 * Get the field data
	 * @param $name
	 *
	 * @return mixed
	 */
	public function data($name) {
		return carbon_get_post_meta($this->section_id, $name, 'carbon_fields_container_' . $this->container_id);
	}
}
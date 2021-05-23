<?php


namespace CodedoctorWordpressFlashSection\src\contracts;


use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;

class MetaboxTemplatepartData extends AbstractClassLoader {
	use ClassInitializer;

	protected $args;

	public function boot() {
		// TODO: Implement boot() method.
	}

	public function set_args(array $args) {
		$this->args = $args;
		return $this;
	}
	//'container_id' => $this->metabox_container_id,
	//                'screenshot' => $this->metabox_screenshot,
	//                'section_id' => $this->metabox_section_id,
	//                'classes' => implode(" ", $classes),
	//                'attrs' => implode(" ", $attrs),
	//	            'data' => $data
	public function get_container_id(): ?string {
		if(array_key_exists('container_id', $this->args)) {
			return $this->args['container_id'];
		}
		return null;
	}

	public function get_screenshot(): ?string {
		if(array_key_exists('screenshot', $this->args)) {
			return $this->args['screenshot'];
		}
		return null;
	}

	public function get_section_id(): ?string {
		if(array_key_exists('section_id', $this->args)) {
			return $this->args['section_id'];
		}
		return null;
	}

	public function get_classes(): ?string {
		if(array_key_exists('classes', $this->args)) {
			return $this->args['classes'];
		}
		return null;
	}

	public function get_attrs(): ?string {
		if(array_key_exists('attrs', $this->args)) {
			return $this->args['attrs'];
		}
		return null;
	}

	public function get_field_data($name) {
		if(array_key_exists('data', $this->args) && $this->args['data'] instanceof MetaVariableExchangeWithTemplate) {
			return $this->args['data']->data($name);
		}
		return null;
	}
}
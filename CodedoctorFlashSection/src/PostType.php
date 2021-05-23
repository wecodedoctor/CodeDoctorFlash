<?php


namespace CodedoctorWordpressFlashSection\src;


use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;
use CodedoctorWordpressFlashCore\RegisterPostType\AbstractRegisterPostType;

class PostType extends AbstractRegisterPostType
{
    use ClassInitializer;

    protected $post_type = 'cf_sections';

    public function register_post_type_args(): array
    {
        return array(
            'label' => __($this->post_type, self::theme_text_domain()),
            'labels' => array(
                'name'                => _x( 'Layout Sections', 'Post Type General Name', self::theme_text_domain() ),
                'singular_name'       => _x( 'Layout Section', 'Post Type Singular Name', self::theme_text_domain() ),
                'menu_name'           => __( 'Layout Section', self::theme_text_domain() ),
                'parent_item_colon'   => __( 'Parent Layout Section', self::theme_text_domain() ),
                'all_items'           => __( 'All Layout Sections', self::theme_text_domain() ),
                'view_item'           => __( 'View Layout Section', self::theme_text_domain() ),
                'add_new_item'        => __( 'Add New Layout Section', self::theme_text_domain() ),
                'add_new'             => __( 'Add New', self::theme_text_domain() ),
                'edit_item'           => __( 'Edit Layout Section', self::theme_text_domain() ),
                'update_item'         => __( 'Update Layout Section', self::theme_text_domain() ),
                'search_items'        => __( 'Search Layout Section', self::theme_text_domain() ),
                'not_found'           => __( 'Not Found', self::theme_text_domain() ),
                'not_found_in_trash'  => __( 'Not found in Trash', self::theme_text_domain() ),
            ),
            'description'         => __( 'Page layout sections', self::theme_text_domain() ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-align-wide',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'          => true,
            'supports'           => array( 'title' )
        );
    }
}
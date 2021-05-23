<?php


namespace CodedoctorWordpressFlashSection\src\page;


use CodedoctorWordpressFlashCore\Loader\AbstractClassLoader;
use CodedoctorWordpressFlashCore\Loader\contracts\ClassInitializer;
use CodedoctorWordpressFlashSection\src\PostType;

class PageSupportMetabox extends AbstractClassLoader
{
    use ClassInitializer;

    public function boot()
    {
        add_action('load-post.php', array($this,'registerMetaBox') );
        add_action('load-post-new.php', array($this,'registerMetaBox') );
        add_action("wp_ajax_search_sections_for_page", array($this, "ajaxSearchSections"));
        add_action("wp_ajax_update_sections_for_page", array($this, "ajaxSavePostRelatedSection"));
        add_action("wp_ajax_update_sections_for_page", array($this, "ajaxSavePostRelatedSection"));
        add_action('admin_head', array($this,'remove_page_editor'));
        add_filter('page_sections_list', [$this, 'getPostSectionsMeta'], 1);
    }

    public function remove_page_editor() {
        remove_post_type_support('page', 'editor');
    }

    public function registerMetaBox() {
        add_action( 'add_meta_boxes', array($this,'addMetaBox') );
        add_action( 'save_post', array($this, 'onSavePage'), 10, 2 );
    }

    public function addMetaBox()
	{
		add_meta_box(
			'cd_section_selection_metabox',      // Unique ID
			esc_html__( 'Page sections', self::theme_text_domain() ),    // Title
			array($this, 'addMetaBoxCallback'),   // Callback function
			'page',         // Admin page (or post type)
			'normal',         // Context
			'core'         // Priority
		);
	}

	public function addMetaBoxCallback(\WP_Post $post)
    {
        $GLOBALS['post'] = $post;
        $GLOBALS['sections'] = $this->getPostSectionsMeta($post->ID);
        $GLOBALS['nonce_value'] = basename(__FILE__);
        ob_start();
        include __DIR__ . '/view/section_metabox_view.php';
        echo ob_get_clean();
    }

    public function onSavePage($post_id, $post)
    {

        if ( !isset( $_REQUEST['codedoctor_template_01_nonce'] ) || !wp_verify_nonce( $_POST['codedoctor_template_01_nonce'], basename( __FILE__ ) ) ) {
            return $post_id;
        }
        $post_type = get_post_type_object( $post->post_type );
        if(!current_user_can($post_type->cap->edit_post, $post_id)) {
            return $post_id;
        }
        $section_setting = isset($_REQUEST['admin_section_selection_setting']) ? str_replace('\\', '' ,$_REQUEST['admin_section_selection_setting']) : '';
        $applied_sections = isset($_REQUEST['admin_section_selection_setting']) ? json_decode($section_setting, true) : array();
//		file_put_contents(dirname(__FILE__) . '/request.txt' , $section_setting);
//		file_put_contents(dirname(__FILE__) . '/test.txt' , json_encode($applied_sections, JSON_PRETTY_PRINT));
//		file_put_contents(dirname(__FILE__) . '/nonce-submit.txt' , wp_verify_nonce( $_REQUEST['codedoctor_template_01_nonce'], basename( __FILE__ ) ));
		update_post_meta($post_id, '_cd-sections', $applied_sections);
    }

    public function ajaxSearchSections()
    {
        $search_terms = isset($_REQUEST['s']) ? trim($_REQUEST['s']) : NULL;
        $already_selected = isset($_REQUEST['already_selected']) ? $_REQUEST['already_selected'] : array();
        $posts = apply_filters(PostType::init()->getHookName(), array(
            's' => $search_terms,
            'post__not_in' => $already_selected
        ));
        $filter_posts = array();
        if($posts->have_posts()):
            while($posts->have_posts()):
                $posts->the_post();
                $filter_posts[] = array(
                    'post_title' => get_the_title(),
                    'post_id' => get_the_ID(),
                    'post_edit_url' => get_edit_post_link(get_the_ID())
                );
            endwhile;
        endif;
        wp_send_json($filter_posts);
        wp_die();
    }

    public function ajaxSavePostRelatedSection()
    {
        $response = array(
            'status' => false,
            'message' => 'Something went wrong. Please try again'
        );
        try {
            $queries_post_id = isset($_REQUEST['post_id']) ? trim($_REQUEST['post_id']) : NULL;
            $post = get_post($queries_post_id);
            $post_type = get_post_type_object( $post->post_type );
            if(current_user_can($post_type->cap->edit_post, $queries_post_id)) {
                $applied_sections = isset($_REQUEST['sections']) ? $_REQUEST['sections'] : array();
                if(empty($queries_post_id)) throw new \Exception("Invalid request. Please check and try again.");
                update_post_meta($queries_post_id, '_cd-sections', $applied_sections);
                $response['status'] = true;
                $response['message'] = 'Successfully saved';
            } else {
                throw new \Exception('You don\'t have permission to update the post.');
            }
        } catch (\Exception $exception) {
            $response['message'] = $exception->getMessage();
        }
        wp_send_json($response);
        wp_die();
    }

    public function getPostSectionsMeta($post_id = NULL)
    {
        $post_id = !empty($post_id) ? $post_id : (isset($_GET['post']) ? $_GET['post'] : NULL);
        $meta_value = get_post_meta($post_id, '_cd-sections', true);
        return !empty($meta_value) ? $meta_value : array();
    }
}
<?php
    global $sections, $nonce_value;
    $page_id = isset($_GET['post']) ? $_GET['post'] : NULL;
    wp_nonce_field( $nonce_value, 'codedoctor_template_01_nonce' );
    $is_edit_mode = isset($_GET['action']) && $_GET['action'] == 'edit';
?>
<div class="_cd-admin-section-selection-of-sections" id="admin_section_selection_panel">
    <input type="hidden" id="_cd-admin-section-selection-of-sections--page-id" value="<?php _e($page_id);?>">
    <input type="hidden" name="admin_section_selection_setting" id="_cd-admin-section-selection-setting" value='<?php _e(json_encode($sections, JSON_UNESCAPED_SLASHES));?>'>
	<div class="_cd-admin-section-selection-list">
        <div class="section-title">Chosen sections</div>
		<ul class="_cd-admin-section-selection-list--list" id="_cd-admin-section-selection-of-sections--sortable">
            <?php if(!empty($sections)): foreach ($sections as $section): $section['title'] = get_the_title($section['id']); ?>
            <li class="ui-state-default" data-id="<?php _e($section['id']);?>" data-value='<?php echo json_encode($section, JSON_UNESCAPED_SLASHES);?>'>
                <div class="item">
                    <div class="item-drag-button"><span class="dashicons dashicons-sort"></span></div>
                    <div class="item-name"><?php _e($section['title']);?></div>
                    <div class="item-actions">
                        <a class="button-link" href="<?php _e(esc_url(get_edit_post_link($section['id'])));?>" target="_blank"><span class="dashicons dashicons-edit"></span></a>
                        <a class="button-link-delete" href="#" data-remove-id="${post_id}" onclick="selection_operations.chosen_remove(event, this, <?php _e($section['id']);?>)"><span class="dashicons dashicons-trash"></span></a>
                    </div>
                </div>
            </li>
            <?php endforeach; endif;?>
        </ul>
        <!--<div class="section-loader" id="_cd-admin-selection-save--loader">
            <span class="spinner is-active" style="background-image: url('<?php _e(esc_url(includes_url( 'images/spinner-2x.gif' )));?>')"></span>
        </div>-->
        <?php if ( $is_edit_mode ):?>
            <div class="_cd-admin-section-selection-list--actions">
                <button class="button-primary" id="_cd-admin-section-selection-list--save">Save</button>
            </div>
<!--            <div style="text-align: right"><i class="description">**Update of post type will not save the section. You must save the sections separately.</i></div>-->
        <?php endif;?>
	</div>
    <div class="_cd-admin-section-selection-list--add-new-section">
        <div class="section-title">Search and add new</div>
        <div class="_cd-admin-section-input">
            <div class="_cd-admin-section-input--search-value">
                <div class="input-icon"><label for="_cd-admin-section-input--search-value--input" class="dashicons dashicons-search"></label></div>
                <div class="input"><input id="_cd-admin-section-input--search-value--input" type="text" name="" placeholder="Search..."></div>
                <div class="input-loader"><span class="spinner" id="_cd-admin-selection-input-result--loader"></span></div>
            </div>
        </div>
        <div class="_cd-admin-selection-input-result" id="_cd-admin-selection-input-result-holder">
            <div class="_cd-admin-selection-input-result--container">
                <div class="_cd-admin-selection-input-result--header">
                    <div class="_cd-admin-selection-input-result--title">
                        <div class="_cd-title">Search results</div>
                        <div class="_cd-counts" id="_cd-admin-selection-input-result--counter">Found 2 results</div>
                    </div>
                    <div class="_cd-admin-selection-input-result--close"><span class="dashicons dashicons-no-alt" id="_cd-admin-selection-input-result--close"></span></div>
                </div>
                <div class="_cd-admin-selection-input-result--body">
                    <ul id="_cd-admin-selection-input-result">
                        <li>
                            <div class="item">
                                <div class="item-title">This is the item name</div>
                                <div class="item-actions">
                                    <a class="button-primary" href="" target="_blank">View</a>
                                    <a class="button-secondary" href="" target="_blank">Select</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
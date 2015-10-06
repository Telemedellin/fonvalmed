<?php




/**
 *  wpuxss_eml_on_admin_init
 *
 *  @since    1.0
 *  @created  03/08/13
 */
 
add_action( 'admin_init', 'wpuxss_eml_on_admin_init' );

if( ! function_exists('wpuxss_eml_on_admin_init') ) {
    
    function wpuxss_eml_on_admin_init() {
    
        // plugin settings: taxonomies
        register_setting( 
            'wpuxss_eml_taxonomies', //option_group
            'wpuxss_eml_taxonomies', //option_name
            'wpuxss_eml_taxonomies_validate' //sanitize_callback
        );
        
        // plugin settings: common options
        register_setting( 
            'wpuxss_eml_taxonomies', //option_group
            'wpuxss_eml_tax_options', //option_name
            'wpuxss_eml_tax_options_validate' //sanitize_callback
        );
    
        // plugin settings: mime types
        register_setting( 
            'wpuxss_eml_mimes', //option_group
            'wpuxss_eml_mimes', //option_name
            'wpuxss_eml_mimes_validate' //sanitize_callback
        );
    
        // plugin settings: mime types backup
        register_setting( 
            'wpuxss_eml_mimes_backup', //option_group
            'wpuxss_eml_mimes_backup' //option_name
        );
    }
}




/**
 *  wpuxss_eml_admin_menu
 *
 *  @since    1.0
 *  @created  28/09/13
 */

add_action('admin_menu', 'wpuxss_eml_admin_menu');

if( ! function_exists('wpuxss_eml_admin_menu') ) {
    
    function wpuxss_eml_admin_menu() {
        
        remove_submenu_page( 'options-general.php', 'options-media.php' );
        
        add_utility_page(
            __('Media Settings','eml'), //page_title
            __('Media Settings','eml'), //menu_title
            'manage_options',           //capability
            'options-media.php',        //page
            '',                         //callback
            'dashicons-admin-media'
        );
        
        add_submenu_page(
            'options-media.php', 
            __('Media Settings','eml'), 
            __('Settings','eml'), 
            'manage_options', 
            'options-media.php'
        );
        
        $eml_taxonomies_options_suffix = add_submenu_page(
            'options-media.php', 
            __('Taxonomies','eml'), 
            __('Taxonomies','eml'), 
            'manage_options', 
            'eml-taxonomies-options',
            'wpuxss_eml_print_taxonomies_options'
        );
        
        $eml_mimetype_options_suffix = add_submenu_page(
            'options-media.php', 
            __('MIME Types','eml'), 
            __('MIME Types','eml'), 
            'manage_options', 
            'eml-mimetype-options',
            'wpuxss_eml_print_mimetypes_options' 
        );
        
        add_action('admin_print_scripts-' . $eml_taxonomies_options_suffix, 'wpuxss_eml_admin_settings_pages_scripts');
        add_action('admin_print_scripts-' . $eml_mimetype_options_suffix, 'wpuxss_eml_admin_settings_pages_scripts');
    }
}




/**
 *  wpuxss_eml_admin_settings_pages_scripts
 *
 *  @since    1.0
 *  @created  28/10/13
 */

if( ! function_exists('wpuxss_eml_admin_settings_pages_scripts') ) {
        
    function wpuxss_eml_admin_settings_pages_scripts() {
        
        global $wpuxss_eml_version,
               $wpuxss_eml_dir;
        
        wp_enqueue_script(
            'wpuxss-eml-options-script',
            $wpuxss_eml_dir . 'js/eml-options.js',
            array('jquery'),
            $wpuxss_eml_version,
            true
        );
        
        $i18n_data = array(
            'edit' => __( 'Edit', 'eml' ),
            'close' => __( 'Close', 'eml' ),
            'view' => __( 'View', 'eml' ),
            'update' => __( 'Update', 'eml' ),
            'add_new' => __( 'Add New', 'eml' ),
            'new' => __( 'New', 'eml' ),
            'name' => __( 'Name', 'eml' ),
            'parent' => __( 'Parent', 'eml' ),
            'all' => __( 'All', 'eml' ),
            'search' => __( 'Search', 'eml' ),
            
            'tax_deletion_confirm' => __( 'Taxonomy will be deleted permanently! Your media files will remain intacted, but all the connections with this taxonomy and its terms will be lost.', 'eml' ),
            'tax_error_duplicate' => __( 'There is already a taxonomy with the same name. Please chose other one.', 'eml' ),
            'tax_new' => __( 'New Taxonomy', 'eml' ),
            'tax_error_empty_both' => __( 'Please choose Singular and Plural names for all your new taxomonies.', 'eml' ),
            'tax_error_empty_singular' => __( 'Please choose Singilar name for all your new taxomonies.', 'eml' ),
            'tax_error_empty_plural' => __( 'Please choose Plural Name for all your new taxomonies.', 'eml' ),
            
            'mime_deletion_confirm' => __( 'Warning! All your custom MIME Types will be deleted by this operation.', 'eml' ),
            'mime_error_empty_fields' => __( 'Please fill into all fields.', 'eml' ),
            'mime_error_duplicate' => __( 'Duplicate extensions or MIME types. Please chose other one.', 'eml' )
        );
        
        // TODO: revise l10n
        wp_localize_script( 
            'wpuxss-eml-options-script', 
            'wpuxss_eml_i18n_data',
            $i18n_data
        );
    }
}




/**
 *  wpuxss_eml_print_taxonomies_options
 *
 *  @type     callback function
 *  @since    1.0
 *  @created  28/09/13
 */

if( ! function_exists('wpuxss_eml_print_taxonomies_options') ) {
    
    function wpuxss_eml_print_taxonomies_options() {
        
        if (!current_user_can('manage_options'))   
            wp_die( __('You do not have sufficient permissions to access this page.','eml') );  
    
        $wpuxss_eml_taxonomies = get_option( 'wpuxss_eml_taxonomies' );
        $taxonomies = get_taxonomies( array(),'names' );
    ?>
        
        <div id="wpuxss-eml-global-options-wrap" class="wrap">    
            <?php screen_icon('options-general'); ?>
            <h2><?php _e('Taxonomies','eml'); ?></h2>
            
            <?php settings_errors(); ?>
            
            <div id="poststuff">
            
                <div id="post-body" class="metabox-holder columns-2">
    
                    <div id="postbox-container-2" class="postbox-container">
                    
                        <form id="wpuxss-eml-form-taxonomies" method="post" action="options.php">
    
                            <?php settings_fields( 'wpuxss_eml_taxonomies' ); ?>			
                            
                            <div class="postbox">
                                
                                <h3 class="hndle"><?php _e('Media Taxonomies','eml'); ?></h3>
                                
                                <div class="inside">
                                
                                    <p><?php _e('Assign following taxonomies to Media Library:','eml'); ?></p>
                                    
    <?php                           $html = '';
    
                                    foreach ( get_taxonomies(array(),'object') as $taxonomy )
                                    {
                                        if ( (in_array('attachment',$taxonomy->object_type) && count($taxonomy->object_type) == 1) || empty($taxonomy->object_type) )
                                        {
                                            $assigned = intval($wpuxss_eml_taxonomies[$taxonomy->name]['assigned']);
                                            $eml_media = intval($wpuxss_eml_taxonomies[$taxonomy->name]['eml_media']);
                                            
                                            if ( $eml_media )
                                                $li_class = 'wpuxss-eml-taxonomy';
                                            else 
                                                $li_class = 'wpuxss-non-eml-taxonomy';
                                            
                                            $html .= '<li class="' . $li_class . '" id="' . $taxonomy->name . '">';
                                                
                                            $html .= '<input class="wpuxss-eml-assigned" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][assigned]" type="checkbox" value="1" ' . checked( true, $assigned, false ) . ' title="' . __('Assign Taxonomy','eml') . '" />';
                                            $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][eml_media]" type="hidden" value="' . $eml_media . '" />';
                                            $html .= ' <label>' . $taxonomy->label . '</label>';
                                            $html .= '<a class="wpuxss-eml-button-edit" title="' . __('Edit Taxonomy','eml') . '" href="javascript:;">' . __('Edit','eml') . ' &darr;</a>';
                                            if ( $eml_media )
                                            {
                                                $html .= '<a class="wpuxss-eml-button-remove" title="' . __('Delete Taxonomy','eml') . '" href="javascript:;">&ndash;</a>';
                                                
                                                $html .= '<div class="wpuxss-eml-taxonomy-edit" style="display:none;">';
                                                
                                                $html .= '<div class="wpuxss-eml-labels-edit">';
                                                $html .= '<h4>' . __('Labels','eml') . '</h4>';
                                                $html .= '<ul>';
                                                $html .= '<li><label>' . __('Singular','eml') . '</label><input type="text" class="wpuxss-eml-singular_name" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][singular_name]" value="' . esc_html($taxonomy->labels->singular_name) . '" /></li>';
                                                $html .= '<li><label>' . __('Plural','eml') . '</label><input type="text" class="wpuxss-eml-name" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][name]" value="' . esc_html($taxonomy->labels->name) . '" /></li>';
                                                $html .= '<li><label>' . __('Menu Name','eml') . '</label><input type="text" class="wpuxss-eml-menu_name" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][menu_name]" value="' . esc_html($taxonomy->labels->menu_name) . '" /></li>';
                                                $html .= '<li><label>' . __('All','eml') . '</label><input type="text" class="wpuxss-eml-all_items" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][all_items]" value="' . esc_html($taxonomy->labels->all_items) . '" /></li>';
                                                $html .= '<li><label>' . __('Edit','eml') . '</label><input type="text" class="wpuxss-eml-edit_item" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][edit_item]" value="' . esc_html($taxonomy->labels->edit_item) . '" /></li>';
                                                $html .= '<li><label>' . __('View','eml') . '</label><input type="text" class="wpuxss-eml-view_item" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][view_item]" value="' . esc_html($taxonomy->labels->view_item) . '" /></li>';
                                                $html .= '<li><label>' . __('Update','eml') . '</label><input type="text" class="wpuxss-eml-update_item" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][update_item]" value="' . esc_html($taxonomy->labels->update_item) . '" /></li>';
                                                $html .= '<li><label>' . __('Add New','eml') . '</label><input type="text" class="wpuxss-eml-add_new_item" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][add_new_item]" value="' . esc_html($taxonomy->labels->add_new_item) . '" /></li>';
                                                $html .= '<li><label>' . __('New','eml') . '</label><input type="text" class="wpuxss-eml-new_item_name" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][new_item_name]" value="' . esc_html($taxonomy->labels->new_item_name) . '" /></li>';
                                                $html .= '<li><label>' . __('Parent','eml') . '</label><input type="text" class="wpuxss-eml-parent_item" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][parent_item]" value="' . esc_html($taxonomy->labels->parent_item) . '" /></li>';
                                                $html .= '<li><label>' . __('Search','eml') . '</label><input type="text" class="wpuxss-eml-search_items" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][labels][search_items]" value="' . esc_html($taxonomy->labels->search_items) . '" /></li>';
                                                $html .= '</ul>';
                                                $html .= '</div>';
                                                
                                                $html .= '<div class="wpuxss-eml-settings-edit">';
                                                $html .= '<h4>' . __('Settings','eml') . '</h4>';
                                                $html .= '<ul>';
                                                $html .= '<li><label>' . __('Taxonomy Name','eml') . '</label><input type="text" class="wpuxss-eml-taxonomy-name" name="" value="' . esc_attr($taxonomy->name) . '" disabled="disabled" /></li>';
                                                $html .= '<li><label>' . __('Hierarchical','eml') . '</label><input type="checkbox" class="wpuxss-eml-hierarchical" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][hierarchical]" value="1" ' . checked( 1, $taxonomy->hierarchical, false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Column in List View','eml') . '</label><input type="checkbox" class="wpuxss-eml-show_admin_column" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][show_admin_column]" value="1" ' . checked( 1, $taxonomy->show_admin_column, false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Filter in List View','eml') . '</label><input type="checkbox" class="wpuxss-eml-admin_filter" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][admin_filter]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['admin_filter'], false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Filter in Grid View / Media Popup','eml') . '</label><input type="checkbox" class="wpuxss-eml-media_uploader_filter" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][media_uploader_filter]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['media_uploader_filter'], false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Edit in Media Popup','eml') . '</label><input type="checkbox" class="wpuxss-eml-media_popup_taxonomy_edit" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][media_popup_taxonomy_edit]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['media_popup_taxonomy_edit'], false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Show in Nav Menu','eml') . '</label><input type="checkbox" class="wpuxss-eml-show_in_nav_menus" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][show_in_nav_menus]" value="1" ' . checked( 1, $taxonomy->show_in_nav_menus, false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Remember terms order (sort)','eml') . '</label><input type="checkbox" class="wpuxss-eml-sort" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][sort]" value="1" ' . checked( 1, $taxonomy->sort, false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Rewrite Slug','eml') . '</label><input type="text" class="wpuxss-eml-slug" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][rewrite][slug]" value="' . esc_attr($taxonomy->rewrite['slug']) . '" /></li>';
                                                $html .= '<li><label>' . __('Slug with Front','eml') . '</label><input type="checkbox" class="wpuxss-eml-rewrite-with-front" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][rewrite][with_front]" value="1" ' . checked( 1, $taxonomy->rewrite['with_front'], false ) . ' /></li>';
                                                $html .= '</ul>';
                                                $html .= '</div>';											
                                                
                                                $html .= '</div>';
                                            }
                                            else
                                            {
                                                $html .= '<div class="wpuxss-eml-taxonomy-edit" style="display:none;">';
                                                
                                                $html .= '<div class="wpuxss-eml-settings-edit">';
                                                $html .= '<h4>' . __('Settings','eml') . '</h4>';
                                                $html .= '<ul>';
                                                $html .= '<li><label>' . __('Filter in List View','eml') . '</label><input type="checkbox" class="wpuxss-eml-admin_filter" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][admin_filter]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['admin_filter'], false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Filter in Grid View / Media Popup','eml') . '</label><input type="checkbox" class="wpuxss-eml-media_uploader_filter" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][media_uploader_filter]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['media_uploader_filter'], false ) . ' /></li>';
                                                $html .= '<li><label>' . __('Edit in Media Popup','eml') . '</label><input type="checkbox" class="wpuxss-eml-media_popup_taxonomy_edit" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][media_popup_taxonomy_edit]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['media_popup_taxonomy_edit'], false ) . ' /></li>';
                                                $html .= '</ul>';	
                                                
                                                $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][show_admin_column]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['show_admin_column'] . '" />';
                                                $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][show_in_nav_menus]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['show_in_nav_menus'] . '" />';
                                                $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][hierarchical]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['hierarchical'] . '" />';
                                                $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][sort]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['sort'] . '" />';										
                                                $html .= '</div>';
                                                
                                                $html .= '</div>';
                                            }
                                            $html .= '</li>';	
                                        }
                                    }
                                    
                                    $html .= '<li class="wpuxss-eml-clone" style="display:none">';
                                    $html .= '<input class="wpuxss-eml-assigned" name="" type="checkbox" class="wpuxss-eml-assigned" value="1" checked="checked" title="' . __('Assign Taxonomy','eml') . '" />';
                                    $html .= '<input name="" type="hidden" class="wpuxss-eml-eml_media" value="1" />';
                                    $html .= ' <label class="wpuxss-eml-taxonomy-label">' . __('New Taxonomy','eml') . '</label>';
                                    
                                    $html .= '<a class="wpuxss-eml-button-remove" title="' . __('Delete Taxonomy','eml') . '" href="javascript:;">&ndash;</a>';
                                    
                                    $html .= '<div class="wpuxss-eml-taxonomy-edit">';
                                    
                                    $html .= '<div class="wpuxss-eml-labels-edit">';
                                    $html .= '<h4>' . __('Labels','eml') . '</h4>';
                                    $html .= '<ul>';
                                    $html .= '<li><label>' . __('Singular','eml') . '</label><input type="text" class="wpuxss-eml-singular_name" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Plural','eml') . '</label><input type="text" class="wpuxss-eml-name" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Menu Name','eml') . '</label><input type="text" class="wpuxss-eml-menu_name" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('All','eml') . '</label><input type="text" class="wpuxss-eml-all_items" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Edit','eml') . '</label><input type="text" class="wpuxss-eml-edit_item" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('View','eml') . '</label><input type="text" class="wpuxss-eml-view_item" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Update','eml') . '</label><input type="text" class="wpuxss-eml-update_item" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Add New','eml') . '</label><input type="text" class="wpuxss-eml-add_new_item" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('New','eml') . '</label><input type="text" class="wpuxss-eml-new_item_name" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Parent','eml') . '</label><input type="text" class="wpuxss-eml-parent_item" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Search','eml') . '</label><input type="text" class="wpuxss-eml-search_items" name="" value="" /></li>';
                                    $html .= '</ul>';
                                    $html .= '</div>';
                                    
                                    $html .= '<div class="wpuxss-eml-settings-edit">';
                                    $html .= '<h4>' . __('Settings','eml') . '</h4>';
                                    $html .= '<ul>';
                                    $html .= '<li><label>' . __('Taxonomy Name','eml') . '</label><input type="text" class="wpuxss-eml-taxonomy-name" name="" value="" disabled="disabled" /></li>';
                                    $html .= '<li><label>' . __('Hierarchical','eml') . '</label><input type="checkbox" class="wpuxss-eml-hierarchical" name="" value="1" checked="checked" /></li>';
                                    $html .= '<li><label>' . __('Column in List View','eml') . '</label><input class="wpuxss-eml-show_admin_column" type="checkbox" name="" value="1" /></li>';
                                    $html .= '<li><label>' . __('Filter in List View','eml') . '</label><input class="wpuxss-eml-admin_filter" type="checkbox"  name="" value="1" /></li>';
                                    $html .= '<li><label>' . __('Filter in Grid View / Media Popup','eml') . '</label><input class="wpuxss-eml-media_uploader_filter" type="checkbox" name="" value="1" /></li>';
                                    $html .= '<li><label>' . __('Edit in Media Popup','eml') . '</label><input class="wpuxss-eml-media_popup_taxonomy_edit" type="checkbox" name="" value="1" /></li>';
                                    $html .= '<li><label>' . __('Show in Nav Menu','eml') . '</label><input type="checkbox" class="wpuxss-eml-show_in_nav_menus" name="" value="1" /></li>';
                                    $html .= '<li><label>' . __('Remember terms order (sort)','eml') . '</label><input type="checkbox" class="wpuxss-eml-sort" name="" value="1" /></li>';
                                    $html .= '<li><label>' . __('Rewrite Slug','eml') . '</label><input type="text" class="wpuxss-eml-slug" name="" value="" /></li>';
                                    $html .= '<li><label>' . __('Slug with Front','eml') . '</label><input type="checkbox" class="wpuxss-eml-rewrite-with-front" name="" value="1" checked="checked" /></li>';
                                    $html .= '</ul>';	
                                    $html .= '</div>';
                                        
                                    $html .= '</div>';
                                    $html .= '</li>';
                                    
                                    if ( !empty($html) )
                                    {
    ?>                                  <ul class="wpuxss-eml-settings-list wpuxss-eml-media-taxonomy-list">
                                            <?php echo $html; ?>
                                        </ul>
                                        <div class="wpuxss-eml-button-container-right"><a class="add-new-h2 wpuxss-eml-button-create-taxonomy" href="javascript:;">+ <?php _e('Add New Taxonomy','eml'); ?></a></div>
    <?php                           }
                                    
                                    submit_button(); 
    ?>                               
                                </div>
    
                            </div>
                            
                            <div class="postbox">
                                
                                <h3 class="hndle"><?php _e('Non-Media Taxonomies','eml'); ?></h3>
                                
                                <div class="inside">
                                
                                    <p><?php _e('Assign following taxonomies to Media Library:','eml'); ?></p>
                                    
    <?php                           $unuse = array('revision','nav_menu_item','attachment');
                                    foreach ( get_post_types(array(),'object') as $post_type ) 
                                    {
                                        if ( !in_array($post_type->name,$unuse) )
                                        {
                                            $taxonomies = get_object_taxonomies($post_type->name,'object');
                                            if ( !empty($taxonomies) )
                                            {
                                                $html = '';
                                                foreach ( $taxonomies as $taxonomy ) 
                                                {
                                                    if ( $taxonomy->name != 'post_format' )
                                                    {														
                                                        $html .= '<li>';
                                                        $html .= '<input class="wpuxss-eml-assigned" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][assigned]" type="checkbox" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['assigned'], false ) . ' title="' . __('Assign Taxonomy','eml') . '" />';
                                                        $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][eml_media]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['eml_media'] . '" />';
                                                        $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][show_admin_column]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['show_admin_column'] . '" />';
                                                        $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][show_in_nav_menus]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['show_in_nav_menus'] . '" />';
                                                        $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][hierarchical]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['hierarchical'] . '" />';
                                                        $html .= '<input name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][sort]" type="hidden" value="' . $wpuxss_eml_taxonomies[$taxonomy->name]['sort'] . '" />';													
                                                        $html .= ' <label>' . $taxonomy->label . '</label>';
                                                        $html .= '<a class="wpuxss-eml-button-edit" title="' . __('Edit Taxonomy','eml') . '" href="javascript:;">' . __('Edit','eml') . ' &darr;</a>';
                                                        $html .= '<div class="wpuxss-eml-taxonomy-edit" style="display:none;">';
                                                
                                                        $html .= '<h4>' . __('Settings','eml') . '</h4>';
                                                        $html .= '<ul>';
                                                        $html .= '<li><label>' . __('Filter in List View','eml') . '</label><input type="checkbox" class="wpuxss-eml-admin_filter" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][admin_filter]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['admin_filter'], false ) . ' /></li>';
                                                        $html .= '<li><label>' . __('Filter in Grid View / Media Popup','eml') . '</label><input type="checkbox" class="wpuxss-eml-media_uploader_filter" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][media_uploader_filter]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['media_uploader_filter'], false ) . ' /></li>';
                                                        $html .= '<li><label>' . __('Edit in Media Popup','eml') . '</label><input type="checkbox" class="wpuxss-eml-media_popup_taxonomy_edit" name="wpuxss_eml_taxonomies[' . $taxonomy->name . '][media_popup_taxonomy_edit]" value="1" ' . checked( 1, $wpuxss_eml_taxonomies[$taxonomy->name]['media_popup_taxonomy_edit'], false ) . ' /></li>';
                                                        $html .= '</ul>';											
                                                        
                                                        $html .= '</div>';
                                                        $html .= '</li>';
                                                        
                                                    } 
                                                }
                                                if ( !empty($html) )
                                                {
    ?>                                              <h4><?php echo $post_type->label; ?></h4>
                                                    <ul class="wpuxss-eml-settings-list wpuxss-eml-non-media-taxonomy-list">
                                                        <?php echo $html; ?>
                                                    </ul>
    <?php                                       }
                                            }
                                        }
                                    }
                                    
                                    submit_button(); 
    ?>                          
                                </div>
    
                            </div>
                            
                            <h2><?php _e('Options','eml'); ?></h2>
                            
                            <div class="postbox">
                                
                                <div class="inside">
                            
                                    <?php $wpuxss_eml_tax_options = get_option( 'wpuxss_eml_tax_options' ); ?>
                                    
                                    <table class="form-table">
                                        <tr>
                                            <th scope="row"><?php _e('Taxonomy archive pages','eml'); ?></th>
                                            <td> 
                                                <fieldset>
                                                    <legend class="screen-reader-text"><span><?php _e('Taxonomy archive pages','eml'); ?></span></legend>
                                                    <label for="wpuxss_eml_tax_options[tax_archives]"><input name="wpuxss_eml_tax_options[tax_archives]" type="hidden" value="0" /><input name="wpuxss_eml_tax_options[tax_archives]" type="checkbox" value="1" <?php checked( true, $wpuxss_eml_tax_options['tax_archives'], true ); ?> /> <?php _e('Turn on media taxonomy archive pages on the front-end','eml'); ?></label>
                                                    <p class="description"><?php _e( 'Re-save your permalink settings after this option change to make it work.', 'eml' ); ?></p>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th scope="row"><?php _e('Assign all like hierarchical','eml'); ?></th>
                                            <td> 
                                                <fieldset>
                                                    <legend class="screen-reader-text"><span><?php _e('Show non-hierarchical taxonomies like hierarchical in Grid View / Media Popup','eml'); ?></span></legend>
                                                    <label for="wpuxss_eml_tax_options[edit_all_as_hierarchical]"><input name="wpuxss_eml_tax_options[edit_all_as_hierarchical]" type="hidden" value="0" /><input name="wpuxss_eml_tax_options[edit_all_as_hierarchical]" type="checkbox" value="1" <?php checked( true, $wpuxss_eml_tax_options['edit_all_as_hierarchical'], true ); ?> /> <?php _e('Show non-hierarchical taxonomies like hierarchical in Grid View / Media Popup','eml'); ?></label>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th scope="row"><?php _e('Force filters','eml'); ?></th>
                                            <td> 
                                                <fieldset>
                                                    <legend class="screen-reader-text"><span><?php _e('Force filters','eml'); ?></span></legend>
                                                    <label for="wpuxss_eml_tax_options[force_filters]"><input name="wpuxss_eml_tax_options[force_filters]" type="hidden" value="0" /><input name="wpuxss_eml_tax_options[force_filters]" type="checkbox" value="1" <?php checked( true, $wpuxss_eml_tax_options['force_filters'], true ); ?> /> <?php _e('Show media filters for ANY Media Popup.','eml'); ?></label>
                                                    <p class="description"><?php _e( 'May be useful for those who need forcing filters for third-party plugins or themes.', 'eml' ); ?></p>
                                                </fieldset>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <?php submit_button(); ?>
                                
                                </div>
                            
                            </div>
    
                            <?php do_action( 'wpuxss_eml_extend_taxonomies_option_page' ); ?>
                            
                        </form>
                        
                    </div>
                    
                    <div id="postbox-container-1" class="postbox-container">
                    
                        <?php wpuxss_eml_print_credits(); ?>
                    
                    </div>
                
                </div>
                
            </div>
            
        </div>
    
        <?php
    }
}




/**
 *  wpuxss_eml_print_mimetypes_options
 *
 *  @type     callback function
 *  @since    1.0
 *  @created  28/09/13
 */

if( ! function_exists('wpuxss_eml_print_mimetypes_options') ) {
    
    function wpuxss_eml_print_mimetypes_options() {
        
        if (!current_user_can('manage_options'))   
            wp_die( __('You do not have sufficient permissions to access this page.','eml') );    
    
        $wpuxss_eml_mimes = get_option('wpuxss_eml_mimes');
        $wpuxss_eml_mimes_backup = get_option('wpuxss_eml_mimes_backup');
        ?>
        
        <div id="wpuxss-eml-global-options-wrap" class="wrap">    
            <?php screen_icon('options-general'); ?>
            <h2>
                <?php _e('MIME Types','eml'); ?>
                <a class="add-new-h2 wpuxss-eml-button-create-mime" href="javascript:;">+ <?php _e('Add New MIME Type','eml'); ?></a>
            </h2>
            
            <?php settings_errors(); ?>
            
            <div id="poststuff">
            
                <div id="post-body" class="metabox-holder columns-2">
    
                    <div id="postbox-container-2" class="postbox-container">
                    
                        <form method="post" action="options.php" id="wpuxss-eml-form-mimetypes">
        
                            <?php settings_fields( 'wpuxss_eml_mimes' ); ?>
    
                            <table class="wpuxss-eml-mime-type-list wp-list-table widefat" cellspacing="0">
                                <thead>
                                <tr>
                                    <th scope="col" class="manage-column wpuxss-eml-column-extension"><?php _e('Extension','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-mime"><?php _e('MIME Type','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-singular"><?php _e('Singular Label','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-plural"><?php _e('Plural Label','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-filter"><?php _e('Add Filter','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-upload"><?php _e('Allow Upload','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-delete"></th>
                                </tr>
                                </thead>
                        
                                
                                <tbody>
               
    <?php                       $allowed_mimes = get_allowed_mime_types();
                                $all_mimes = wp_get_mime_types();
                                ksort( $all_mimes, SORT_STRING );
    
                                foreach ( $all_mimes as $type => $mime )
                                {
                                    if ( isset($wpuxss_eml_mimes[$type]) ) 
                                    {
                                        $label = '<code>'. str_replace( '|', '</code>, <code>', $type ) .'</code>';
                                        
                                        $allowed = false;
                                        if ( array_key_exists( $type,$allowed_mimes ) )
                                            $allowed = true;
    ?>                                   
                                        <tr>
                                        <td id="<?php echo $type; ?>"><?php echo $label; ?></td>
                                        <td><code><?php echo $mime; ?></code><input type="hidden" class="wpuxss-eml-mime" name="wpuxss_eml_mimes[<?php echo $type; ?>][mime]" value="<?php echo $wpuxss_eml_mimes[$type]['mime']; ?>" /></td>
                                        <td><input type="text" name="wpuxss_eml_mimes[<?php echo $type; ?>][singular]" value="<?php echo esc_html($wpuxss_eml_mimes[$type]['singular']); ?>" /></td>
                                        <td><input type="text" name="wpuxss_eml_mimes[<?php echo $type; ?>][plural]" value="<?php echo esc_html($wpuxss_eml_mimes[$type]['plural']); ?>" /></td>
                                        <td class="checkbox_td"><input type="checkbox" name="wpuxss_eml_mimes[<?php echo $type; ?>][filter]" title="<?php _e('Add Filter','eml'); ?>" value="1" <?php checked(1, $wpuxss_eml_mimes[$type]['filter']); ?> /></td>
                                        <td class="checkbox_td"><input type="checkbox" name="wpuxss_eml_mimes[<?php echo $type; ?>][upload]" title="<?php _e('Allow Upload','eml'); ?>" value="1" <?php checked(true, $allowed); ?> /></td>
                                        <td><a class="wpuxss-eml-button-remove" title="Delete MIME Type" href="javascript:;">&ndash;</a></td>
                                        </tr>
                                        
    <?php                           }
                                }
    ?>                          
                                <tr class="wpuxss-eml-clone" style="display:none;">
                                    <td><input type="text" class="wpuxss-eml-type" placeholder="jpg|jpeg|jpe" /></td>
                                    <td><input type="text" class="wpuxss-eml-mime" placeholder="image/jpeg" /></td>
                                    <td><input type="text" class="wpuxss-eml-singular" placeholder="Image" /></td>
                                    <td><input type="text" class="wpuxss-eml-plural" placeholder="Images" /></td>
                                    <td class="checkbox_td"><input type="checkbox" class="wpuxss-eml-filter" title="<?php _e('Add Filter','eml'); ?>" value="1" /></td>
                                    <td class="checkbox_td"><input type="checkbox" class="wpuxss-eml-upload" title="<?php _e('Allow Upload','eml'); ?>" value="1" /></td>
                                    <td><a class="wpuxss-eml-button-remove" title="<?php _e('Delete MIME Type','eml'); ?>" href="javascript:;">&ndash;</a></td>
                                </tr>
                                
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col" class="manage-column wpuxss-eml-column-extension"><?php _e('Extension','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-mime"><?php _e('MIME Type','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-singular"><?php _e('Singular Label','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-plural"><?php _e('Plural Label','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-filter"><?php _e('Add Filter','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-upload"><?php _e('Allow Upload','eml'); ?></th>
                                    <th scope="col" class="manage-column wpuxss-eml-column-delete"></th>
                                </tr>
                                </tfoot>
                            </table>
                            
                            <?php submit_button(__('Restore default MIME Types','eml'),'secondary','wpuxss_eml_restore_mimes_backup'); ?>
                                                 
                            <?php submit_button(); ?>
        
                        </form>
                        
                    </div>
                    
                    <div id="postbox-container-1" class="postbox-container">
                    
                        <?php wpuxss_eml_print_credits(); ?>
                    
                    </div>
                
                </div>
                
            </div>
            
        </div>
     
        <?php
    }
}





/**
 *  wpuxss_eml_print_credits
 *
 *  @since    1.0
 *  @created  28/09/13
 */

if( ! function_exists('wpuxss_eml_print_credits') ) {
        
    function wpuxss_eml_print_credits() {
        
        global $wpuxss_eml_version; ?>
            
        <div class="postbox" id="wpuxss-credits">
        
            <h3 class="hndle">Enhanced Media Library <?php echo $wpuxss_eml_version; ?></h3>
        
            <div class="inside">
        
                <h4>Changelog</h4>
                <p>What's new in <a href="http://wordpress.org/plugins/enhanced-media-library/changelog/">version <?php echo $wpuxss_eml_version; ?></a>.</p>
                
                <h4>Enhanced Media Library PRO</h4>
                <p>More features under the hood <a href="http://www.wpuxsolutions.com/plugins/enhanced-media-library/">www.wpuxsolutions.com</a>.</p>
                
                <h4>Support</h4>
                <p>Feel free to ask for help on <a href="http://www.wpuxsolutions.com/support/">www.wpuxsolutions.com</a>. Support is free for both versions of the plugin.</p>
                
                <h4>Plugin rating</h4>
                <p>Please <a href="http://wordpress.org/support/view/plugin-reviews/enhanced-media-library">vote for the plugin</a>. Thanks!</p>
                
                <h4>Other plugins you may find useful</h4>
                <ul>
                    <li><a href="http://wordpress.org/plugins/toolbar-publish-button/">Toolbar Publish Button</a></li>
                </ul>
        
                <div class="author">
                    <span><a href="http://www.wpuxsolutions.com/">wpUXsolutions</a> by <a class="logo-webbistro" href="http://twitter.com/webbistro"><span class="icon-webbistro">@</span>webbistro</a></span>
                </div>
        
            </div>
        
        </div>
        
        <?php
    }
}

?>
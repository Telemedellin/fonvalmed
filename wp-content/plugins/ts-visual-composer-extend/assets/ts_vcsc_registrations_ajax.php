<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    
    // Ajax Load Events
    // ----------------
    add_action('wp_ajax_nopriv_ajax_ts_timeline',	        array($this, 	'TS_VCSC_AjaxCallbackRoutine_Timeline'));
    add_action('wp_ajax_ajax_ts_timeline', 			        array($this, 	'TS_VCSC_AjaxCallbackRoutine_Timeline'));
    
    // Ajax Callback Function
    // ----------------------
    function TS_VCSC_AjaxCallbackRoutine_Timeline() {
            global $TS_CHANGELOG_ORGANIZER;
            $queryVars 										= json_decode(stripslashes($_GET['queryvars']), true);
            $currentProduct 								= (isset($_GET['product'])) ? $_GET['product'] : 1;
            $currentOrder 									= (isset($_GET['order'])) ? $_GET['order'] : 'desc';
            $currentOrderBy 								= (isset($_GET['orderby'])) ? $_GET['orderby'] : 'version';
            $currentProduct 								= (isset($_GET['product'])) ? $_GET['product'] : 1;
            $currentLimit 									= (isset($_GET['limit'])) ? $_GET['limit'] : 0;
            $currentTotal 									= (isset($_GET['total'])) ? $_GET['total'] : 0;
            $currentPage 									= (isset($_GET['page'])) ? $_GET['page'] : 1;
            $currentStart 									= (isset($_GET['start'])) ? $_GET['start'] : 1;
            $currentFinish 									= (isset($_GET['finish'])) ? $_GET['finish'] : 6;
            
            // Default Attributes
            $toggleMake										= (isset($_GET['toggles'])) ? $_GET['toggles'] : 'true';
            $toggleStatus									= (isset($_GET['status'])) ? $_GET['status'] : 'first';
            $showDate										= (isset($_GET['showdate'])) ? $_GET['showdate'] : 'true';
            $showMessage									= (isset($_GET['showmessage'])) ? $_GET['showmessage'] : 'true';
            $showIcon										= (isset($_GET['showicon'])) ? $_GET['showicon'] : 'true';
            $showHighlights									= (isset($_GET['showhighlights'])) ? $_GET['showhighlights'] : 'true';
            $showOther										= (isset($_GET['showother'])) ? $_GET['showother'] : 'true';
            $iconPosition									= (isset($_GET['iconposition'])) ? $_GET['iconposition'] : 'left';
            $versionFirst									= (isset($_GET['versionfirst'])) ? $_GET['versionfirst'] : 'true';
            
            // Retrieve Product Post Main Content
            $changelog_array						= array();
            $category_fields 	                	= array();		
            $args = array(
                    'no_found_rows' 					=> 1,
                    'ignore_sticky_posts' 				=> 1,
                    'posts_per_page' 					=> -1,
                    'post_type' 						=> 'ts_changelogs',
                    'post_status' 						=> 'publish',
                    'orderby' 							=> 'title',
                    'order' 							=> 'ASC',
                    'tax_query' => array(
                            array(
                                    'taxonomy' 		=> 'ts_changelogs_category',
                                    'field'    		=> 'slug',
                                    'terms' 		=> $currentProduct
                            ),
                    ),
            );
            
            // Loop Posts and Retrieve Data
            $changelog_query = new WP_Query($args);
            if ($changelog_query->have_posts()) {
                    foreach($changelog_query->posts as $p) {
                            $changelog_title				= get_post_meta($p->ID , 'ts_changelog_basic_title' , true);
                            $changelog_version				= get_post_meta($p->ID , 'ts_changelog_basic_version' , true);
                            $changelog_date					= get_post_meta($p->ID , 'ts_changelog_basic_date' , true);
                            if (is_string($changelog_title)) 	{$changelog_title = $changelog_title;} else {$changelog_title = "N/A";}
                            if (is_string($changelog_version)) 	{$changelog_version = $changelog_version;} else {$changelog_version = "N/A";}
                            if (is_string($changelog_date)) 	{$changelog_date = $changelog_date;} else {$changelog_date = "N/A";}
                            $changelog_data = array(
                                    'postauthor'				=> $p->post_author,
                                    'postname'					=> $p->post_name,
                                    'posttitle'					=> $p->post_title,
                                    'postid'					=> $p->ID,
                                    'postdate'					=> $p->post_date,
                                    'title'						=> ((isset($changelog_title) && ($changelog_title != '')) ? trim($changelog_title) : ""),
                                    'version'					=> ((isset($changelog_version) && ($changelog_version != '')) ? trim($changelog_version) : "N/A"),
                                    'date'						=> ((isset($changelog_date) && ($changelog_date != '')) ? strtotime(trim($changelog_date)) : "N/A"),
                            );
                            $changelog_array[] 				= $changelog_data;
                    }
            }
            wp_reset_postdata();
            
            // Sort Array by pre-defined Key and Order
            $changelog_sort 						= TS_Changelog_SortMultiArray($changelog_array, $currentOrderBy, $currentOrder, TRUE, FALSE);
            
            // Retrieve Language Settings
            $Changelog_String_Show					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['OpenAll']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['OpenAll'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['OpenAll']);
            $Changelog_String_Hide					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['CloseAll']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['CloseAll'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['CloseAll']);
            $Changelog_Search_Logs					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SearchLogs']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SearchLogs'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['SearchLogs']);
            $Changelog_Search_Results				= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SearchResults']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SearchResults'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['SearchResults']);
            $Changelog_Search_Placeholder			= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SearchPlaceholder']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SearchPlaceholder'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['SearchPlaceholder']);
            $Changelog_Sort_Logs					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SortLogs']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SortLogs'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['SortLogs']);
            $Changelog_Sort_DESC					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SortDescending']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SortDescending'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['SortDescending']);
            $Changelog_Sort_ASC						= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SortAscending']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['SortAscending'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['SortAscending']);
            $Changelog_Log_Version					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['ChangelogVersion']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['ChangelogVersion'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['ChangelogVersion']);
            $Changelog_Log_Date						= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['ChangelogDate']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['ChangelogDate'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['ChangelogDate']);
            $Changelog_Log_Title					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['ChangelogTitle']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['ChangelogTitle'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['ChangelogTitle']);
            $Changelog_Post_Date					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostDate']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostDate'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['PostDate']);
            $Changelog_Post_Name					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostName']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostName'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['PostName']);
            $Changelog_Post_Title					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostTitle']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostTitle'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['PostTitle']);
            $Changelog_Post_Author					= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostAuthor']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostAuthor'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['PostAuthor']);
            $Changelog_Post_ID						= (isset($TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostID']) ? $TS_CHANGELOG_ORGANIZER->TS_Changelog_Retrieve_Language_Strings['PostID'] : $TS_CHANGELOG_ORGANIZER->TS_Changelog_Defaults_Language_Strings['PostID']);
            
            $Changelog_Count						= 0;
            $Changelog_Content						= '';			
            if ($toggleStatus == 'closed') {
                    $Changelog_Toggle					= 'false';
            } else if ($toggleStatus == 'open') {
                    $Changelog_Toggle					= 'true';
            } else if ($toggleStatus == 'first') {
                    $Changelog_Toggle					= 'false';
            }			
            if (($currentFinish > $currentLimit) && ($currentLimit > 0)) {
                    $currentFinish						= $currentLimit;
            }
            if ($currentFinish > $currentTotal) {
                    $currentFinish						= $currentTotal;
            }
            
            // Create Output
            for ($index = ($currentStart - 1); $index < $currentFinish; ++$index) {
                    $Changelog_Count++;
                    if (($currentLimit == 0) || ($currentLimit > 0 && $Changelog_Count <= $currentLimit)) {
                            $Changelog_PostAuthor	= $changelog_sort[$index]['postauthor'];
                            $Changelog_PostName 	= $changelog_sort[$index]['postname'];
                            $Changelog_PostID 		= $changelog_sort[$index]['postid'];
                            $Changelog_PostDate 	= $changelog_sort[$index]['postdate'];
                            $Changelog_PostTitle 	= $changelog_sort[$index]['posttitle'];
                            $Changelog_Title 		= $changelog_sort[$index]['title'];
                            $Changelog_Version 		= $changelog_sort[$index]['version'];
                            $shortcode = '[TS_Changelog_Single changelog="' . $Changelog_PostID . '" as_widget="false" version_first="true" toggle_make="' . $toggleMake . '" toggle_open="' . $Changelog_Toggle . '" show_date="' . $showDate . '" show_message="' . $showMessage . '" show_icon="' . $showIcon . '" icon_position="' . $iconPosition . '" show_highlights="' . $showHighlights . '" show_other="' . $showOther . '" margin_top="30" margin_bottom="30"]';
                            $Changelog_Content .= do_shortcode($shortcode);
                    } else {
                            break;
                    }
            }			
            echo $Changelog_Content;
            
            die();
    }
?>
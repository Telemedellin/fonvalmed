<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	if (function_exists('vc_add_param')) {
		$TS_VCSC_RowToggleLimits			= get_option('ts_vcsc_extend_settings_rowVisibilityLimits', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Row_Toggle_Defaults);
		$TS_VCSC_RowOffsetSettings			= get_option('ts_vcsc_extend_settings_additionsOffsets', 	0);
		// ----------------------
		// Row Setting Parameters
		// ----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "messenger1",
			"color"							=> "#D10000",
			"weight"						=> "bold",
			"size"							=> "14",
			"value"							=> "",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> -10,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_1",
			"value"             			=> "",
			"seperator"             		=> "Background Settings",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Effects", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_bg_effects",
			"value" 						=> array(
				__( "None", "ts_visual_composer_extend")					=> "",
				__( "Simple Image", "ts_visual_composer_extend")			=> "image",
				__( "Fixed Image", "ts_visual_composer_extend")				=> "fixed",
				__( "Image Slideshow", "ts_visual_composer_extend")			=> "slideshow",
				__( "Parallax Image", "ts_visual_composer_extend")			=> "parallax",
				__( "Automove Image", "ts_visual_composer_extend")			=> "automove",
				__( "Movement Image", "ts_visual_composer_extend")			=> "movement",
				__( "Single Color", "ts_visual_composer_extend")			=> "single",
				__( "Gradient Color", "ts_visual_composer_extend")			=> "gradient",
				__( "Particlify Animation", "ts_visual_composer_extend")	=> "particles",
				__( "Trianglify Pattern", "ts_visual_composer_extend")		=> "triangle",
				__( "YouTube Video I", "ts_visual_composer_extend")			=> "youtube",
				__( "YouTube Video II", "ts_visual_composer_extend")		=> "youtubemb",
				__( "Selfhosted Video I", "ts_visual_composer_extend")		=> "video",
				__( "Selfhosted Video II", "ts_visual_composer_extend")		=> "videomb",
			),
			"admin_label" 					=> true,
			"description" 					=> __("Select the effect you want to apply to the row background.", "ts_visual_composer_extend"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// ---------------------------
		// Full Screen Height Settings
		// ---------------------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Full Screen Height", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_screen_height",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to set this row to full screen height (EXPERIMENTAL).", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Height Offset", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_screen_offset",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "500",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define an optional height offset to account for menu bars or other top fixed elements.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_screen_height",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -------------------
		// Min Height Settings
		// -------------------
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Minimum Height", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_min_height",
			"value"                 		=> "100",
			"min"                   		=> "0",
			"max"                   		=> "2048",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the minimum height for the row; use only if your theme doesn't provide a similar option and if there is no row content.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_screen_height",
				"value" 	=> "false"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -------------------
		// Full Width Settings
		// -------------------
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorFullWidthInternal == "false") {
			$TS_VCSC_FullWidthRowMessage	= __( "Define the number of Parent Containers the Background should attempt to break away from.", "ts_visual_composer_extend" );
		} else {
			$TS_VCSC_FullWidthRowMessage	= __( "Define the number of Parent Containers the Background should attempt to break away from; Do NOT use in conjunction with VC's native Full Width setting.", "ts_visual_composer_extend" );
		}
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Full Width Breakouts", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_break_parents",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "99",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> $TS_VCSC_FullWidthRowMessage,
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -------
		// Z-Index
		// -------
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Z-Index for Background", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_zindex",
			"value"                 		=> "0",
			"min"                   		=> "-100",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define the z-Index for the background; use only if theme requires an adjustment!", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -------------------
		// Background Settings
		// -------------------		
		vc_add_param("vc_row", array(
			"type"                  		=> "dropdown",
			"heading"               		=> __( "Background Image Retrieval", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_retrieve",
			"width"                 		=> 150,
			"value"                 		=> array(
				__( 'Single Image', "ts_visual_composer_extend" )			=> "single",
				__( 'Random Image', "ts_visual_composer_extend" )			=> "random",
			),
			"description"           		=> __( "Select whether you want to always show the same image or a random one from an image group.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "parallax", "automove", "movement")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Background Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_row_bg_image",
			"value"							=> "",
			"description"					=> __( "Select the background image for your row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_retrieve", "value" => 'single'),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "attach_images",
			"heading"               		=> __( "Background Images Group", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_group",
			"value"                 		=> "",
			"description"       			=> __( "Select the background images for your row; will randomly select from group upon page load.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_retrieve", "value" => 'random'),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "attach_images",
			"heading"               		=> __( "Select Images", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_slide_images",
			"value"                 		=> "",
			"description"       			=> __( "Select the images to be used for the background slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "dropdown",
			"heading"               		=> __( "Background Image Source", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_source",
			"width"                 		=> 150,
			"value"                 		=> array(
				__( 'Full Size Image', "ts_visual_composer_extend" )			=> "full",
				__( 'Large Size Image', "ts_visual_composer_extend" )			=> "large",
				__( 'Medium Size Image', "ts_visual_composer_extend" )			=> "medium",
			),
			"description"           		=> __( "Select which image size based on WordPress settings should be used for the lightbox image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -------------------
		// Background Position
		// -------------------
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_position",
			"value" 						=> array(
				__( "Center Center", "ts_visual_composer_extend" ) 				=> "center",
				__( "Center Top", "ts_visual_composer_extend" )					=> "top",
				__( "Center Bottom", "ts_visual_composer_extend" ) 				=> "bottom",
				__( "Left Top", "ts_visual_composer_extend" ) 					=> "left top",
				__( "Left Center", "ts_visual_composer_extend" ) 				=> "left center",
				__( "Left Bottom", "ts_visual_composer_extend" ) 				=> "left bottom",
				__( "Right Top", "ts_visual_composer_extend" ) 					=> "right top",
				__( "Right Center", "ts_visual_composer_extend" ) 				=> "right center",
				__( "Right Bottom", "ts_visual_composer_extend" ) 				=> "right bottom",
				__( "Custom Value", "ts_visual_composer_extend" ) 				=> "custom",
			),
			"description" 					=> __("Select the position of the background image; will have most effect on smaller screens."),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend" ),
		));		
        vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "Custom Image Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_position_custom",
			"value"             			=> "",
			"description"       			=> __( "Enter the custom position of the image, using either px or % (i.e. '25% 15%').", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_position", "value" => array("custom")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_size_standard",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"description" 					=> __(""),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_size_parallax",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "100%", "ts_visual_composer_extend" )			=> "100%",
				__( "110%", "ts_visual_composer_extend" )			=> "110%",
				__( "120%", "ts_visual_composer_extend" )			=> "120%",
				__( "130%", "ts_visual_composer_extend" )			=> "130%",
				__( "140%", "ts_visual_composer_extend" )			=> "140%",
				__( "150%", "ts_visual_composer_extend" )			=> "150%",
				__( "160%", "ts_visual_composer_extend" )			=> "160%",
				__( "170%", "ts_visual_composer_extend" )			=> "170%",
				__( "180%", "ts_visual_composer_extend" )			=> "180%",
				__( "190%", "ts_visual_composer_extend" )			=> "190%",
				__( "200%", "ts_visual_composer_extend" )			=> "200%",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"description" 					=> __(""),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("automove", "movement")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Repeat", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_repeat",
			"value" 						=> array(
				__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
				__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
				__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
				__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
			),
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "parallax")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// ------------------
		// Slideshow Settings
		// ------------------
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Shuffle Images", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_shuffle",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"           		=> __( "Switch the toggle to shuffle the images for a random order.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("slideshow")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Show Controls", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_controls",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"           		=> __( "Switch the toggle to show previous / next controls for the background slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("slideshow")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Use AutoPlay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_auto",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"           		=> __( "Switch the toggle to use an autoplay feature for the background slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("slideshow")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "nouislider",
			"heading"           			=> __( "Transition Delay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_delay",
			"value"             			=> "5000",
			"min"               			=> "2000",
			"max"               			=> "20000",
			"step"              			=> "100",
			"unit"              			=> 'ms',
			"description"       			=> __( "Select the delay between each slide transition.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_slide_auto",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Show Progress Bar", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_bar",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"           		=> __( "Switch the toggle to show a progressbar for the delay timer.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_slide_auto",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "Transition Type", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_transition",
			"width"             			=> 300,
			"value"             			=> array(
				__( "Random", "ts_visual_composer_extend" )							=> "random",
				__( "Fade 1", "ts_visual_composer_extend" )							=> "fade",
				__( "Fade 2", "ts_visual_composer_extend" )							=> "fade2",
				__( "Blur 1", "ts_visual_composer_extend" )							=> "blur",
				__( "Blur 2", "ts_visual_composer_extend" )							=> "blur2",						
				__( "Flash 1", "ts_visual_composer_extend" )						=> "flash",
				__( "Flash 2", "ts_visual_composer_extend" )						=> "flash2",
				__( "Negative 1", "ts_visual_composer_extend" )						=> "negative",
				__( "Negative 2", "ts_visual_composer_extend" )						=> "negative2",						
				__( "Burn 1", "ts_visual_composer_extend" )							=> "burn",
				__( "Burn 2", "ts_visual_composer_extend" )							=> "burn2",
				__( "Slide Left 1", "ts_visual_composer_extend" )					=> "slideLeft",
				__( "Slide Left 2", "ts_visual_composer_extend" )					=> "slideLeft2",
				__( "Slide Right 1", "ts_visual_composer_extend" )					=> "slideRight",
				__( "Slide Right 2", "ts_visual_composer_extend" )					=> "slideRight2",						
				__( "Slide Up 1", "ts_visual_composer_extend" )						=> "slideUp",
				__( "Slide Up 2", "ts_visual_composer_extend" )						=> "slideUp2",
				__( "Slide Down 1", "ts_visual_composer_extend" )					=> "slideDown",
				__( "Slide Down 2", "ts_visual_composer_extend" )					=> "slideDown2",						
				__( "Zoom In 1", "ts_visual_composer_extend" )						=> "zoomIn",
				__( "Zoom In 2", "ts_visual_composer_extend" )						=> "zoomIn2",
				__( "Zoom Out 1", "ts_visual_composer_extend" )						=> "zoomOut",
				__( "Zoom Out 2", "ts_visual_composer_extend" )						=> "zoomOut2",						
				__( "Swirl Left 1", "ts_visual_composer_extend" )					=> "swirlLeft",
				__( "Swirl Left 2", "ts_visual_composer_extend" )					=> "swirlLeft2",
				__( "Swirl Right 1", "ts_visual_composer_extend" )					=> "swirlRight",
				__( "Swirl Right 2", "ts_visual_composer_extend" )					=> "swirlRight2",
			),
			"description"           		=> __( "Select the effect type to be used to transition between each slide.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("slideshow")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "nouislider",
			"heading"           			=> __( "Transition Duration", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_switch",
			"value"             			=> "2000",
			"min"               			=> "100",
			"max"               			=> "4000",
			"step"              			=> "100",
			"unit"              			=> 'ms',
			"description"       			=> __( "Select the duration each slide transition should last.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("slideshow")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "Horizontal Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "slide_halign",
			"width"             			=> 300,
			"value"             			=> array(
				__( "Center", "ts_visual_composer_extend" )							=> "center",
				__( "Top", "ts_visual_composer_extend" )							=> "top",
				__( "Right", "ts_visual_composer_extend" )							=> "right",
				__( "Bottom", "ts_visual_composer_extend" )							=> "bottom",
				__( "Left", "ts_visual_composer_extend" )							=> "left",
			),
			"description"           		=> __( "Select the horizontal position of each image in the slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("slideshow")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "Vertical Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "slide_valign",
			"width"             			=> 300,
			"value"             			=> array(
				__( "Center", "ts_visual_composer_extend" )							=> "center",
				__( "Top", "ts_visual_composer_extend" )							=> "top",
				__( "Right", "ts_visual_composer_extend" )							=> "right",
				__( "Bottom", "ts_visual_composer_extend" )							=> "bottom",
				__( "Left", "ts_visual_composer_extend" )							=> "left",
			),
			"description"           		=> __( "Select the vertical position of each image in the slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("slideshow")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		// -----------------
		// Parallax Settings
		// -----------------
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Parallax", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_parallax_type",
			"value" 						=> array(
				"Up"			=> "up",
				"Down"			=> "down",
				"Left"			=> "left",
				"Right"			=> "right",
			),
			"description" 					=> __("Select the parallax effect for your background image. You must have a background image to use this.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "parallax"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_alignment_v",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend" )				=> "center",
				__( "Left", "ts_visual_composer_extend" ) 				=> "left",
				__( "Right", "ts_visual_composer_extend" ) 				=> "right"
			),
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "ts_row_parallax_type",
				"value" 	=> array("up", "down")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_alignment_h",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend" )				=> "center",
				__( "Top", "ts_visual_composer_extend" ) 				=> "top",
				__( "Bottom", "ts_visual_composer_extend" ) 			=> "bottom",
			),
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "ts_row_parallax_type",
				"value" 	=> array("left", "right")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Parallax Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_parallax_speed",
			"value"                 		=> "20",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define the animation speed for the parallax effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "parallax"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "FadeIn Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_parallax_fade",
			"value"                 		=> "1000",
			"min"                   		=> "0",
			"max"                   		=> "5000",
			"step"                  		=> "100",
			"unit"                  		=> 'ms',
			"description"           		=> __( "Define the duration for the FadeIn effect for the parallax background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "parallax"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// ------------------
		// Auto Move Settings
		// ------------------
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Automove Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_automove_speed",
			"value"                 		=> "75",
			"min"                   		=> "0",
			"max"                   		=> "1000",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define the AutoMove Speed; the higher the value, the slower the movement.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "automove"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Automove Scroll", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_automove_scroll",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if the auto-moving image should scroll with the page or be fixed.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "automove"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Automove Path", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_automove_align",
			"value" 						=> array(
				"Horizontal"		=> "horizontal",
				"Vertical"			=> "vertical",
			),
			"description" 					=> __("Select the path the auto-moving image should be using.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "automove"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));	
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Moving Direction", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_automove_path_h",
			"value" 						=> array(
				"Left to Right"		=> "leftright",
				"Right to Left"		=> "rightleft",
			),
			"description" 					=> __("Select the path the auto-moving image should be using.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_row_automove_align",
				"value" 	=> "horizontal"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Moving Direction", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_automove_path_v",
			"value" 						=> array(
				"Top to Bottom"		=> "topbottom",
				"Bottom to Top"		=> "bottomtop",
			),
			"description" 					=> __("Select the path the auto-moving image should be using.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_row_automove_align",
				"value" 	=> "vertical"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -----------------
		// Movement Settings
		// -----------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Horizontal (X) Movement", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_movement_x_allow",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to have the background follow horizontal (x) movements.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "movement"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Horizontal Ratio", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_movement_x_ratio",
			"value"                 		=> "10",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the ratio in pixels by how much the background is allowed to move horizontally.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_movement_x_allow",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Vertical (Y) Movement", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_movement_y_allow",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to have the background follow vertical (y) movements.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "movement"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Vertical Ratio", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_movement_y_ratio",
			"value"                 		=> "10",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the ratio in pixels by how much the background is allowed to move vertically.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_movement_y_allow",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Move Content Elements", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_movement_content",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to move content elements with the background image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "movement"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -----------------------
		// Single Color Background
		// -----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Background Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "single_color",
			"value"            	 			=> "#ffffff",
			"description"       			=> __( "Define the background color for the row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> "single"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -------------------------
		// Gradient Color Background
		// -------------------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Use Advanced Gradient", "ts_visual_composer_extend" ),
			"param_name"        			=> "gradiant_advanced",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to use an advanced gradient generator with more options.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "gradient"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Gradient Angle", "ts_visual_composer_extend" ),
			"param_name"            		=> "gradient_angle",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "360",
			"step"                  		=> "1",
			"unit"                  		=> 'deg',
			"description"           		=> __( "Define the angle at which the gradient should spread.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Start Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "gradient_color_start",
			"value"            	 			=> "#cccccc",
			"description"       			=> __( "Define the start color for the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Gradient Start", "ts_visual_composer_extend" ),
			"param_name"            		=> "gradient_start_offset",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '%',
			"description"           		=> __( "Define the beginning section of the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "End Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "gradient_color_end",
			"value"            	 			=> "#cccccc",
			"description"       			=> __( "Define the end color for the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Gradient End", "ts_visual_composer_extend" ),
			"param_name"            		=> "gradient_end_offset",
			"value"                 		=> "100",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '%',
			"description"           		=> __( "Define the end section of the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "advanced_gradient",
			"class" 						=> "",
			"heading" 						=> __("Gradient Generator", "ts_visual_composer_extend"),						
			"param_name" 					=> "gradient_generator",
			"description" 					=> __('Use the controls above to create a custom gradient background for the row.', 'ts_visual_composer_extend'),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -----------------
		// Trianglify Canvas
		// -----------------
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Trianglify Render", "ts_visual_composer_extend"),
			"param_name" 					=> "trianglify_render",
			"value" 						=> array(
				__( "Canvas Element", "ts_visual_composer_extend")				=> "canvas",
				__( "Fixed Image", "ts_visual_composer_extend")					=> "fixed",
				__( "Scroll Image", "ts_visual_composer_extend")				=> "scroll",
			),
			"description" 					=> __("Select how the pattern for the Trianglify background should be rendered.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element"=> "ts_row_bg_effects", "value"=> "triangle"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Trianglify Pattern (X)", "ts_visual_composer_extend"),
			"param_name" 					=> "trianglify_colorsx",
			"value" 						=> array(
				__( "Random Pattern", "ts_visual_composer_extend")				=> "random",
				__( "Custom Pattern", "ts_visual_composer_extend")				=> "custom",
				__( "Yellow - Green", "ts_visual_composer_extend")				=> "YlGn",
				__( "Yellow - Green - Blue", "ts_visual_composer_extend")		=> "YlGnBu",
				__( "Blue - Green", "ts_visual_composer_extend")				=> "BuGn",
				__( "Green - Blue", "ts_visual_composer_extend")				=> "GnBu",
				__( "Purple - Blue - Green", "ts_visual_composer_extend")		=> "PuBuGn",
				__( "Purple - Blue", "ts_visual_composer_extend")				=> "PuBu",
				__( "Red - Purple", "ts_visual_composer_extend")				=> "RdPu",
				__( "Purple - Red", "ts_visual_composer_extend")				=> "PuRd",
				__( "Orange - Red", "ts_visual_composer_extend")				=> "OrRd",
				__( "Yellow - Orange - Red", "ts_visual_composer_extend")		=> "YlOrRd",
				__( "Yellow - Orange - Brown", "ts_visual_composer_extend")		=> "YlOrBr",
				__( "Purples", "ts_visual_composer_extend")						=> "Purples",
				__( "Blues", "ts_visual_composer_extend")						=> "Blues",
				__( "Greens", "ts_visual_composer_extend")						=> "Greens",
				__( "Oranges", "ts_visual_composer_extend")						=> "Oranges",
				__( "Reds", "ts_visual_composer_extend")						=> "Reds",
				__( "Greys", "ts_visual_composer_extend")						=> "Greys",
				__( "Orange - Purple", "ts_visual_composer_extend")				=> "PuOr",
				__( "Brown - Green", "ts_visual_composer_extend")				=> "BrBG",
				__( "Purple - Green", "ts_visual_composer_extend")				=> "PRGn",
				__( "Pink - Yellow - Green", "ts_visual_composer_extend")		=> "PiYG",
				__( "Red - Blue", "ts_visual_composer_extend")					=> "RdBu",
				__( "Red - Grey", "ts_visual_composer_extend")					=> "RdGy",
				__( "Red - Yellow - Blue", "ts_visual_composer_extend")			=> "RdYlBu",
				__( "Spectral", "ts_visual_composer_extend")					=> "Spectral",
				__( "Red - Yellow - Green", "ts_visual_composer_extend")		=> "RdYlGn",
				__( "Accent", "ts_visual_composer_extend")						=> "Accent",
				__( "Dark", "ts_visual_composer_extend")						=> "Dark2",
				__( "Paired", "ts_visual_composer_extend")						=> "Paired",
				__( "Pastel 1", "ts_visual_composer_extend")					=> "Pastel1",
				__( "Pastel 2", "ts_visual_composer_extend")					=> "Pastel2",
				__( "Set 1", "ts_visual_composer_extend")						=> "Set1",
				__( "Set 2", "ts_visual_composer_extend")						=> "Set2",
				__( "Set 3", "ts_visual_composer_extend")						=> "Set3",
			),
			"description" 					=> __("Select the horizontal pattern for the Trianglify background.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "advanced_gradient",
			"class" 						=> "",
			"heading" 						=> __("Trianglify Generator (X)", "ts_visual_composer_extend"),						
			"param_name" 					=> "trianglify_generatorx",
			"trianglify"					=> "true",
			"message_picker"				=> __("The exact position of the color stops does not matter, only their general order.", "ts_visual_composer_extend"),
			"label_picker"					=> __("Define Color Stops", "ts_visual_composer_extend"),	
			"description" 					=> __('Use the controls above to create a custom horizontal color set for the Trianglify background.', 'ts_visual_composer_extend'),
			"dependency" 					=> array("element" => "trianglify_colorsx", "value" => "custom"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Trianglify Pattern (Y)", "ts_visual_composer_extend"),
			"param_name" 					=> "trianglify_colorsy",
			"value" 						=> array(
				__( "Match Horizontal", "ts_visual_composer_extend")			=> "match_x",
				__( "Random Pattern", "ts_visual_composer_extend")				=> "random",
				__( "Custom Pattern", "ts_visual_composer_extend")				=> "custom",
				__( "Yellow - Green", "ts_visual_composer_extend")				=> "YlGn",
				__( "Yellow - Green - Blue", "ts_visual_composer_extend")		=> "YlGnBu",
				__( "Blue - Green", "ts_visual_composer_extend")				=> "BuGn",
				__( "Green - Blue", "ts_visual_composer_extend")				=> "GnBu",
				__( "Purple - Blue - Green", "ts_visual_composer_extend")		=> "PuBuGn",
				__( "Purple - Blue", "ts_visual_composer_extend")				=> "PuBu",
				__( "Red - Purple", "ts_visual_composer_extend")				=> "RdPu",
				__( "Purple - Red", "ts_visual_composer_extend")				=> "PuRd",
				__( "Orange - Red", "ts_visual_composer_extend")				=> "OrRd",
				__( "Yellow - Orange - Red", "ts_visual_composer_extend")		=> "YlOrRd",
				__( "Yellow - Orange - Brown", "ts_visual_composer_extend")		=> "YlOrBr",
				__( "Purples", "ts_visual_composer_extend")						=> "Purples",
				__( "Blues", "ts_visual_composer_extend")						=> "Blues",
				__( "Greens", "ts_visual_composer_extend")						=> "Greens",
				__( "Oranges", "ts_visual_composer_extend")						=> "Oranges",
				__( "Reds", "ts_visual_composer_extend")						=> "Reds",
				__( "Greys", "ts_visual_composer_extend")						=> "Greys",
				__( "Orange - Purple", "ts_visual_composer_extend")				=> "PuOr",
				__( "Brown - Green", "ts_visual_composer_extend")				=> "BrBG",
				__( "Purple - Green", "ts_visual_composer_extend")				=> "PRGn",
				__( "Pink - Yellow - Green", "ts_visual_composer_extend")		=> "PiYG",
				__( "Red - Blue", "ts_visual_composer_extend")					=> "RdBu",
				__( "Red - Grey", "ts_visual_composer_extend")					=> "RdGy",
				__( "Red - Yellow - Blue", "ts_visual_composer_extend")			=> "RdYlBu",
				__( "Spectral", "ts_visual_composer_extend")					=> "Spectral",
				__( "Red - Yellow - Green", "ts_visual_composer_extend")		=> "RdYlGn",
				__( "Accent", "ts_visual_composer_extend")						=> "Accent",
				__( "Dark", "ts_visual_composer_extend")						=> "Dark2",
				__( "Paired", "ts_visual_composer_extend")						=> "Paired",
				__( "Pastel 1", "ts_visual_composer_extend")					=> "Pastel1",
				__( "Pastel 2", "ts_visual_composer_extend")					=> "Pastel2",
				__( "Set 1", "ts_visual_composer_extend")						=> "Set1",
				__( "Set 2", "ts_visual_composer_extend")						=> "Set2",
				__( "Set 3", "ts_visual_composer_extend")						=> "Set3",
			),
			"description" 					=> __("Select the vertical pattern for the Trianglify background.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "advanced_gradient",
			"class" 						=> "",
			"heading" 						=> __("Trianglify Generator (Y)", "ts_visual_composer_extend"),						
			"param_name" 					=> "trianglify_generatory",
			"trianglify"					=> "true",
			"message_picker"				=> __("The exact position of the color stops does not matter, only their general order.", "ts_visual_composer_extend"),
			"label_picker"					=> __("Define Color Stops", "ts_visual_composer_extend"),	
			"description" 					=> __('Use the controls above to create a custom vertical color set for the Trianglify background.', 'ts_visual_composer_extend'),
			"dependency" 					=> array("element" => "trianglify_colorsy", "value" => "custom"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Trianglify Cellsize", "ts_visual_composer_extend" ),
			"param_name"            		=> "trianglify_cellsize",
			"value"                 		=> "75",
			"min"                   		=> "25",
			"max"                   		=> "150",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Specify the size of the mesh used to generate triangles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Trianglify Variance", "ts_visual_composer_extend" ),
			"param_name"            		=> "trianglify_variance",
			"value"                 		=> "0.75",
			"min"                   		=> "0",
			"max"                   		=> "1",
			"step"                  		=> "0.01",
			"decimals"						=> "2",
			"unit"                  		=> '',
			"description"           		=> __( "Specify the amount of randomness used when generating triangles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// --------------------
		// Particlify Animation
		// --------------------
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Number of Particles", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_count",
			"value"                 		=> "30",
			"min"                   		=> "2",
			"max"                   		=> "150",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> 'x',
			"description"           		=> __( "Specify the amount of particle elements; the more particles, the more the browser has work.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Particle Source", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_particles_shape_source",
			"value" 						=> array(
				__( "Built-In Shapes", "ts_visual_composer_extend")				=> "internal",
				__( "Custom Image", "ts_visual_composer_extend")				=> "external",
			),
			"description" 					=> __("Select the type of shape you want to use for the particles.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			'type' 							=> "checkbox",
			'heading' 						=> __( 'Particle Shapes', 'ts_visual_composer_extend' ),
			'param_name' 					=> 'ts_particles_shape_types',								
			'value' 						=> array(
				__( 'Circle', 'ts_visual_composer_extend' ) 			=> 'circle',
				__( 'Edge', 'ts_visual_composer_extend' ) 				=> 'edge',
				__( 'Triangle', 'ts_visual_composer_extend' ) 			=> 'triangle',
				__( 'Polygon', 'ts_visual_composer_extend' ) 			=> 'polygon',
				__( 'Star', 'ts_visual_composer_extend' ) 				=> 'star',
				//__( 'Image', 'ts_visual_composer_extend' ) 			=> 'image',
			),
			"std"							=> "circle",
			"default"						=> "circle",
			"description" 					=> __( 'Select the particle shapes you want to use; you need to select at least one or enable the particle link option to see any animations.', 'ts_visual_composer_extend' ),
			"dependency" 					=> array("element" => "ts_particles_shape_source", "value" => "internal"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Particle Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_particles_shape_image",
			"value"							=> "",
			"description"					=> __( "Select the image you want to use for the particles; image should have a transparent background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_shape_source", "value" => "external"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Maximum Particle Size", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_size_max",
			"value"                 		=> "10",
			"min"                   		=> "5",
			"max"                   		=> "400",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> 'px',
			"description"           		=> __( "Specify the maximum size a particle can have.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particle Scaling", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_size_scale",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want the particles to be shown in various scaled sizes.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Scaling Animation", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_size_anim",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want particles to be animated when scaling.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_size_scale", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Particles Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_color",
			"value"            	 			=> "#ffffff",
			"description"       			=> __( "Define the color for the particles; you can only use HEX values and no alpha/opacity settings.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Particle Stroke Width", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_stroke_width",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "10",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the stroke width for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Particles Stroke Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_stroke_color",
			"value"            	 			=> "#000000",
			"description"       			=> __( "Define the stroke color for the particles; you can only use HEX values and no alpha/opacity settings.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Type", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_particles_back_type",
			"value" 						=> array(
				__( "Color", "ts_visual_composer_extend")						=> "color",
				__( "Image", "ts_visual_composer_extend")						=> "image",
			),
			"description" 					=> __("Select the type of background you want to show behind the particles.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Background Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_back_color",
			"value"            	 			=> "#b61924",
			"description"       			=> __( "Define the background color for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "color"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Background Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_particles_back_image",
			"value"							=> "",
			"description"					=> __( "Select the background image for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Repeat", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_particles_back_repeat",
			"value" 						=> array(
				__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
				__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
				__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
				__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
			),
			"description" 					=> __(""),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_particles_back_size",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "100%", "ts_visual_composer_extend" )			=> "100%",
				__( "110%", "ts_visual_composer_extend" )			=> "110%",
				__( "120%", "ts_visual_composer_extend" )			=> "120%",
				__( "130%", "ts_visual_composer_extend" )			=> "130%",
				__( "140%", "ts_visual_composer_extend" )			=> "140%",
				__( "150%", "ts_visual_composer_extend" )			=> "150%",
				__( "160%", "ts_visual_composer_extend" )			=> "160%",
				__( "170%", "ts_visual_composer_extend" )			=> "170%",
				__( "180%", "ts_visual_composer_extend" )			=> "180%",
				__( "190%", "ts_visual_composer_extend" )			=> "190%",
				__( "200%", "ts_visual_composer_extend" )			=> "200%",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"description" 					=> __(""),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_particles_back_place",
			"value" 						=> array(
				__( "Center Center", "ts_visual_composer_extend" ) 				=> "center center",
				__( "Center Top", "ts_visual_composer_extend" )					=> "center top",
				__( "Center Bottom", "ts_visual_composer_extend" ) 				=> "center bottom",
				__( "Left Top", "ts_visual_composer_extend" ) 					=> "left top",
				__( "Left Center", "ts_visual_composer_extend" ) 				=> "left center",
				__( "Left Bottom", "ts_visual_composer_extend" ) 				=> "left bottom",
				__( "Right Top", "ts_visual_composer_extend" ) 					=> "right top",
				__( "Right Center", "ts_visual_composer_extend" ) 				=> "right center",
				__( "Right Bottom", "ts_visual_composer_extend" ) 				=> "right bottom",
			),
			"description" 					=> __("Select the position of the background image; will have most effect on smaller screens."),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Link Particles", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_link_lines",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to link the particles with a line once in proximity to each other.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Particles Link Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_link_color",
			"value"            	 			=> "#ffffff",
			"description"       			=> __( "Define the color of the link line between the particles; you can only use HEX values and no alpha/opacity settings.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_link_lines", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Particle Link Strength", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_link_width",
			"value"                 		=> "1",
			"min"                   		=> "1",
			"max"                   		=> "10",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> "px",
			"description"           		=> __( "Define the strength for the link lines between the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_link_lines", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Move Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_move",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want the particles to move.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Move Direction", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_particles_direction",
			"value" 						=> array(
				__( "None", "ts_visual_composer_extend")				=> "none",
				__( "Top", "ts_visual_composer_extend")					=> "top",
				__( "Top - Right", "ts_visual_composer_extend")			=> "top-right",
				__( "Right", "ts_visual_composer_extend")				=> "right",
				__( "Bottom - Right", "ts_visual_composer_extend")		=> "bottom-right",
				__( "Bottom", "ts_visual_composer_extend")				=> "bottom",
				__( "Left", "ts_visual_composer_extend")				=> "left",
				__( "Top - Left", "ts_visual_composer_extend")			=> "top-left",
				
			),
			"description" 					=> __("Select how the background video should be attached to the row.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Move Randomizer", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_random",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to apply an additional randomizer to the move effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Move Straight", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_straight",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to straighten out the move effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Particle Move Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_speed",
			"value"                 		=> "6",
			"min"                   		=> "1",
			"max"                   		=> "20",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> "",
			"description"           		=> __( "Define the moving speed for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Hover Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_hover",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want the particles to be affected when hovering over the background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Click Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_click",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want the particles to be affected when clicking on the background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// -------------------------
		// Video Attachment / Effect
		// -------------------------
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Video Attachment", "ts_visual_composer_extend"),
			"param_name" 					=> "multi_effect",
			"value" 						=> array(
				__( "Scroll", "ts_visual_composer_extend")				=> "fixed",
				__( "Fixed", "ts_visual_composer_extend")				=> "static",
				__( "Parallax", "ts_visual_composer_extend")			=> "parallax",
			),
			"description" 					=> __("Select how the background video should be attached to the row.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtubemb", "videomb")),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Parallax Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "multi_speed",
			"value"                 		=> "1",
			"min"                   		=> "-2",
			"max"                   		=> "2",
			"step"                  		=> "0.1",
			"decimals"						=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define the speed and direction of the parallax; a negative value equals a downward parallax, while a positive value equals an upwards parallax movement.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "multi_effect", "value" => "parallax"),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		// ------------------------
		// YouTube Video Background
		// ------------------------
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "YouTube Video ID", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_youtube",
			"value"             			=> "",
			"description"       			=> __( "Enter the YouTube video ID.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube", "youtubemb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Background Image", "ts_visual_composer_extend" ),
			"param_name"					=> "video_background",
			"value"							=> "",
			"description"					=> __( "Select an alternative background image for the video on mobile devices; otherwise YouTube cover image will be used.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube", "youtubemb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// ----------------------
		// HTML5 Video Background
		// ----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "MP4 Video Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_mp4",
			"value"             			=> "",
			"description"       			=> __( "Enter the path to the MP4 video version.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "OGV Video Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_ogv",
			"value"             			=> "",
			"description"       			=> __( "Enter the path to the OGV video version.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "WEBM Video Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_webm",
			"value"             			=> "",
			"description"       			=> __( "Enter the path to the WEBM video version.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Video Screenshot Image", "ts_visual_composer_extend" ),
			"param_name"					=> "video_image",
			"value"							=> "",
			"description"					=> __( "Select the a screenshot image for the video.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Mute Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_mute",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to mute the video while playing.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube", "youtubemb", "video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Loop Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_loop",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to loop the video after it has finished.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube", "youtubemb", "video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Remove Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_remove",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to remove (hide) the video after it has finished playing.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "video_loop",
				"value" 	=> "false"
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Start Video on Pageload", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_start",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to if you want to start the video once the page has loaded.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube", "youtubemb", "video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));		
		/*vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Play Video on Hover", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_hover",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to if you want to play the video only when hovering over it.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));	*/	
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Stop Video once out of View", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_stop",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to if you want to stop the video once it is out of view and restart when it comes back into view.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube", "youtubemb", "video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Show Video Controls", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_controls",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to if you want to show basic video controls.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube", "youtubemb", "video", "videomb")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Show Raster over Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_raster",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to if you want to show a raster over the video.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("youtube")
			),
			"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
		));
		// ---------------
		// Global Settings
		// ---------------		
		if ($TS_VCSC_RowOffsetSettings == 1) {
			vc_add_param("vc_row", array(
				"type"              			=> "seperator",
				"heading"           			=> __( "", "ts_visual_composer_extend" ),
				"param_name"        			=> "seperator_2",
				"value"             			=> "",
				"seperator"             		=> "Global Settings",
				"description"       			=> __( "", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles", "single", "gradient")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Padding: Top", "ts_visual_composer_extend" ),
				"param_name"            		=> "padding_top",
				"value"                 		=> "30",
				"min"                   		=> "0",
				"max"                   		=> "250",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional top padding for the row.", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles", "single", "gradient")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Padding: Bottom", "ts_visual_composer_extend" ),
				"param_name"            		=> "padding_bottom",
				"value"                 		=> "30",
				"min"                   		=> "0",
				"max"                   		=> "250",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional bottom padding for the row.", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles", "single", "gradient")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Left", "ts_visual_composer_extend" ),
				"param_name"            		=> "margin_left",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional left margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Right", "ts_visual_composer_extend" ),
				"param_name"            		=> "margin_right",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional right margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
		} else {
			vc_add_param("vc_row", array(
				"type"              			=> "seperator",
				"heading"           			=> __( "", "ts_visual_composer_extend" ),
				"param_name"        			=> "seperator_2",
				"value"             			=> "",
				"seperator"             		=> "Global Settings",
				"description"       			=> __( "", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Left", "ts_visual_composer_extend" ),
				"param_name"            		=> "ts_margin_left",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional left margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Right", "ts_visual_composer_extend" ),
				"param_name"            		=> "ts_margin_right",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional right margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array(
					"element" 	=> "ts_row_bg_effects",
					"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")
				),
				"group" 						=> __( "VCE Backgrounds", "ts_visual_composer_extend"),
			));
		}
		// -----------------------
		// Row Shapes / Separators
		// -----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "messenger2",
			"color"							=> "#D10000",
			"weight"						=> "bold",
			"size"							=> "14",
			"value"							=> "",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> 0,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_3",
			"value"             			=> "",
			"seperator"             		=> "KenBurns CSS3 Effect",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "gradient", "slideshow")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "KenBurns / Zoom Effect Type", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_kenburns_animation",
			"width"             			=> 300,
			"value"             			=> array(
				__( "None", "ts_visual_composer_extend" )							=> "null",
				__( "Random", "ts_visual_composer_extend" )							=> "random",
				__( "Basic Center Zoom", "ts_visual_composer_extend" )				=> "centerZoom",
				__( "Center Zoom + Fade Out", "ts_visual_composer_extend" )			=> "centerZoomFadeOut",
				__( "Center Zoom + Fade In", "ts_visual_composer_extend" )			=> "centerZoomFadeIn",
				__( "KenBurns Center", "ts_visual_composer_extend" )				=> "kenburns",
				__( "KenBurns Left", "ts_visual_composer_extend" )					=> "kenburnsLeft",
				__( "KenBurns Right", "ts_visual_composer_extend" )					=> "kenburnsRight",
				__( "KenBurns Up", "ts_visual_composer_extend" )					=> "kenburnsUp",						
				__( "KenBurns Up Left", "ts_visual_composer_extend" )				=> "kenburnsUpLeft",
				__( "KenBurns Up Right", "ts_visual_composer_extend" )				=> "kenburnsUpRight",
				__( "KenBurns Down", "ts_visual_composer_extend" )					=> "kenburnsDown",
				__( "KenBurns Down Left", "ts_visual_composer_extend" )				=> "kenburnsDownLeft",						
				__( "KenBurns Down Right", "ts_visual_composer_extend" )			=> "kenburnsDownRight",
			),
			"description"           		=> __( "Select the KenBurns or Zoom effect type to be applied to the background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "gradient", "slideshow")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_4",
			"value"             			=> "",
			"seperator"             		=> "Top Shapes",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Use Top Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_on",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to apply a SVG shape to the top of the row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Top SVG Shape", "ts_visual_composer_extend" ),
			"param_name" 					=> "svg_top_style",
			"value" 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_List,
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_top_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Top SVG Height", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_top_height",
			"value"                 		=> "100",
			"min"                   		=> "0",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_top_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Flip Top Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_flip",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to flip the top SVG shape.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "svg_top_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Top SVG Position", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_top_position",
			"value"                 		=> "0",
			"min"                   		=> "-300",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the exact position for the top SVG shape; you might have to adjust margins to avoid overlaps.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "svg_top_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Top SVG Color Main", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_color1",
			"value"            	 			=> "#ffffff",
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_top_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Top SVG Color Alternate", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_color2",
			"value"            	 			=> "#ededed",
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_top_style",
				"value" 	=> array("14", "16")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_5",
			"value"             			=> "",
			"seperator"             		=> "Bottom Shapes",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Use Bottom Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_on",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to apply a SVG shape to the bottom of the row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Bottom SVG Shape", "ts_visual_composer_extend" ),
			"param_name" 					=> "svg_bottom_style",
			"value" 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_List,
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_bottom_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Bottom SVG Height", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_bottom_height",
			"value"                 		=> "100",
			"min"                   		=> "0",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_bottom_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Flip Bottom Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_flip",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to flip the bottom SVG shape.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "svg_bottom_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Bottom SVG Position", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_bottom_position",
			"value"                 		=> "0",
			"min"                   		=> "-300",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the exact position for the bottom SVG shape; you might have to adjust margins to avoid overlaps.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "svg_bottom_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Bottom SVG Color Main", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_color1",
			"value"            	 			=> "#ffffff",
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_bottom_on",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Bottom SVG Color Alternate", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_color2",
			"value"            	 			=> "#ededed",
			"description" 					=> __(""),
			"dependency" 					=> array(
				"element" 	=> "svg_bottom_style",
				"value" 	=> array("14", "16")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// -------------
		// Other Effects
		// -------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_6",
			"value"             			=> "",
			"seperator"             		=> "Other Effects",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "single", "automove", "movement", "particles", "video", "videomb", "youtubemb", "triangle")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ---------------
		// Raster Settings
		// ---------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Raster Overlay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_raster_use",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to use a raster overlay with the background effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "single", "automove", "movement", "particles", "video", "videomb", "youtubemb", "triangle")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "background",
			"heading"           			=> __( "Raster Type", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_raster_type",
			"height"             			=> 200,
			"pattern"             			=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Rasters_List,
			"value"							=> "",
			"encoding"          			=> "false",
			"asimage"						=> "false",
			"thumbsize"						=> 40,
			"description"       			=> __( "Select the raster pattern for the background effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_raster_use",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// -------------
		// Color Overlay
		// -------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Color Overlay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_overlay_use",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to use a color overlay with the background effect; will only work with browser with RGBA support.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement", "video", "videomb", "youtubemb", "triangle")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Overlay Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_overlay_color",
			"value"            	 			=> "rgba(30,115,190,0.25)",
			"description" 					=> __("Define the overlay color; use the alpha channel setting to define the opacity of the overlay."),
			"dependency" 					=> array(
				"element" 	=> "ts_row_overlay_use",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// --------------------
		// Blur Effect Settings
		// --------------------
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Blur Strength", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_blur_strength",
			"value" 						=> array(
				__( "None", "ts_visual_composer_extend")					=> "",
				__( "Small Blur", "ts_visual_composer_extend")				=> "ts-background-blur-small",
				__( "Medium Blur", "ts_visual_composer_extend")				=> "ts-background-blur-medium",
				__( "Strong Blur", "ts_visual_composer_extend")				=> "ts-background-blur-strong",
			),
			"description" 					=> __("Define an optional blur strength for the background effect.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "automove", "movement")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ----------------
		// Column Equalizer
		// ----------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_7",
			"value"             			=> "",
			"seperator"             		=> "Column Height Equalizer",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_7",
			"value"             			=> "",
			"seperator"             		=> "Column Height Equalizer",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Equal Column Heights", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_columns",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if all columns in this row should use an equal height, based on the tallest column.", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Equal Column Heights", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_columns",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if all columns in this row should use an equal height, based on the tallest column.", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Content Alignment", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_equalize_align",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend")					=> "center",
				__( "Top", "ts_visual_composer_extend")						=> "top",
				__( "Bottom", "ts_visual_composer_extend")					=> "bottom",
			),
			"description" 					=> __("Define how the column content should be vertically aligned inside each column.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_equalize_columns",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Content Alignment", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_equalize_align",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend")					=> "center",
				__( "Top", "ts_visual_composer_extend")						=> "top",
				__( "Bottom", "ts_visual_composer_extend")					=> "bottom",
			),
			"description" 					=> __("Define how the column content should be vertically aligned inside each column.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_equalize_columns",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Maintain on Column Stack", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_stack",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if the equal column heights should be maintained even when columns are stacked on top of each other on small screens.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_equalize_columns",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Maintain on Column Stack", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_stack",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if the equal column heights should be maintained even when columns are stacked on top of each other on small screens.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_equalize_columns",
				"value" 	=> "true"
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ------------------
		// Viewport Animation
		// ------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_8",
			"value"             			=> "",
			"seperator"             		=> "Animation Settings",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("", "image", "gradient", "single")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_8",
			"value"             			=> "",
			"seperator"             		=> "Animation Settings",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("", "image", "gradient", "single")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "css3animations",
			"class" 						=> "",
			"heading" 						=> __("Viewport Animation", "ts_visual_composer_extend"),
			"param_name" 					=> "animation_view",
			"standard"						=> "false",
			"prefix"						=> "",
			"connector"						=> "css3animations_in",
			"noneselect"					=> "true",
			"default"						=> "",
			"value" 						=> "",
			"admin_label"					=> false,
			"description" 					=> __("Select a Viewport Animation for this Row; it is advised not to use with Parallax.", "ts_visual_composer_extend"),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("", "image", "gradient", "single")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type" 							=> "css3animations",
			"class" 						=> "",
			"heading" 						=> __("Viewport Animation", "ts_visual_composer_extend"),
			"param_name" 					=> "animation_view",
			"standard"						=> "false",
			"prefix"						=> "",
			"connector"						=> "css3animations_in",
			"noneselect"					=> "true",
			"default"						=> "",
			"value" 						=> "",
			"admin_label"					=> false,
			"description" 					=> __("Select a Viewport Animation for this Row; it is advised not to use with Parallax.", "ts_visual_composer_extend"),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                      	=> "hidden_input",
			"heading"                   	=> __( "Animation Type", "ts_visual_composer_extend" ),
			"param_name"                	=> "css3animations_in",
			"value"                     	=> "",
			"admin_label"		        	=> true,
			"description"               	=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("", "image", "gradient", "single")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"                      	=> "hidden_input",
			"heading"                   	=> __( "Animation Type", "ts_visual_composer_extend" ),
			"param_name"                	=> "css3animations_in",
			"value"                     	=> "",
			"admin_label"		        	=> true,
			"description"               	=> __( "", "ts_visual_composer_extend" ),			
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Repeat Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "animation_scroll",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to repeat the viewport effect when element has come out of view and comes back into viewport.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Repeat Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "animation_scroll",
			"value"             			=> "false",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to repeat the viewport effect when element has come out of view and comes back into viewport.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Animation Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "animation_speed",
			"value"                 		=> "2000",
			"min"                   		=> "1000",
			"max"                   		=> "5000",
			"step"                  		=> "100",
			"unit"                  		=> 'ms',
			"description"           		=> __( "Define the Length of the Viewport Animation in ms.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Animation Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "animation_speed",
			"value"                 		=> "2000",
			"min"                   		=> "1000",
			"max"                   		=> "5000",
			"step"                  		=> "100",
			"unit"                  		=> 'ms',
			"description"           		=> __( "Define the Length of the Viewport Animation in ms.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ----------------------
		// Row Visibility Toggles
		// ----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "messenger3",
			"color"							=> "#D10000",
			"weight"						=> "bold",
			"size"							=> "14",
			"value"							=> "",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> 0,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "messenger",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "messenger3",
			"color"							=> "#D10000",
			"weight"						=> "bold",
			"size"							=> "14",
			"value"							=> "",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> 0,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_9",
			"value"             			=> "",
			"seperator"             		=> "Device Visibility",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "seperator",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "seperator_9",
			"value"             			=> "",
			"seperator"             		=> "Device Visibility",
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));	
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "messenger5",
			"color"							=> "#006BB7",
			"weight"						=> "normal",
			"size"							=> "14",
			"value"							=> "",
			"message"            			=> __( "You can define the minimum screen size requirements for each device in the general settings page for 'Composium - Visual Composer Extensions'.", "ts_visual_composer_extend" ),
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> -10,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "messenger",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "messenger6",
			"color"							=> "#006BB7",
			"weight"						=> "normal",
			"size"							=> "14",
			"value"							=> "",
			"message"            			=> __( "You can define the minimum screen size requirements for each device in the general settings page for 'Composium - Visual Composer Extensions'.", "ts_visual_composer_extend" ),
			"description"       			=> __( "", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> -10,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Large Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_large",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on large screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Large Devices'] . " px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Large Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_large",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on large screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Large Devices'] . " px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Medium Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_medium",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on medium screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Medium Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Large Devices'] . "px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Medium Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_medium",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on medium screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Medium Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Large Devices'] . "px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_small",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on small screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Medium Devices'] . "px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_small",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on small screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Medium Devices'] . "px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Extra Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_extra",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on extra small screen devices", "ts_visual_composer_extend" ) . " (< " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Extra Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_extra",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle if you want to show the row on extra small screen devices", "ts_visual_composer_extend" ) . " (< " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px).",
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Remove Row from DOM", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_remove",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to either fully remove the row from the page or just hide it.", "ts_visual_composer_extend" ),
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Remove Row from DOM", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_remove",
			"value"             			=> "true",
			"on"							=> __( 'Yes', "ts_visual_composer_extend" ),
			"off"							=> __( 'No', "ts_visual_composer_extend" ),
			"style"							=> "select",
			"design"						=> "toggle-light",
			"description"       			=> __( "Switch the toggle to either fully remove the row from the page or just hide it.", "ts_visual_composer_extend" ),
			"dependency" 					=> "",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		// -------------------
		// Load Required Files
		// -------------------
		vc_add_param("vc_row", array(
			"type"                  		=> "load_file",
			"class" 						=> "",
			"heading"               		=> __( "", "ts_visual_composer_extend" ),
			"param_name"            		=> "el_file1",
			"value"                 		=> "",
			"file_type"             		=> "js",
			"file_path"             		=> "js/ts-visual-composer-extend-element.min.js",
			"description"           		=> __( "", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row_inner", array(
			"type"                  		=> "load_file",
			"class" 						=> "",
			"heading"               		=> __( "", "ts_visual_composer_extend" ),
			"param_name"            		=> "el_file1",
			"value"                 		=> "",
			"file_type"             		=> "js",
			"file_path"             		=> "js/ts-visual-composer-extend-element.min.js",
			"description"           		=> __( "", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "load_file",
			"class" 						=> "",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "el_file2",
			"value"             			=> "",
			"file_type"         			=> "css",
			"file_id"         				=> "ts-extend-animations",
			"file_path"         			=> "css/ts-visual-composer-extend-animations.min.css",
			"description"       			=> __( "", "ts_visual_composer_extend" )
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "load_file",
			"class" 						=> "",
			"heading"           			=> __( "", "ts_visual_composer_extend" ),
			"param_name"        			=> "el_file2",
			"value"             			=> "",
			"file_type"         			=> "css",
			"file_id"         				=> "ts-extend-animations",
			"file_path"         			=> "css/ts-visual-composer-extend-animations.min.css",
			"description"       			=> __( "", "ts_visual_composer_extend" )
		));
		// -----------------------
		// Add Custom BackEnd View
		// -----------------------
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorBackgroundIndicator == "true") {
			$setting = array (
				"js_view" 					=> 'TS_VCSC_VcRowViewCustom',
			);
		} else {
			$setting = array ();
		}
		vc_map_update('vc_row', $setting);
	}
	
	add_filter('TS_VCSC_ComposerRowAdditions_Filter',		'TS_VCSC_ComposerRowAdditions', 		10, 2);
	
	function TS_VCSC_ComposerRowAdditions($output, $atts, $content = '') {
		global $VISUAL_COMPOSER_EXTENSIONS;
		$TS_VCSC_RowToggleLimits		= get_option('ts_vcsc_extend_settings_rowVisibilityLimits', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Row_Toggle_Defaults);
		$TS_VCSC_RowOffsetSettings		= get_option('ts_vcsc_extend_settings_additionsOffsets',	0);
		ob_start();

		extract(shortcode_atts( array(
			'ts_row_bg_retrieve'		=> 'single',
			'ts_row_bg_image'			=> '',
			'ts_row_bg_group'			=> '',
			'ts_row_bg_source'			=> 'full',
			'ts_row_bg_effects'			=> '',
			'ts_row_break_parents'		=> 0,
			
			'ts_row_blur_strength'		=> '',
			'ts_row_raster_use'			=> 'false',
			'ts_row_raster_type'		=> '',
			
			'ts_row_overlay_use'		=> 'false',
			'ts_row_overlay_color'		=> 'rgba(30,115,190,0.25)',
			'ts_row_overlay_opacity'	=> 25,
			
			'ts_row_zindex'				=> 0,
			'ts_row_min_height'			=> 100,
			'ts_row_screen_height'		=> 'false',
			'ts_row_screen_offset'		=> 0,
			
			'svg_top_on'				=> 'false',
			'svg_top_style'				=> '1',
			'svg_top_height'			=> 100,
			'svg_top_flip'				=> 'false',
			'svg_top_position'			=> 0,
			'svg_top_color1'			=> '#ffffff',
			'svg_top_color2'			=> '#ededed',
			
			'svg_bottom_on'				=> 'false',
			'svg_bottom_style'			=> '1',
			'svg_bottom_height'			=> 100,
			'svg_bottom_flip'			=> 'false',
			'svg_bottom_position'		=> 0,
			'svg_bottom_color1'			=> '#ffffff',
			'svg_bottom_color2'			=> '#ededed',
			
			'ts_row_bg_position'		=> 'center',
			'ts_row_bg_position_custom'	=> '',
			'ts_row_bg_alignment_h'		=> 'center',
			'ts_row_bg_alignment_v'		=> 'center',
			'ts_row_bg_repeat'			=> 'no-repeat',
			'ts_row_bg_size_parallax'	=> 'cover',
			'ts_row_bg_size_standard'	=> 'cover',
			'ts_row_parallax_type'		=> 'up',
			'ts_row_parallax_speed'		=> 20,
			'ts_row_parallax_fade'		=> 1000,
			
			'ts_row_slide_images'		=> '',
			'ts_row_slide_auto'			=> 'true',
			'ts_row_slide_controls'		=> 'true',
			'ts_row_slide_shuffle'		=> 'false',
			'ts_row_slide_delay'		=> 5000,
			'ts_row_slide_bar'			=> 'true',
			'ts_row_slide_transition'	=> 'random',
			'ts_row_slide_switch'		=> 2000,			
			'ts_row_slide_halign'		=> 'center',
			'ts_row_slide_valign'		=> 'center',
			
			'ts_row_kenburns_animation'	=> 'null',
			
			'ts_row_automove_scroll'	=> 'true',
			'ts_row_automove_align'		=> 'horizontal',
			'ts_row_automove_path_v'	=> 'topbottom',
			'ts_row_automove_path_h'	=> 'leftright',
			'ts_row_automove_speed'		=> 75,
			
			'ts_row_movement_x_allow'	=> 'true',
			'ts_row_movement_x_ratio'	=> 20,
			'ts_row_movement_y_allow'	=> 'true',
			'ts_row_movement_y_ratio'	=> 20,
			'ts_row_movement_content'	=> 'false',
			
			'ts_margin_left'			=> 0,
			'ts_margin_right'			=> 0,
			'margin_left'				=> 0,
			'margin_right'				=> 0,
			'padding_top'				=> 30,
			'padding_bottom'			=> 30,
			'enable_mobile'				=> 'false',
			
			'single_color'				=> '#ffffff',
			
			'gradiant_advanced'			=> 'false',
			'gradient_generator'		=> '',
			'gradient_angle'			=> 0,
			'gradient_color_start'		=> '#cccccc',
			'gradient_start_offset'		=> 0,
			'gradient_color_end'		=> '#cccccc',
			'gradient_end_offset'		=> 100,
			
			'trianglify_render'			=> 'canvas',
			'trianglify_colorsx'		=> 'random',
			'trianglify_colorsy'		=> 'match_x',
			'trianglify_generatorx'		=> '',
			'trianglify_generatory'		=> '',
			'trianglify_cellsize'		=> 50,
			'trianglify_variance'		=> 0.75,
			
			'ts_particles_count'		=> 30,
			'ts_particles_size_max'		=> 10,
			'ts_particles_size_scale'	=> 'true',
			'ts_particles_size_anim'	=> 'false',
			'ts_particles_color'		=> '#ffffff',
			'ts_particles_stroke_width'	=> 0,
			'ts_particles_stroke_color'	=> '#000000',
			'ts_particles_back_type'	=> 'color',
			'ts_particles_back_color'	=> '#b61924',
			'ts_particles_back_image'	=> '',
			'ts_particles_back_repeat'	=> 'no-repeat',
			'ts_particles_back_place'	=> 'center center',
			'ts_particles_back_size'	=> 'cover',
			'ts_particles_shape_source'	=> 'internal',
			'ts_particles_shape_types'	=> 'circle',
			'ts_particles_shape_image'	=> '',
			'ts_particles_link_lines'	=> 'true',
			'ts_particles_link_color'	=> '#ffffff',
			'ts_particles_link_width'	=> 1,
			'ts_particles_hover'		=> 'false',
			'ts_particles_click'		=> 'false',
			'ts_particles_move'			=> 'true',
			'ts_particles_direction'	=> 'none',
			'ts_particles_speed'		=> 6,
			'ts_particles_random'		=> 'false',
			'ts_particles_straight'		=> 'false',
			
			'video_youtube'				=> '',
			'video_background'			=> '',
			'video_mute'				=> 'true',
			'video_loop'				=> 'false',
			'video_remove'				=> 'false',
			'video_start'				=> 'false',
			'video_hover'				=> 'false',
			'video_stop'				=> 'true',
			'video_controls'			=> 'true',
			'video_raster'				=> 'false',
			
			'video_mp4'					=> '',
			'video_ogv'					=> '',
			'video_webm'				=> '',
			'video_image'				=> '',
			
			'multi_effect'				=> 'fixed',
			'multi_speed'				=> 1,
			
			'ts_equalize_columns'		=> 'false',
			'ts_equalize_align'			=> 'center',
			'ts_equalize_stack'			=> 'false',

			'animation_factor'			=> '0.33',
			'animation_scroll'			=> 'false',
			'animation_view'			=> '',
			'animation_speed'			=> 2000,
			
			'show_large'				=> 'true',
			'show_medium'				=> 'true',
			'show_small'				=> 'true',
			'show_extra'				=> 'true',
			'show_remove'				=> 'true',
		), $atts));
		
		// Check for Frontend Editor Mode
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$frontend_edit				= 'true';
		} else {
			$frontend_edit				= 'false';
		}
		
		// Check if Extended Row Options Utilized
		if (($ts_row_bg_effects != "") || (!empty($animation_view)) || ($ts_equalize_columns == 'true')) {
			$extended_effects			= "true";
		} else {
			$extended_effects			= "false";
		}
		
		if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") && ($extended_effects == "true")) {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}		
		if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndForcable == "false") && ($extended_effects == "true")) {
			wp_enqueue_style('ts-extend-animations');			
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
		}

		$output 						= "";
		
		$randomizer						= mt_rand(999999, 9999999);
		
		// Check for Row Padding/Margin Offsets
		if ($TS_VCSC_RowOffsetSettings == 0) {
			$row_offsetsallow			= 'data-offsetsallow="false"';
			$padding_top				= '0';
			$padding_bottom				= '0';
			$margin_left				= $ts_margin_left;
			$margin_right				= $ts_margin_right;
		} else {
			$row_offsetsallow			= 'data-offsetsallow="true"';
		}

		// Viewport Animations
		if (!empty($animation_view)) {
			$animation_css				= "ts-viewport-css-" . $animation_view;
			$output						.= '<div class="ts-viewport-row ts-viewport-animation" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-scrollup = "' . $animation_scroll . '" data-factor="' . $animation_factor . '" data-viewport="' . $animation_css . '" data-speed="' . $animation_speed . '"></div>';
		} else {
			$animation_css				= '';
		}

		// CSS3 Blur Effect
		if ($ts_row_blur_strength != '') {
			$blur_class					= "ts-background-blur " . $ts_row_blur_strength;
			if ($ts_row_blur_strength == "ts-background-blur-small") {
				$blur_factor			= 2;
			} else if ($ts_row_blur_strength == "ts-background-blur-medium") {
				$blur_factor			= 5;
			} else if ($ts_row_blur_strength == "ts-background-blur-strong") {
				$blur_factor			= 8;
			}
		} else {
			$blur_class					= "";
			$blur_factor				= 0;
		}
		
		// Raster (Noise) Overlay
		if (($ts_row_raster_use == "true") && ($ts_row_raster_type != '')) {
			$raster_content				= '<div class="ts-background-raster" style="background-image: url(' . $ts_row_raster_type . ');"></div>';
		} else {
			$raster_content				= '';
		}
		
		// Color Overlay
		if (($ts_row_overlay_use == "true") && ($ts_row_overlay_color != '')) {
			$overlay_content			= '<div class="ts-background-overlay" style="background: ' . $ts_row_overlay_color . ';"></div>';
		} else {
			$overlay_content			= '';
		}
		
		// SVG Shape Overlays
		$svg_enabled					= 'false';
		if ($svg_top_on == "true") {
			$svg_top_content			= '<div id="ts-background-separator-top-' . $randomizer . '" class="ts-background-separator-container" style="height: ' . $svg_top_height . 'px; top: ' . $svg_top_position . 'px; bottom: auto; z-index: ' . (1 + $ts_row_zindex) . ';"><div class="ts-background-separator-wrap ts-background-separator-top' . ($svg_top_flip == "true" ? "-flip" : "") . '" data-random="' . $randomizer . '" data-height="' . $svg_top_height . '" data-position="top" style="height: ' . $svg_top_height . 'px;">' . TS_VCSC_GetRowSeparator($svg_top_style, $svg_top_color1, $svg_top_color2, $svg_top_height) . '</div></div>';
			$svg_enabled				= 'true';
		} else {
			$svg_top_content			= '';
		}
		if ($svg_bottom_on == "true") {
			$svg_bottom_content			= '<div id="ts-background-separator-bottom-' . $randomizer . '" class="ts-background-separator-container" style="height: ' . $svg_bottom_height . 'px; top: auto; bottom: ' . $svg_bottom_position . 'px; z-index: ' . (1 + $ts_row_zindex) . ';"><div class="ts-background-separator-wrap ts-background-separator-bottom' . ($svg_bottom_flip == "true" ? "-flip" : "") . '" data-random="' . $randomizer . '" data-height="' . $svg_bottom_height . '" data-position="bottom" style="height: ' . $svg_bottom_height . 'px;">' . TS_VCSC_GetRowSeparator($svg_bottom_style, $svg_bottom_color1, $svg_bottom_color2, $svg_bottom_height) . '</div></div>';
			$svg_enabled				= 'true';
		} else {
			$svg_bottom_content			= '';
		}
		
		// Column Equalize Settings
		if ($ts_equalize_columns == 'true') {
			$column_equalize_string		= 'data-column-equalize="true" data-column-align="' . $ts_equalize_align . '" data-column-stack="' . $ts_equalize_stack . '"';
			$column_equalize_class		= 'ts-columns-equalize-enabled';
		} else {
			$column_equalize_string		= 'data-column-equalize="false"';
			$column_equalize_class		= 'ts-columns-equalize-disabled';
		}
		
		// Row Toggle Settings
		$row_toggle_limits				= $TS_VCSC_RowToggleLimits;
		$large_default					= 'true';
		$large_limit					= $row_toggle_limits['Large Devices'];
		$medium_default					= 'true';
		$medium_limit					= $row_toggle_limits['Medium Devices'];
		$small_default					= 'true';
		$small_limit					= $row_toggle_limits['Small Devices'];
		$extra_default					= 'true';
		$extra_limit					= 0;
		if ((($large_default != $show_large) || ($medium_default != $show_medium) || ($small_default != $show_small) || ($extra_default != $show_extra)) && ($frontend_edit == "false")) {
			$row_toggle_trigger			= 'true';
			$row_toggle_class			= $column_equalize_class . ' ts-composium-row-background ts-device-visibility';
			$row_toggle_string			= $column_equalize_string . ' data-width-current="" data-width-break="' . get_option('ts_vcsc_extend_settings_additionsRowEffectsBreak', '600') . '" data-showremove="' . $show_remove . '" data-largeshow="' . $show_large . '" data-largelimit="' . $large_limit . '" data-mediumshow="' . $show_medium . '" data-mediumlimit="' . $medium_limit . '" data-smallshow="' . $show_small . '" data-smalllimit="' . $small_limit . '" data-extrashow="' . $show_extra . '" data-extralimit="' . $extra_limit . '"';
		} else {
			$row_toggle_trigger			= 'false';
			$row_toggle_class			= $column_equalize_class . ' ts-composium-row-background';
			$row_toggle_string			= $column_equalize_string . ' data-width-current="" data-width-break="' . get_option('ts_vcsc_extend_settings_additionsRowEffectsBreak', '600') . '"';
		}
		
		// Ken Burns Effect
		if ($ts_row_kenburns_animation != 'null') {			
			if ($ts_row_kenburns_animation == 'random') {
				$kenburns_effects 		= array('centerZoom', 'centerZoomFadeOut', 'centerZoomFadeIn', 'kenburns', 'kenburnsLeft', 'kenburnsRight', 'kenburnsUp', 'kenburnsUpLeft', 'kenburnsUpRight', 'kenburnsDown', 'kenburnsDownLeft', 'kenburnsDownRight');
				$kenburns_animation 	= 'ts-css-animation-' . $kenburns_effects[array_rand($kenburns_effects, 1)];
			} else {
				$kenburns_animation 	= 'ts-css-animation-' . $ts_row_kenburns_animation;
			}
			$kenburns_string			= 'data-kenburns-set="true" data-kenburns-animation="' . $kenburns_animation . '"';
		} else {
			$kenburns_animation			= '';
			$kenburns_string			= 'data-kenburns-set="false"';			
		}
		
		// No Background Effect
		if ($row_toggle_trigger == "true") {
			if ($ts_row_bg_effects == "") {
				$output					.= '<div id="' . $row_toggle_class . '-' . $randomizer . '" class="' . $row_toggle_class . '" ' . $row_toggle_string . '></div>';
			}
		} else if ($ts_equalize_columns == 'true') {
			if ($ts_row_bg_effects == "") {
				$output					.= '<div id="' . $row_toggle_class . '-' . $randomizer . '" class="' . $row_toggle_class . '" ' . $row_toggle_string . '></div>';
			}
		}
		
		// Single Image or Group
		if (($ts_row_bg_effects == "image") || ($ts_row_bg_effects == "fixed") || ($ts_row_bg_effects == "parallax") || ($ts_row_bg_effects == "automove") || ($ts_row_bg_effects == "movement")) {
			if ($ts_row_bg_retrieve == 'random') {
				$ts_row_bg_group		= explode(',', $ts_row_bg_group);
				if (is_array($ts_row_bg_group)) {
					$ts_row_bg_image	= $ts_row_bg_group[array_rand($ts_row_bg_group)];
				} else {
					$ts_row_bg_image	= '';
				}
			} else if ($ts_row_bg_retrieve == 'single') {
				$ts_row_bg_image		= $ts_row_bg_image;
			}
		}
		
		// Simple Background Image
		if ($ts_row_bg_effects == "image") {
			$ts_row_bg_image_url		= wp_get_attachment_image_src($ts_row_bg_image, $ts_row_bg_source);
			if ($ts_row_bg_position == "custom") {
				$ts_row_bg_position		= $ts_row_bg_position_custom;
			}
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-image ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $kenburns_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_url[1] . "' data-image-height='" . $ts_row_bg_image_url[2] . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_url[0] . "' data-size='". $ts_row_bg_size_standard . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				if ($ts_row_kenburns_animation != 'null') {
					$output 			.= '<div class="ts-background-kenburns-wrapper"><div class="ts-background-kenburns-parent"><div class="ts-background-kenburns-image ' . $kenburns_animation . '"></div></div></div>';
				}
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Fixed Background Image
		if ($ts_row_bg_effects == "fixed") {
			$ts_row_bg_image_url		= wp_get_attachment_image_src($ts_row_bg_image, $ts_row_bg_source);
			if ($ts_row_bg_position == "custom") {
				$ts_row_bg_position		= $ts_row_bg_position_custom;
			}
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-fixed ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_url[1] . "' data-image-height='" . $ts_row_bg_image_url[2] . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_url[0] . "' data-size='". $ts_row_bg_size_standard . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Image Slideshow Background
		if ($ts_row_bg_effects == "slideshow") {
			wp_enqueue_style('ts-extend-vegas');
			wp_enqueue_script('ts-extend-vegas');
			$slider_settings			= 'data-initialized="false" data-autoplay="' .$ts_row_slide_auto . '" data-playing="' .$ts_row_slide_auto . '" data-halign="' . $ts_row_slide_halign . '" data-valign="' . $ts_row_slide_valign . '" data-controls="' . $ts_row_slide_controls . '" data-shuffle="' . $ts_row_slide_shuffle . '" data-delay="' . $ts_row_slide_delay . '" data-bar="' . $ts_row_slide_bar . '" data-transition="' . $ts_row_slide_transition . '" data-switch="' . $ts_row_slide_switch . '" data-animation="' . $ts_row_kenburns_animation . '"';
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-slideshow ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' " . $slider_settings . " data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-size='". $ts_row_bg_size_standard . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				$slide_images 			= explode(',', $ts_row_slide_images);
				$i 						= 0;
				foreach ($slide_images as $single_image) {
					$i++;
					$slide_image		= wp_get_attachment_image_src($single_image, $ts_row_bg_source);
					$output .= '<div class="ts-background-slideshow-holder" style="display: none;" data-image="' . $slide_image[0] . '" data-width="' . $slide_image[1] . '" data-height="' . $slide_image[2] . '" data-ratio="' . ($slide_image[1] / $slide_image[2]) . '"></div>';
				}
				$output 				.= '<div class="ts-background-slideshow-wrapper"></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
				if ($ts_row_slide_controls == 'true') {
					// Left / Right Navigation
					$output .= '<nav id="nav-arrows-' . $randomizer . '" class="nav-arrows">';
						$output .= '<span class="nav-arrow-prev" style="text-indent: -90000px;">Previous</span>';
						$output .= '<span class="nav-arrow-next" style="text-indent: -90000px;">Next</span>';
					$output .= '</nav>';
				}
				if ($ts_row_slide_auto == 'true') {
					// Auto-Play Controls
					$output .= '<nav id="nav-auto-' . $randomizer . '" class="nav-auto">';
						$output .= '<span class="nav-auto-play" style="display: none; text-indent: -90000px;">Play</span>';
						$output .= '<span class="nav-auto-pause" style="text-indent: -90000px;">Pause</span>';
					$output .= '</nav>';
				}
			$output .= '</div>';
		}
		
		// Parallax Background
		if ($ts_row_bg_effects == "parallax") {
			$parallaxClass				= ($ts_row_parallax_type == "none") ? "" : "ts-background-parallax";
			$parallaxClass				= in_array( $ts_row_parallax_type, array( "none", "fixed", "up", "down", "left", "right", "ts-background-parallax" ) ) ? $parallaxClass : "";			
			if (($ts_row_parallax_type == "up") || ($ts_row_parallax_type == "down")) {
				$ts_row_bg_alignment	= $ts_row_bg_alignment_v;
			} else if (($ts_row_parallax_type == "left") || ($ts_row_parallax_type == "right")) {
				$ts_row_bg_alignment	= $ts_row_bg_alignment_h;
			}			
			if (!empty($parallaxClass)) {
				$ts_row_bg_image_url	= wp_get_attachment_image_src($ts_row_bg_image, $ts_row_bg_source);
				$ts_row_parallax_speed	= round(($ts_row_parallax_speed / 100), 2);
				$output					.= "<div id='ts-background-main-" . $randomizer . "' class='" . esc_attr($parallaxClass) . " ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " data-completed='false' data-fadespeed='" . $ts_row_parallax_fade . "' " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_url[1] . "' data-image-height='" . $ts_row_bg_image_url[2] . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-disabled='false' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_url[0] . "' data-size='". $ts_row_bg_size_parallax . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-alignment='" . $ts_row_bg_alignment . "' data-repeat='" . $ts_row_bg_repeat . "' data-direction='" . esc_attr($ts_row_parallax_type) . "' data-momentum='" . esc_attr((float)$ts_row_parallax_speed) . "' data-mobile-enabled='" . esc_attr($enable_mobile) . "' data-break-parents='" . esc_attr($ts_row_break_parents) . "'>";
					$output				.= "<div id='ts-background-parallax-holder-" . $randomizer . "' class='ts-background-parallax-holder'></div>";
					$output				.= $svg_top_content;
					$output				.= $overlay_content;
					$output				.= $raster_content;
					$output				.= $svg_bottom_content;
				$output 				.= "</div>";
			}
		}
		
		// AutoMove Background
		if ($ts_row_bg_effects == "automove") {
			$ts_row_bg_image_url		= wp_get_attachment_image_src($ts_row_bg_image, $ts_row_bg_source);
			if ($ts_row_automove_align == "horizontal") {
				$ts_row_automove_path	= $ts_row_automove_path_h;
			} else if ($ts_row_automove_align == "vertical") {
				$ts_row_automove_path	= $ts_row_automove_path_v;
			}			
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-automove ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_url[1] . "' data-image-height='" . $ts_row_bg_image_url[2] . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_url[0] . "' data-size='". $ts_row_bg_size_parallax . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='repeat 0 0' data-scroll='" . $ts_row_automove_scroll . "' data-alignment='" . $ts_row_automove_align . "' data-direction='" . $ts_row_automove_path . "' data-speed='" . $ts_row_automove_speed . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Movement Background
		if ($ts_row_bg_effects == "movement") {
			wp_enqueue_script('ts-extend-parallaxify');
			$ts_row_bg_image_url		= wp_get_attachment_image_src($ts_row_bg_image, $ts_row_bg_source);			
			$ts_row_movement_data		= ' data-allowx="' . $ts_row_movement_x_allow . '" data-movex="' . $ts_row_movement_x_ratio . '" data-allowy="' . $ts_row_movement_y_allow . '" data-movey="' . $ts_row_movement_y_ratio . '" data-allowcontent="' . $ts_row_movement_content . '"';
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-movement ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_url[1] . "' data-image-height='" . $ts_row_bg_image_url[2] . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-disabled='false' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_url[0] . "' data-size='". $ts_row_bg_size_parallax . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-mobile-enabled='" . esc_attr($enable_mobile) . "' data-break-parents='" . esc_attr($ts_row_break_parents) . "' " . $ts_row_movement_data . ">";
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Particles Background
		if ($ts_row_bg_effects == "particles") {
			wp_enqueue_script('ts-extend-particles');
			if ($ts_particles_back_type == "image") {
				$ts_particles_back_image	= wp_get_attachment_image_src($ts_particles_back_image, 'full');
				$ts_particles_back_image	= $ts_particles_back_image[0];
			}
			if ($ts_particles_shape_source == "external") {
				$ts_particles_shape_image	= wp_get_attachment_image_src($ts_particles_shape_image, 'full');				
				$ts_particles_shape_width	= $ts_particles_shape_image[1];
				$ts_particles_shape_height	= $ts_particles_shape_image[2];
				$ts_particles_shape_image	= $ts_particles_shape_image[0];				
			} else {
				$ts_particles_shape_width	= 100;
				$ts_particles_shape_height	= 100;
			}
			$ts_row_particles_data		= 'data-particles-count="' . $ts_particles_count . '" data-particles-sizemax="' . $ts_particles_size_max . '" data-particles-sizescale="' . $ts_particles_size_scale . '" data-particles-sizeanimate="' . $ts_particles_size_anim . '"';
			$ts_row_particles_data		.= ' data-particles-shapesource="' . $ts_particles_shape_source . '" data-particles-shapetypes="' . $ts_particles_shape_types . '" data-particles-shapeimage="' . $ts_particles_shape_image . '" data-particles-shapewidth="' . $ts_particles_shape_width . '"';			
			$ts_row_particles_data		.= ' data-particles-color="'  .$ts_particles_color . '" data-particles-strokewidth="' . $ts_particles_stroke_width . '" data-particles-strokecolor="' . $ts_particles_stroke_color . '" data-particles-linklines="' . $ts_particles_link_lines . '" data-particles-linkcolor="' . $ts_particles_link_color . '" data-particles-linkwidth="' . $ts_particles_link_width . '" data-particles-interhover="' . $ts_particles_hover . '" data-particles-interclick="' . $ts_particles_click . '"';
			$ts_row_particles_data		.= ' data-particles-backtype="' . $ts_particles_back_type . '" data-particles-backcolor="' . $ts_particles_back_color . '" data-particles-backimage="' . $ts_particles_back_image . '" data-particles-backrepeat="' . $ts_particles_back_repeat . '" data-particles-backposition="' . $ts_particles_back_place . '" data-particles-backsize="' . $ts_particles_back_size . '" data-particles-shapeheight="' . $ts_particles_shape_height . '"';
			$ts_row_particles_data		.= ' data-particles-moveallow="' . $ts_particles_move . '" data-particles-movedirection="' . $ts_particles_direction . '" data-particles-movespeed="' . $ts_particles_speed . '" data-particles-moverandom="' . $ts_particles_random . '" data-particles-movestraight="' . $ts_particles_straight . '"';
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-particles ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-disabled='false' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-size='cover' data-position='center center' data-repeat='no-repeat' data-mobile-enabled='false' data-break-parents='" . esc_attr($ts_row_break_parents) . "' " . $ts_row_particles_data . ">";
				$output 				.= '<div id="ts-background-particles-holder-' . $randomizer . '" class="ts-background-particles-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}

		// Selfhosted Video Background I
		if ($ts_row_bg_effects == "video") {			
			wp_enqueue_style('ts-font-mediaplayer');
			wp_enqueue_style('ts-extend-wallpaper');
			wp_enqueue_script('ts-extend-wallpaper');
			if (!empty($video_image)) {
				$video_image_url		= wp_get_attachment_image_src($video_image, 'full');
				$video_image_url		= $video_image_url[0];
			} else {
				$video_image_url		= "";
			}
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-video ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-raster="' . ((($ts_row_raster_use == "true") && ($ts_row_raster_type != '')) ? $ts_row_raster_type : "") . '" data-overlay="' . ((($ts_row_overlay_use == "true") && ($ts_row_overlay_color != '')) ? $ts_row_overlay_color : "") . '" data-mp4="' . $video_mp4 . '" data-ogv="' . $video_ogv . '" data-webm="' . $video_webm . '" data-image="' . $video_image_url . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-mute="' . $video_mute . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-video-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Selfhosted Video Background II
		if ($ts_row_bg_effects == "videomb") {			
			wp_enqueue_style('ts-font-mediaplayer');
			wp_enqueue_script('ts-extend-multibackground');
			if (!empty($video_image)) {
				$video_image_url		= wp_get_attachment_image_src($video_image, 'full');
				$video_image_url		= $video_image_url[0];
			} else {
				$video_image_url		= "";
			}			
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-multiback ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' data-attachment="' . $multi_effect . '" data-parallax="' . $multi_speed . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-raster="' . ((($ts_row_raster_use == "true") && ($ts_row_raster_type != '')) ? $ts_row_raster_type : "") . '" data-overlay="' . ((($ts_row_overlay_use == "true") && ($ts_row_overlay_color != '')) ? $ts_row_overlay_color : "") . '" data-mp4="' . $video_mp4 . '" data-ogv="' . $video_ogv . '" data-webm="' . $video_webm . '" data-image="' . $video_image_url . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-mute="' . $video_mute . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-video-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Youtube Video Background I
		if ($ts_row_bg_effects == "youtube") {
			wp_enqueue_script('ts-extend-ytplayer');
			wp_enqueue_style('ts-extend-ytplayer');
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $video_youtube)) {
				$video_youtube			= $video_youtube;
			} else {
				$video_youtube			= 'https://www.youtube.com/watch?v=' . $video_youtube;
			}
			if (!empty($video_background)) {
				$video_background		= wp_get_attachment_image_src($video_background, 'full');
				$video_background		= $video_background[0];
			} else {
				$video_background		= TS_VCSC_VideoImage_Youtube($video_youtube);
			}			
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-youtube ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-image="' . $video_background . '" data-video="' . $video_youtube . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-raster="' . $video_raster . '" data-mute="' . $video_mute . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';		
		}
		
		// Youtube Video Background II
		if ($ts_row_bg_effects == "youtubemb") {
			wp_enqueue_script('ts-extend-multibackground');
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $video_youtube)) {
				$video_youtube			= TS_VCSC_VideoID_Youtube($video_youtube);
			} else {
				$video_youtube			= $video_youtube;
			}
			if (!empty($video_background)) {
				$video_background		= wp_get_attachment_image_src($video_background, 'full');
				$video_background		= $video_background[0];
			} else {
				$video_background		= TS_VCSC_VideoImage_Youtube($video_youtube);
			}				
			wp_enqueue_script('ts-extend-multibackground');
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-multiback ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' data-attachment="' . $multi_effect . '" data-parallax="' . $multi_speed . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-image="' . $video_background . '" data-video="' . $video_youtube . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-raster="' . $video_raster . '" data-mute="' . $video_mute . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-video-holder multibackground" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Vimeo Video Background
		if ($ts_row_bg_effects == "vimeo") {

		}
		
		// Trianglify Background
		if ($ts_row_bg_effects == "triangle") {
			wp_enqueue_script('ts-extend-trianglify');			
			$trianglify_predefined = array(
				"YlGn" 			=> "#ffffe5,#f7fcb9,#d9f0a3,#addd8e,#78c679,#41ab5d,#238443,#006837,#004529",                          	// Yellow - Green
				"YlGnBu" 		=> "#ffffd9,#edf8b1,#c7e9b4,#7fcdbb,#41b6c4,#1d91c0,#225ea8,#253494,#081d58",                        	// Yellow - Green - Blue
				"GnBu" 			=> "#f7fcf0,#e0f3db,#ccebc5,#a8ddb5,#7bccc4,#4eb3d3,#2b8cbe,#0868ac,#084081",                          	// Green - Blue
				"BuGn" 			=> "#f7fcfd,#e5f5f9,#ccece6,#99d8c9,#66c2a4,#41ae76,#238b45,#006d2c,#00441b",                          	// Blue - Green
				"PuBuGn" 		=> "#fff7fb,#ece2f0,#d0d1e6,#a6bddb,#67a9cf,#3690c0,#02818a,#016c59,#014636",                        	// Purple - Blue - Green
				"PuBu" 			=> "#fff7fb,#ece7f2,#d0d1e6,#a6bddb,#74a9cf,#3690c0,#0570b0,#045a8d,#023858",                          	// Purple - Blue
				"BuPu" 			=> "#f7fcfd,#e0ecf4,#bfd3e6,#9ebcda,#8c96c6,#8c6bb1,#88419d,#810f7c,#4d004b",                          	// Blue - Purple
				"RdPu" 			=> "#fff7f3,#fde0dd,#fcc5c0,#fa9fb5,#f768a1,#dd3497,#ae017e,#7a0177,#49006a",                          	// Red - Purple
				"PuRd" 			=> "#f7f4f9,#e7e1ef,#d4b9da,#c994c7,#df65b0,#e7298a,#ce1256,#980043,#67001f",                          	// Purple - Red
				"OrRd" 			=> "#fff7ec,#fee8c8,#fdd49e,#fdbb84,#fc8d59,#ef6548,#d7301f,#b30000,#7f0000",                          	// Orange - Red
				"YlOrRd" 		=> "#ffffcc,#ffeda0,#fed976,#feb24c,#fd8d3c,#fc4e2a,#e31a1c,#bd0026,#800026",                        	// Yellow - Orange - Red
				"YlOrBr" 		=> "#ffffe5,#fff7bc,#fee391,#fec44f,#fe9929,#ec7014,#cc4c02,#993404,#662506",                        	// Yellow - Orange - Brown
				"Purples" 		=> "#fcfbfd,#efedf5,#dadaeb,#bcbddc,#9e9ac8,#807dba,#6a51a3,#54278f,#3f007d",                       	// Purples
				"Blues" 		=> "#f7fbff,#deebf7,#c6dbef,#9ecae1,#6baed6,#4292c6,#2171b5,#08519c,#08306b",                         	// Blues
				"Greens" 		=> "#f7fcf5,#e5f5e0,#c7e9c0,#a1d99b,#74c476,#41ab5d,#238b45,#006d2c,#00441b",                        	// Greens
				"Oranges" 		=> "#fff5eb,#fee6ce,#fdd0a2,#fdae6b,#fd8d3c,#f16913,#d94801,#a63603,#7f2704",                       	// Oranges
				"Reds" 			=> "#fff5f0,#fee0d2,#fcbba1,#fc9272,#fb6a4a,#ef3b2c,#cb181d,#a50f15,#67000d",                          	// Reds
				"Greys" 		=> "#ffffff,#f0f0f0,#d9d9d9,#bdbdbd,#969696,#737373,#525252,#252525,#000000",                         	// Greys
				"PuOr" 			=> "#7f3b08,#b35806,#e08214,#fdb863,#fee0b6,#f7f7f7,#d8daeb,#b2abd2,#8073ac,#542788,#2d004b",      		// Orange - Purple
				"BrBG" 			=> "#543005,#8c510a,#bf812d,#dfc27d,#f6e8c3,#f5f5f5,#c7eae5,#80cdc1,#35978f,#01665e,#003c30",      		// Brown - Green
				"PRGn" 			=> "#40004b,#762a83,#9970ab,#c2a5cf,#e7d4e8,#f7f7f7,#d9f0d3,#a6dba0,#5aae61,#1b7837,#00441b",      		// Purple - Green
				"PiYG" 			=> "#8e0152,#c51b7d,#de77ae,#f1b6da,#fde0ef,#f7f7f7,#e6f5d0,#b8e186,#7fbc41,#4d9221,#276419",      		// Pink - Yellow - Green
				"RdBu" 			=> "#67001f,#b2182b,#d6604d,#f4a582,#fddbc7,#f7f7f7,#d1e5f0,#92c5de,#4393c3,#2166ac,#053061",      		// Red - Blue
				"RdGy" 			=> "#67001f,#b2182b,#d6604d,#f4a582,#fddbc7,#ffffff,#e0e0e0,#bababa,#878787,#4d4d4d,#1a1a1a",      		// Red - Grey
				"RdYlBu" 		=> "#a50026,#d73027,#f46d43,#fdae61,#fee090,#ffffbf,#e0f3f8,#abd9e9,#74add1,#4575b4,#313695",    		// Red - Yellow - Blue
				"Spectral" 		=> "#9e0142,#d53e4f,#f46d43,#fdae61,#fee08b,#ffffbf,#e6f598,#abdda4,#66c2a5,#3288bd,#5e4fa2",  			// Spectral
				"RdYlGn" 		=> "#a50026,#d73027,#f46d43,#fdae61,#fee08b,#ffffbf,#d9ef8b,#a6d96a,#66bd63,#1a9850,#006837",     		// Red - Yellow - Green
				"Accent"		=> "#7fc97f,#beaed4,#fdc086,#ffff99,#386cb0,#f0027f,#bf5b17,#666666",									// Accent
				"Dark2" 		=> "#1b9e77,#d95f02,#7570b3,#e7298a,#66a61e,#e6ab02,#a6761d,#666666",									// Dark
				"Paired" 		=> "#a6cee3,#1f78b4,#b2df8a,#33a02c,#fb9a99,#e31a1c,#fdbf6f,#ff7f00,#cab2d6,#6a3d9a,#ffff99,#b15928",	// Paired
				"Pastel1" 		=> "#fbb4ae,#b3cde3,#ccebc5,#decbe4,#fed9a6,#ffffcc,#e5d8bd,#fddaec,#f2f2f2",							// Pastel 1
				"Pastel2" 		=> "#b3e2cd,#fdcdac,#cbd5e8,#f4cae4,#e6f5c9,#fff2ae,#f1e2cc,#cccccc",									// Pastel 2
				"Set1" 			=> "#e41a1c,#377eb8,#4daf4a,#984ea3,#ff7f00,#ffff33,#a65628,#f781bf,#999999",							// Set 1
				"Set2" 			=> "#66c2a5,#fc8d62,#8da0cb,#e78ac3,#a6d854,#ffd92f,#e5c494,#b3b3b3",									// Set 2
				"Set3" 			=> "#8dd3c7,#ffffb3,#bebada,#fb8072,#80b1d3,#fdb462,#b3de69,#fccde5,#d9d9d9,#bc80bd,#ccebc5,#ffed6f",	// Set 3				
			);
			// Horizontal Pattern
			if ($trianglify_colorsx == "random") {
				//$trianglify_random			= rand(0, count($trianglify_predefined) - 1);
				//$trianglify_allkeys			= array_keys($trianglify_predefined)[$trianglify_random];
				//$trianglify_stringx			= $trianglify_predefined[$trianglify_allkeys];
				$trianglify_stringx				= $trianglify_predefined[array_rand($trianglify_predefined)];
			} else if ($trianglify_colorsx == "custom") {
				$trianglify_array 				= explode(";", $trianglify_generatorx);
				$trianglify_array				= (TS_VCSC_GetContentsBetween($trianglify_array[0], 'color-stop(', ')'));
				$trianglify_stringx				= array();
				$trianglyfy_position			= 0;
				foreach ($trianglify_array as $key => $value) {
					//$trianglify_stringx[]		= "#" . substr($value, (strrpos($value, '#') ? : -1) + 1) . "";
					//$trianglify_stringx[]		= "#" . substr($value, (strrpos($value, '#') ? strrpos($value, '#') : -1) + 1) . "";
					$trianglyfy_position		= TS_VCSC_STRRPOS_String($value, '#', 0);
					$trianglify_stringx[]		= "#" . substr($value, (($trianglyfy_position != false ? $trianglyfy_position : -1) + 1)) . "";
				}
				$trianglify_stringx				= implode(",", $trianglify_stringx);
			} else {
				$trianglify_stringx				= $trianglify_predefined[$trianglify_colorsx];
			}
			// Vertical Pattern
			if ($trianglify_colorsy == "match_x") {
				$trianglify_stringy				= $trianglify_stringx;
			} else {
				if ($trianglify_colorsy == "random") {
					//$trianglify_random		= rand(0, count($trianglify_predefined) - 1);
					//$trianglify_allkeys		= array_keys($trianglify_predefined)[$trianglify_random];
					//$trianglify_stringy		= $trianglify_predefined[$trianglify_allkeys];
					$trianglify_stringy			= $trianglify_predefined[array_rand($trianglify_predefined)];
				} else if ($trianglify_colorsy == "custom") {
					$trianglify_array 			= explode(";", $trianglify_generatory);
					$trianglify_array			= (TS_VCSC_GetContentsBetween($trianglify_array[0], 'color-stop(', ')'));
					$trianglify_stringy			= array();
					$trianglyfy_position		= 0;
					foreach ($trianglify_array as $key => $value) {
						//$trianglify_stringy[]	= "#" . substr($value, (strrpos($value, '#') ? : -1) + 1) . "";
						//$trianglify_stringy[]	= "#" . substr($value, (strrpos($value, '#') ? strrpos($value, '#') : -1) + 1) . "";
						$trianglyfy_position	= TS_VCSC_STRRPOS_String($value, '#', 0);
						$trianglify_stringy[]	= "#" . substr($value, (($trianglyfy_position != false ? $trianglyfy_position : -1) + 1)) . "";
					}
					$trianglify_stringy			= implode(",", $trianglify_stringy);
				} else {
					$trianglify_stringy			= $trianglify_predefined[$trianglify_colorsy];
				}
			}
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-trianglify ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' data-render="' . $trianglify_render . '" data-cellsize="' . $trianglify_cellsize . '" data-variance="' . $trianglify_variance . '" data-colorsx="' . $trianglify_stringx . '" data-colorsy="' . $trianglify_stringy . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-raster="' . $video_raster . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-trianglify-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Single Color Background
		if ($ts_row_bg_effects == "single") {
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-single ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' style="display: none; background-color: ' . $single_color . ';" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-color="' . $single_color . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output					.= $svg_top_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= '</div>';
		}
		
		// Gradient Background
		if ($ts_row_bg_effects == "gradient") {
			if ($gradiant_advanced == 'false') {
				$gradient_css_attr[] 	= 'background: ' . $gradient_color_start . '';
				$gradient_css_attr[] 	= 'background: -moz-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: -webkit-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: -o-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: -ms-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr 		= implode('; ', $gradient_css_attr);
			} else {
				$gradient_css_attr		= $gradient_generator;
			}
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-gradient ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' ' . $kenburns_string . ' style="display: none; ' . ($ts_row_kenburns_animation == 'null' ? $gradient_css_attr : '') . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				if ($ts_row_kenburns_animation != 'null') {
					$output 			.= '<div class="ts-background-kenburns-wrapper"><div class="ts-background-kenburns-parent"><div class="ts-background-kenburns-image ' . $kenburns_animation . '" style="' . $gradient_css_attr . '"></div></div></div>';
				}
				$output					.= $svg_top_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= '</div>';
		}
		
		
		if ($frontend_edit == "false") {
			echo $output;
		}
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	
	if (!function_exists('vc_theme_before_vc_row')){
		function vc_theme_before_vc_row($atts, $content = null) {
			return apply_filters( 'TS_VCSC_ComposerRowAdditions_Filter', '', $atts, $content );
		}
	}
	if (!function_exists('vc_theme_before_vc_row_inner')){
		function vc_theme_before_vc_row_inner($atts, $content = null){
			return apply_filters( 'TS_VCSC_ComposerRowAdditions_Filter', '', $atts, $content );
		}
	}
?>
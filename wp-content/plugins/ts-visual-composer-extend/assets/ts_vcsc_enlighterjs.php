<?php
	global $VISUAL_COMPOSER_EXTENSIONS;

	if (isset($_POST['Submit'])) {
		echo '<div id="ts_vcsc_extend_settings_save" style="margin: 20px auto 20px auto; width: 128px; height: 128px;">';
			echo '<img style="width: 128px; height: 128px;" src="' . TS_VCSC_GetResourceURL('images/other/ajax_loader.gif') . '">';
		echo '</div>';
		
		// General Font Settings
		$General_Font_Size 				= intval(((isset($_POST['ts_vcsc_extend_settings_general_fontsize'])) 					?	$_POST['ts_vcsc_extend_settings_general_fontsize'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["size"]));
		$General_Line_Height 			= intval(((isset($_POST['ts_vcsc_extend_settings_general_lineheight'])) 				?	$_POST['ts_vcsc_extend_settings_general_lineheight'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["height"]));
		$General_Font_Type				= ((isset($_POST['ts_vcsc_extend_settings_general_fonttype'])) 							?	$_POST['ts_vcsc_extend_settings_general_fonttype'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["type"]);
		$General_Font_Color				= ((isset($_POST['ts_vcsc_extend_settings_general_fontcolor'])) 						?	$_POST['ts_vcsc_extend_settings_general_fontcolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["color"]);
		$General_Background				= ((isset($_POST['ts_vcsc_extend_settings_general_background'])) 						?	$_POST['ts_vcsc_extend_settings_general_background'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["background"]);
		$General_Border_Width			= intval(((isset($_POST['ts_vcsc_extend_settings_general_borderwidth'])) 				?	$_POST['ts_vcsc_extend_settings_general_borderwidth'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["borderwidth"]));
		$General_Border_Type			= ((isset($_POST['ts_vcsc_extend_settings_general_bordertype'])) 						?	$_POST['ts_vcsc_extend_settings_general_bordertype'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["bordertype"]);
		$General_Border_Color			= ((isset($_POST['ts_vcsc_extend_settings_general_bordercolor'])) 						?	$_POST['ts_vcsc_extend_settings_general_bordercolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["bordercolor"]);
		// Line Number Settings
		$Lines_Font_Size 				= intval(((isset($_POST['ts_vcsc_extend_settings_lines_fontsize'])) 					?	$_POST['ts_vcsc_extend_settings_lines_fontsize'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["size"]));
		$Lines_Font_Type				= ((isset($_POST['ts_vcsc_extend_settings_lines_fonttype'])) 							?	$_POST['ts_vcsc_extend_settings_lines_fonttype'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["type"]);
		$Lines_Font_Color				= ((isset($_POST['ts_vcsc_extend_settings_lines_fontcolor'])) 							?	$_POST['ts_vcsc_extend_settings_lines_fontcolor'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["color"]);
		$Lines_Background				= ((isset($_POST['ts_vcsc_extend_settings_lines_background'])) 							?	$_POST['ts_vcsc_extend_settings_lines_background'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["background"]);
		$Lines_Border_Width				= intval(((isset($_POST['ts_vcsc_extend_settings_lines_borderwidth'])) 					?	$_POST['ts_vcsc_extend_settings_lines_borderwidth'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["borderwidth"]));
		$Lines_Border_Type				= ((isset($_POST['ts_vcsc_extend_settings_lines_bordertype'])) 							?	$_POST['ts_vcsc_extend_settings_lines_bordertype'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["bordertype"]);
		$Lines_Border_Color				= ((isset($_POST['ts_vcsc_extend_settings_lines_bordercolor'])) 						?	$_POST['ts_vcsc_extend_settings_lines_bordercolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["bordercolor"]);
		// Original Code Settings
		$Original_Font_Size				= intval(((isset($_POST['ts_vcsc_extend_settings_original_fontsize'])) 					?	$_POST['ts_vcsc_extend_settings_original_fontsize'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["size"]));
		$Original_Line_Height			= intval(((isset($_POST['ts_vcsc_extend_settings_original_lineheight'])) 				?	$_POST['ts_vcsc_extend_settings_original_lineheight'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["height"]));
		$Original_Font_Type				= ((isset($_POST['ts_vcsc_extend_settings_original_fonttype'])) 						?	$_POST['ts_vcsc_extend_settings_original_fonttype'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["type"]);
		$Original_Font_Color			= ((isset($_POST['ts_vcsc_extend_settings_original_fontcolor'])) 						?	$_POST['ts_vcsc_extend_settings_original_fontcolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["color"]);
		$Original_Background			= ((isset($_POST['ts_vcsc_extend_settings_original_background'])) 						?	$_POST['ts_vcsc_extend_settings_original_background'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["background"]);
		// Special Styles
		$Special_Highlight				= ((isset($_POST['ts_vcsc_extend_settings_special_highlight'])) 						?	$_POST['ts_vcsc_extend_settings_special_highlight'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["highlight"]);
		$Special_Hover					= ((isset($_POST['ts_vcsc_extend_settings_special_hover'])) 							?	$_POST['ts_vcsc_extend_settings_special_hover'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["hover"]);
		// Segment Styles
		$Segment_Keytype1_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype1_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype1_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["color"]);
		$Segment_Keytype1_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype1_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype1_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["background"]);
		$Segment_Keytype1_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype1_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype1_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["weight"]);
		$Segment_Keytype1_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype1_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype1_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["decoration"]);
		$Segment_Keytype2_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype2_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype2_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["color"]);
		$Segment_Keytype2_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype2_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype2_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["background"]);
		$Segment_Keytype2_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype2_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype2_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["weight"]);
		$Segment_Keytype2_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype2_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype2_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["decoration"]);
		$Segment_Keytype3_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype3_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype3_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["color"]);
		$Segment_Keytype3_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype3_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype3_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["background"]);
		$Segment_Keytype3_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype3_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype3_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["weight"]);
		$Segment_Keytype3_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype3_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype3_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["decoration"]);
		$Segment_Keytype4_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype4_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype4_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["color"]);
		$Segment_Keytype4_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype4_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype4_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["background"]);
		$Segment_Keytype4_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype4_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_keytype4_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["weight"]);
		$Segment_Keytype4_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_keytype4_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_keytype4_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["decoration"]);
		$Segment_Comments1_Color		= ((isset($_POST['ts_vcsc_extend_settings_segment_comments1_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_comments1_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["color"]);
		$Segment_Comments1_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_comments1_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_comments1_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["background"]);
		$Segment_Comments1_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_comments1_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_comments1_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["weight"]);
		$Segment_Comments1_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_comments1_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_comments1_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["decoration"]);
		$Segment_Comments2_Color		= ((isset($_POST['ts_vcsc_extend_settings_segment_comments2_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_comments2_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments2"]["color"]);
		$Segment_Comments2_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_comments2_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_comments2_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["background"]);
		$Segment_Comments2_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_comments2_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_comments2_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments2"]["weight"]);
		$Segment_Comments2_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_comments2_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_comments2_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments2"]["decoration"]);
		$Segment_Chaintype1_Color		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype1_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_chaintype1_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["color"]);
		$Segment_Chaintype1_Back		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype1_background'])) 			?	$_POST['ts_vcsc_extend_settings_segment_chaintype1_background'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["background"]);
		$Segment_Chaintype1_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype1_weight'])) 				?	$_POST['ts_vcsc_extend_settings_segment_chaintype1_weight'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["weight"]);
		$Segment_Chaintype1_Deco		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype1_decoration'])) 			?	$_POST['ts_vcsc_extend_settings_segment_chaintype1_decoration'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["decoration"]);
		$Segment_Chaintype2_Color		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype2_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_chaintype2_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["color"]);
		$Segment_Chaintype2_Back		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype2_background'])) 			?	$_POST['ts_vcsc_extend_settings_segment_chaintype2_background'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["background"]);
		$Segment_Chaintype2_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype2_weight'])) 				?	$_POST['ts_vcsc_extend_settings_segment_chaintype2_weight'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["weight"]);
		$Segment_Chaintype2_Deco		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype2_decoration'])) 			?	$_POST['ts_vcsc_extend_settings_segment_chaintype2_decoration'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["decoration"]);
		$Segment_Chaintype3_Color		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype3_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_chaintype3_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["color"]);
		$Segment_Chaintype3_Back		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype3_background'])) 			?	$_POST['ts_vcsc_extend_settings_segment_chaintype3_background'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["background"]);
		$Segment_Chaintype3_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype3_weight'])) 				?	$_POST['ts_vcsc_extend_settings_segment_chaintype3_weight'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["weight"]);
		$Segment_Chaintype3_Deco		= ((isset($_POST['ts_vcsc_extend_settings_segment_chaintype3_decoration'])) 			?	$_POST['ts_vcsc_extend_settings_segment_chaintype3_decoration'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["decoration"]);
		$Segment_Numbers_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_numbers_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_numbers_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["color"]);
		$Segment_Numbers_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_numbers_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_numbers_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["background"]);
		$Segment_Numbers_Weight			= ((isset($_POST['ts_vcsc_extend_settings_segment_numbers_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_numbers_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["weight"]);
		$Segment_Numbers_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_numbers_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_numbers_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["decoration"]);
		$Segment_Methodstype1_Color		= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype1_color'])) 				?	$_POST['ts_vcsc_extend_settings_segment_methodstype1_color'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["color"]);
		$Segment_Methodstype1_Back		= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype1_background'])) 			?	$_POST['ts_vcsc_extend_settings_segment_methodstype1_background'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["background"]);
		$Segment_Methodstype1_Weight	= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype1_weight'])) 				?	$_POST['ts_vcsc_extend_settings_segment_methodstype1_weight'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["weight"]);
		$Segment_Methodstype1_Deco		= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype1_decoration'])) 			?	$_POST['ts_vcsc_extend_settings_segment_methodstype1_decoration'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["decoration"]);
		$Segment_Methodstype2_Color		= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype2_color'])) 				?	$_POST['ts_vcsc_extend_settings_segment_methodstype2_color'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["color"]);
		$Segment_Methodstype2_Back		= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype2_background'])) 			?	$_POST['ts_vcsc_extend_settings_segment_methodstype2_background'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["background"]);
		$Segment_Methodstype2_Weight	= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype2_weight'])) 				?	$_POST['ts_vcsc_extend_settings_segment_methodstype2_weight'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["weight"]);
		$Segment_Methodstype2_Deco		= ((isset($_POST['ts_vcsc_extend_settings_segment_methodstype2_decoration'])) 			?	$_POST['ts_vcsc_extend_settings_segment_methodstype2_decoration'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["decoration"]);
		$Segment_Brackets_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_brackets_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_brackets_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["color"]);
		$Segment_Brackets_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_brackets_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_brackets_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["background"]);
		$Segment_Brackets_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_brackets_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_brackets_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["weight"]);
		$Segment_Brackets_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_brackets_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_brackets_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["decoration"]);
		$Segment_Symbols_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_symbols_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_symbols_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["color"]);
		$Segment_Symbols_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_symbols_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_symbols_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["background"]);
		$Segment_Symbols_Weight			= ((isset($_POST['ts_vcsc_extend_settings_segment_symbols_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_symbols_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["weight"]);
		$Segment_Symbols_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_symbols_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_symbols_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["decoration"]);
		$Segment_Escape_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_escape_color'])) 						?	$_POST['ts_vcsc_extend_settings_segment_escape_color'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["color"]);
		$Segment_Escape_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_escape_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_escape_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["background"]);
		$Segment_Escape_Weight			= ((isset($_POST['ts_vcsc_extend_settings_segment_escape_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_escape_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["weight"]);
		$Segment_Escape_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_escape_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_escape_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["decoration"]);
		$Segment_Regex_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_regex_color'])) 						?	$_POST['ts_vcsc_extend_settings_segment_regex_color'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["color"]);
		$Segment_Regex_Back				= ((isset($_POST['ts_vcsc_extend_settings_segment_regex_background'])) 					?	$_POST['ts_vcsc_extend_settings_segment_regex_background'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["background"]);
		$Segment_Regex_Weight			= ((isset($_POST['ts_vcsc_extend_settings_segment_regex_weight'])) 						?	$_POST['ts_vcsc_extend_settings_segment_regex_weight'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["weight"]);
		$Segment_Regex_Deco				= ((isset($_POST['ts_vcsc_extend_settings_segment_regex_decoration'])) 					?	$_POST['ts_vcsc_extend_settings_segment_regex_decoration'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["decoration"]);
		$Segment_Sepstart_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstart_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_sepstart_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["color"]);
		$Segment_Sepstart_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstart_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_sepstart_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["background"]);
		$Segment_Sepstart_Weight		= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstart_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_sepstart_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["weight"]);
		$Segment_Sepstart_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstart_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_sepstart_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["decoration"]);
		$Segment_Sepstop_Color			= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstop_color'])) 					?	$_POST['ts_vcsc_extend_settings_segment_sepstop_color'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["color"]);
		$Segment_Sepstop_Back			= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstop_background'])) 				?	$_POST['ts_vcsc_extend_settings_segment_sepstop_background'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["background"]);
		$Segment_Sepstop_Weight			= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstop_weight'])) 					?	$_POST['ts_vcsc_extend_settings_segment_sepstop_weight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["weight"]);
		$Segment_Sepstop_Deco			= ((isset($_POST['ts_vcsc_extend_settings_segment_sepstop_decoration'])) 				?	$_POST['ts_vcsc_extend_settings_segment_sepstop_decoration'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["decoration"]);
		// Controls Settings
		$Controls_Background			= ((isset($_POST['ts_vcsc_extend_settings_controls_background'])) 						?	$_POST['ts_vcsc_extend_settings_controls_background'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Controls"]["background"]);
		// Button Settings
		$Buttons_Font_Size 				= intval(((isset($_POST['ts_vcsc_extend_settings_buttons_fontsize'])) 					?	$_POST['ts_vcsc_extend_settings_buttons_fontsize'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["size"]));
		$Buttons_Font_Type				= ((isset($_POST['ts_vcsc_extend_settings_buttons_fonttype'])) 							?	$_POST['ts_vcsc_extend_settings_buttons_fonttype'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["type"]);
		$Buttons_Font_Color 			= ((isset($_POST['ts_vcsc_extend_settings_buttons_fontcolor'])) 						?	$_POST['ts_vcsc_extend_settings_buttons_fontcolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["color"]);
		$Buttons_Background 			= ((isset($_POST['ts_vcsc_extend_settings_buttons_background'])) 						?	$_POST['ts_vcsc_extend_settings_buttons_background'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["background"]);
		$Buttons_Border_Width 			= intval(((isset($_POST['ts_vcsc_extend_settings_buttons_borderwidth'])) 				?	$_POST['ts_vcsc_extend_settings_buttons_borderwidth'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["borderwidth"]));
		$Buttons_Border_Type 			= ((isset($_POST['ts_vcsc_extend_settings_buttons_bordertype'])) 						?	$_POST['ts_vcsc_extend_settings_buttons_bordertype'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["bordertype"]);
		$Buttons_Border_Color 			= ((isset($_POST['ts_vcsc_extend_settings_buttons_bordercolor'])) 						?	$_POST['ts_vcsc_extend_settings_buttons_bordercolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["bordercolor"]);
		// Selected Settings
		$Selected_Font_Color 			= ((isset($_POST['ts_vcsc_extend_settings_selected_fontcolor'])) 						?	$_POST['ts_vcsc_extend_settings_selected_fontcolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["color"]);
		$Selected_Background 			= ((isset($_POST['ts_vcsc_extend_settings_selected_background'])) 						?	$_POST['ts_vcsc_extend_settings_selected_background'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["background"]);
		$Selected_Border_Color 			= ((isset($_POST['ts_vcsc_extend_settings_selected_bordercolor'])) 						?	$_POST['ts_vcsc_extend_settings_selected_bordercolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["bordercolor"]);
		// Hover Settings
		$Hover_Font_Color 				= ((isset($_POST['ts_vcsc_extend_settings_hover_fontcolor'])) 							?	$_POST['ts_vcsc_extend_settings_hover_fontcolor'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["color"]);
		$Hover_Background 				= ((isset($_POST['ts_vcsc_extend_settings_hover_background'])) 							?	$_POST['ts_vcsc_extend_settings_hover_background'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["background"]);
		$Hover_Border_Color 			= ((isset($_POST['ts_vcsc_extend_settings_hover_bordercolor'])) 						?	$_POST['ts_vcsc_extend_settings_hover_bordercolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["bordercolor"]);

		
		$TS_VCENLIGHTER_Build_CustomTheme = array (
			// General Styles
			'General'			=> array('type' => $General_Font_Type, 'size' => $General_Font_Size, 'height' => $General_Line_Height, 'color' => $General_Font_Color, 'background' => $General_Background, 'borderwidth' => $General_Border_Width, 'bordercolor' => $General_Border_Color, 'bordertype' => $General_Border_Type),
			// Line Number Styles
			'Lines'				=> array('type' => $Lines_Font_Type, 'size' => $Lines_Font_Size, 'color' => $Lines_Font_Color, 'background' => $Lines_Background, 'borderwidth' => $Lines_Border_Width, 'bordercolor' => $Lines_Border_Color, 'bordertype' => $Lines_Border_Type),
			// Original Code Styles	
			'Original'			=> array('type' => $Original_Font_Type, 'size' => $Original_Font_Size, 'height' => $Original_Line_Height, 'color' => $Original_Font_Color, 'background' => $Original_Background),
			// Special Styles
			'Special'			=> array('highlight' => $Special_Highlight, 'hover' => $Special_Hover),
			// Segment Styles
			'Keytype1'			=> array('color' => $Segment_Keytype1_Color, 'background' => $Segment_Keytype1_Back, 'weight' => $Segment_Keytype1_Weight, 'decoration' => $Segment_Keytype1_Deco),
			'Keytype2'			=> array('color' => $Segment_Keytype2_Color, 'background' => $Segment_Keytype2_Back, 'weight' => $Segment_Keytype2_Weight, 'decoration' => $Segment_Keytype2_Deco),
			'Keytype3'			=> array('color' => $Segment_Keytype3_Color, 'background' => $Segment_Keytype3_Back, 'weight' => $Segment_Keytype3_Weight, 'decoration' => $Segment_Keytype3_Deco),
			'Keytype4'			=> array('color' => $Segment_Keytype4_Color, 'background' => $Segment_Keytype4_Back, 'weight' => $Segment_Keytype4_Weight, 'decoration' => $Segment_Keytype4_Deco),		
			'Comments1'			=> array('color' => $Segment_Comments1_Color, 'background' => $Segment_Comments1_Back, 'weight' => $Segment_Comments1_Weight, 'decoration' => $Segment_Comments1_Deco),
			'Comments2'			=> array('color' => $Segment_Comments2_Color, 'background' => $Segment_Comments2_Back, 'weight' => $Segment_Comments2_Weight, 'decoration' => $Segment_Comments2_Deco),
			'Chaintype1'		=> array('color' => $Segment_Chaintype1_Color, 'background' => $Segment_Chaintype1_Back, 'weight' => $Segment_Chaintype1_Weight, 'decoration' => $Segment_Chaintype1_Deco),
			'Chaintype2'		=> array('color' => $Segment_Chaintype2_Color, 'background' => $Segment_Chaintype2_Back, 'weight' => $Segment_Chaintype2_Weight, 'decoration' => $Segment_Chaintype2_Deco),
			'Chaintype3'		=> array('color' => $Segment_Chaintype3_Color, 'background' => $Segment_Chaintype3_Back, 'weight' => $Segment_Chaintype3_Weight, 'decoration' => $Segment_Chaintype3_Deco),
			'Numbers'			=> array('color' => $Segment_Numbers_Color, 'background' => $Segment_Numbers_Back, 'weight' => $Segment_Numbers_Weight, 'decoration' => $Segment_Numbers_Deco),
			'Methodstype1'		=> array('color' => $Segment_Methodstype1_Color, 'background' => $Segment_Methodstype1_Back, 'weight' => $Segment_Methodstype1_Weight, 'decoration' => $Segment_Methodstype1_Deco),
			'Methodstype2'		=> array('color' => $Segment_Methodstype2_Color, 'background' => $Segment_Methodstype2_Back, 'weight' => $Segment_Methodstype2_Weight, 'decoration' => $Segment_Methodstype2_Deco),
			'Brackets'			=> array('color' => $Segment_Brackets_Color, 'background' => $Segment_Brackets_Back, 'weight' => $Segment_Brackets_Weight, 'decoration' => $Segment_Brackets_Deco),
			'Symbols'			=> array('color' => $Segment_Symbols_Color, 'background' => $Segment_Symbols_Back, 'weight' => $Segment_Symbols_Weight, 'decoration' => $Segment_Symbols_Deco),
			'Escape'			=> array('color' => $Segment_Escape_Color, 'background' => $Segment_Escape_Back, 'weight' => $Segment_Escape_Weight, 'decoration' => $Segment_Escape_Deco),
			'Regex'				=> array('color' => $Segment_Regex_Color, 'background' => $Segment_Regex_Back, 'weight' => $Segment_Regex_Weight, 'decoration' => $Segment_Regex_Deco),
			'Sepstart'			=> array('color' => $Segment_Sepstart_Color, 'background' => $Segment_Sepstart_Back, 'weight' => $Segment_Sepstart_Weight, 'decoration' => $Segment_Sepstart_Deco),
			'Sepstop'			=> array('color' => $Segment_Sepstop_Color, 'background' => $Segment_Sepstop_Back, 'weight' => $Segment_Sepstop_Weight, 'decoration' => $Segment_Sepstop_Deco),
			// Group Styles
			'Controls'          => array('background' => $Controls_Background),
			'Buttons'           => array('type' => $Buttons_Font_Type, 'size' => $Buttons_Font_Size, 'color' => $Buttons_Font_Color, 'background' => $Buttons_Background, 'borderwidth' => $Buttons_Border_Width, 'bordercolor' => $Buttons_Border_Color, 'bordertype' => $Buttons_Border_Type),
			'Selected'          => array('color' => $Selected_Font_Color, 'background' => $Selected_Background, 'bordercolor' => $Selected_Border_Color),
			'Hover'             => array('color' => $Hover_Font_Color, 'background' => $Hover_Background, 'bordercolor' => $Hover_Border_Color),
		);
		update_option('ts_vcsc_extend_settings_customTheme', $TS_VCENLIGHTER_Build_CustomTheme);
		
		echo '<script> window.location="' . $_SERVER['REQUEST_URI'] . '"; </script> ';
		//Header('Location: '.$_SERVER['REQUEST_URI']);
		Exit();
	} else {
		$TS_VCENLIGHTER_Custom_Theme	= get_option('ts_vcsc_extend_settings_customTheme', $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme);

		// General Font Settings		
		$General_Font_Size 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["size"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["size"]);
		$General_Line_Height 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["height"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["height"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["height"]);
		$General_Font_Type				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["type"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["type"]);
		$General_Font_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["color"]);
		$General_Background 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["background"]);
		$General_Border_Width 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["borderwidth"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["borderwidth"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["borderwidth"]);
		$General_Border_Type 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["bordertype"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["bordertype"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["bordertype"]);
		$General_Border_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["General"]["bordercolor"]))) ? $TS_VCENLIGHTER_Custom_Theme["General"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["bordercolor"]);
		// Line Number Settings
		$Lines_Font_Size 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Lines"]["size"]))) ? $TS_VCENLIGHTER_Custom_Theme["Lines"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["size"]);
		$Lines_Font_Type 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Lines"]["type"]))) ? $TS_VCENLIGHTER_Custom_Theme["Lines"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["type"]);
		$Lines_Font_Color 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Lines"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Lines"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["color"]);
		$Lines_Background 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Lines"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Lines"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["background"]);
		$Lines_Border_Width 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Lines"]["borderwidth"]))) ? $TS_VCENLIGHTER_Custom_Theme["Lines"]["borderwidth"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["borderwidth"]);
		$Lines_Border_Type 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Lines"]["bordertype"]))) ? $TS_VCENLIGHTER_Custom_Theme["Lines"]["bordertype"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["bordertype"]);
		$Lines_Border_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Lines"]["bordercolor"]))) ? $TS_VCENLIGHTER_Custom_Theme["Lines"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["bordercolor"]);
		// Original Code Settings
		$Original_Font_Size 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Original"]["size"]))) ? $TS_VCENLIGHTER_Custom_Theme["Original"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["size"]);
		$Original_Line_Height 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Original"]["height"]))) ? $TS_VCENLIGHTER_Custom_Theme["Original"]["height"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["height"]);
		$Original_Font_Type				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Original"]["type"]))) ? $TS_VCENLIGHTER_Custom_Theme["Original"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["type"]);
		$Original_Font_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Original"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Original"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["color"]);
		$Original_Background 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Original"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Original"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["background"]);
		// Special Styles
		$Special_Highlight 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Special"]["highlight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Special"]["highlight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["highlight"]);
		$Special_Hover 					= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Special"]["hover"]))) ? $TS_VCENLIGHTER_Custom_Theme["Special"]["hover"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["hover"]);
		// Segment Styles
		$Segment_Keytype1_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype1"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype1"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["color"]);
		$Segment_Keytype1_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype1"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype1"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["background"]);
		$Segment_Keytype1_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype1"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype1"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["weight"]);
		$Segment_Keytype1_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype1"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype1"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype1"]["decoration"]);
		$Segment_Keytype2_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype2"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype2"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["color"]);
		$Segment_Keytype2_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype2"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype2"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["background"]);
		$Segment_Keytype2_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype2"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype2"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["weight"]);
		$Segment_Keytype2_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype2"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype2"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype2"]["decoration"]);
		$Segment_Keytype3_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype3"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype3"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["color"]);
		$Segment_Keytype3_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype3"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype3"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["background"]);
		$Segment_Keytype3_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype3"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype3"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["weight"]);
		$Segment_Keytype3_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype3"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype3"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype3"]["decoration"]);
		$Segment_Keytype4_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype4"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype4"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["color"]);
		$Segment_Keytype4_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype4"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype4"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["background"]);
		$Segment_Keytype4_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype4"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype4"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["weight"]);
		$Segment_Keytype4_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Keytype4"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Keytype4"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Keytype4"]["decoration"]);
		$Segment_Comments1_Color		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments1"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments1"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["color"]);
		$Segment_Comments1_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments1"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments1"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["background"]);
		$Segment_Comments1_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments1"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments1"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["weight"]);
		$Segment_Comments1_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments1"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments1"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["decoration"]);
		$Segment_Comments2_Color		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments2"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments2"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments2"]["color"]);
		$Segment_Comments2_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments2"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments2"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments1"]["background"]);
		$Segment_Comments2_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments2"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments2"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments2"]["weight"]);
		$Segment_Comments2_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Comments2"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Comments2"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Comments2"]["decoration"]);
		$Segment_Chaintype1_Color		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["color"]);
		$Segment_Chaintype1_Back		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["background"]);
		$Segment_Chaintype1_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["weight"]);
		$Segment_Chaintype1_Deco		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype1"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype1"]["decoration"]);
		$Segment_Chaintype2_Color		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["color"]);
		$Segment_Chaintype2_Back		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["background"]);
		$Segment_Chaintype2_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["weight"]);
		$Segment_Chaintype2_Deco		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype2"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype2"]["decoration"]);
		$Segment_Chaintype3_Color		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["color"]);
		$Segment_Chaintype3_Back		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["background"]);
		$Segment_Chaintype3_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["weight"]);
		$Segment_Chaintype3_Deco		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Chaintype3"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Chaintype3"]["decoration"]);
		$Segment_Numbers_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Numbers"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Numbers"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["color"]);
		$Segment_Numbers_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Numbers"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Numbers"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["background"]);
		$Segment_Numbers_Weight			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Numbers"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Numbers"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["weight"]);
		$Segment_Numbers_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Numbers"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Numbers"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Numbers"]["decoration"]);
		$Segment_Methodstype1_Color		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["color"]);
		$Segment_Methodstype1_Back		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["background"]);
		$Segment_Methodstype1_Weight	= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["weight"]);
		$Segment_Methodstype1_Deco		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype1"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype1"]["decoration"]);
		$Segment_Methodstype2_Color		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["color"]);
		$Segment_Methodstype2_Back		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["background"]);
		$Segment_Methodstype2_Weight	= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["weight"]);
		$Segment_Methodstype2_Deco		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Methodstype2"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Methodstype2"]["decoration"]);
		$Segment_Brackets_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Brackets"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Brackets"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["color"]);
		$Segment_Brackets_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Brackets"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Brackets"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["background"]);
		$Segment_Brackets_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Brackets"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Brackets"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["weight"]);
		$Segment_Brackets_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Brackets"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Brackets"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Brackets"]["decoration"]);
		$Segment_Symbols_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Symbols"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Symbols"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["color"]);
		$Segment_Symbols_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Symbols"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Symbols"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["background"]);
		$Segment_Symbols_Weight			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Symbols"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Symbols"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["weight"]);
		$Segment_Symbols_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Symbols"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Symbols"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Symbols"]["decoration"]);
		$Segment_Escape_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Escape"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Escape"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["color"]);
		$Segment_Escape_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Escape"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Escape"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["background"]);
		$Segment_Escape_Weight			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Escape"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Escape"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["weight"]);
		$Segment_Escape_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Escape"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Escape"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Escape"]["decoration"]);
		$Segment_Regex_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Regex"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Regex"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["color"]);
		$Segment_Regex_Back				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Regex"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Regex"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["background"]);
		$Segment_Regex_Weight			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Regex"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Regex"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["weight"]);
		$Segment_Regex_Deco				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Regex"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Regex"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Regex"]["decoration"]);
		$Segment_Sepstart_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstart"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstart"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["color"]);
		$Segment_Sepstart_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstart"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstart"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["background"]);
		$Segment_Sepstart_Weight		= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstart"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstart"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["weight"]);
		$Segment_Sepstart_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstart"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstart"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstart"]["decoration"]);
		$Segment_Sepstop_Color			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstop"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstop"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["color"]);
		$Segment_Sepstop_Back			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstop"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstop"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["background"]);
		$Segment_Sepstop_Weight			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstop"]["weight"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstop"]["weight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["weight"]);
		$Segment_Sepstop_Deco			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Sepstop"]["decoration"]))) ? $TS_VCENLIGHTER_Custom_Theme["Sepstop"]["decoration"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Sepstop"]["decoration"]);
		// Controls Settings
		$Controls_Background 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Controls"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Controls"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Controls"]["background"]);
		// Button Settings
		$Buttons_Font_Size 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Buttons"]["size"]))) ? $TS_VCENLIGHTER_Custom_Theme["Buttons"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["size"]);
		$Buttons_Font_Type				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Buttons"]["type"]))) ? $TS_VCENLIGHTER_Custom_Theme["Buttons"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["type"]);		
		$Buttons_Font_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Buttons"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Buttons"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["color"]);
		$Buttons_Background 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Buttons"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Buttons"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["background"]);
		$Buttons_Border_Width 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Buttons"]["borderwidth"]))) ? $TS_VCENLIGHTER_Custom_Theme["Buttons"]["borderwidth"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["borderwidth"]);
		$Buttons_Border_Type 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Buttons"]["bordertype"]))) ? $TS_VCENLIGHTER_Custom_Theme["Buttons"]["bordertype"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["bordertype"]);
		$Buttons_Border_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Buttons"]["bordercolor"]))) ? $TS_VCENLIGHTER_Custom_Theme["Buttons"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["bordercolor"]);
		// Selected Settings
		$Selected_Font_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Selected"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Selected"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["color"]);
		$Selected_Background 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Selected"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Selected"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["background"]);
		$Selected_Border_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Selected"]["bordercolor"]))) ? $TS_VCENLIGHTER_Custom_Theme["Selected"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["bordercolor"]);
		// Hover Settings
		$Hover_Font_Color 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Hover"]["color"]))) ? $TS_VCENLIGHTER_Custom_Theme["Hover"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["color"]);
		$Hover_Background 				= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Hover"]["background"]))) ? $TS_VCENLIGHTER_Custom_Theme["Hover"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["background"]);
		$Hover_Border_Color 			= (((is_array($TS_VCENLIGHTER_Custom_Theme)) && (isset($TS_VCENLIGHTER_Custom_Theme["Hover"]["bordercolor"]))) ? $TS_VCENLIGHTER_Custom_Theme["Hover"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["bordercolor"]);
	}
?>
<form class="ts-vcsc-enlighterjs-manager-wrap" name="oscimp_form" method="post" autocomplete="off" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<div id="ts-settings-about" class="tab-content">
		<div class="ts-vcsc-settings-group-header">
			<div class="display_header">
				<h2><span class="dashicons dashicons-editor-code"></span>Visual Composer Extensions - EnlighterJS (Syntax Highlighter)</h2>
			</div>
			<div class="clear"></div>
		</div>
		<div class="ts-vcsc-settings-group-topbar ts-vcsc-settings-group-buttonbar">
			<a href="javascript:void(0);" class="ts-vcsc-settings-group-toggle" style="display: none;">Expand</a>
			<div class="ts-vcsc-settings-group-actionbar">
				<input title="Click here to save your custom theme for the syntax highlighter." type="submit" name="Submit" id="ts_vcsc_extend_settings_submit_1" class="button button-primary" value="Save Custom Theme">
			</div>
			<div class="clear"></div>
		</div>		
		<div class="ts-vcsc-settings-enlighterjs-main">
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-art"></i>Custom Theme Settings</div>
				<div class="ts-vcsc-section-content">
					<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; margin-bottom: 20px; font-size: 13px; text-align: justify;">
						The syntax highlighter already includes multiple different themes that can be used to highlight code snippets. This page will allow you to define a custom theme (based on the settings for the default
						theme "Enlighter"that can be used alongside the default themes. The code snippet below will show you a preview of your current settings for the custom theme style. Use the provided button to update the
						preview based on your current selections, or save the settings.
					</div>
					<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; margin-bottom: 20px; font-size: 13px; font-weight: bold; text-align: justify;">
						If no changes are made to the settings below, the styling of this custom theme will equal the styling of the default theme "Enlighter".
					</div>
					<div id="ts-enlighterjs-container-update" class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;">Update Preview</div>			
					<div id="ts-enlighterjs-container-preview" class="ts-enlighterjs-container-preview ts-enlighterjs-container-group-enabled" style="width: 100%; margin: 20px 0 0 0;" data-enlighter-doubleclick="true" data-enlighter-windowbutton="true" data-enlighter-windowtext="New Window" data-enlighter-rawbutton="true" data-enlighter-rawtext="RAW Code" data-enlighter-infobutton="false" data-enlighter-infotext="EnlighterJS" data-enlighter-indent="2">
						<pre id="ts-enlighterjs-pre-preview" style="white-space: pre-wrap; height: 100%; margin: 0; padding: 0;" data-enlighter-language="javascript" data-enlighter-theme="custom" data-enlighter-group="PreviewGroup" data-enlighter-title="JavaScript" data-enlighter-linenumbers="true" data-enlighter-lineoffset="1" data-enlighter-highlight="5-6">
			var options = {
				language : 'javascript',
				theme : 'Eclipse',
				indent : 2,
				forceTheme: false,
				rawButton: false,
				showLinenumbers: false,
				renderer: 'Inline'
			};
					
			// Initialize EnlighterJS - use inline-highlighting only
			EnlighterJS.Util.Init(null, 'code', options);
						</pre>
						<pre id="ts-enlighterjs-pre-preview" style="white-space: pre-wrap; height: 100%; margin: 0; padding: 0;" data-enlighter-language="css" data-enlighter-theme="custom" data-enlighter-group="PreviewGroup" data-enlighter-title="CSS Styles" data-enlighter-linenumbers="true" data-enlighter-lineoffset="1" data-enlighter-highlight="5-6">
			/* BASE Styles */
			.EnlighterJS {
				font-family: Monaco, Courier, Monospace;
				font-size: 10px;
				line-height: 16px;
				overflow: auto;
				white-space: pre-wrap;
				word-wrap: break-word;
				margin: 0px;
				padding: 0px;
			}
			
			/* Inline specific styles */
			span.EnlighterJS {
				padding: 3px 5px 1px 5px;
				border: solid 1px #e0e0e0;
				color: #333333;
				background-color: #f7f7f7;
				margin: 0px 2px 0px 2px;
			}
						</pre>
					</div>
				</div>
			</div>	
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-generic"></i>General Style Settings</div>
				<div class="ts-vcsc-section-content slideFade" style="display: none;">
					<div style="margin-top: 10px; display: block; width: 100%; float: left;">
						<div class="ts-nouislider-input-slider" style="">
							<h4>Font Size:</h4>
							<p style="font-size: 12px;">Define the general font size:</p>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_general_fontsize" id="ts_vcsc_extend_settings_general_fontsize" class="ts_vcsc_extend_settings_general_fontsize ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $General_Font_Size; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_general_fontsize_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $General_Font_Size; ?>" data-min="10" data-max="50" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>
					<div style="margin-top: 20px; display: block; width: 100%; float: left;">
						<div class="ts-nouislider-input-slider" style="">
							<h4>Line Height:</h4>
							<p style="font-size: 12px;">Define the general line height:</p>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_general_lineheight" id="ts_vcsc_extend_settings_general_lineheight" class="ts_vcsc_extend_settings_general_lineheight ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $General_Line_Height; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_general_lineheight_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $General_Line_Height; ?>" data-min="12" data-max="60" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>
					<div style="margin-top: 20px; margin-bottom: 10px; width: 100%; float: left;">
						<h4>Font Type:</h4>
						<p style="font-size: 12px;">Define the general font type:</p>
						<label class="ThemeBuilder" style="display: inline-block; margin-left: 0;" for="ts_vcsc_extend_settings_general_fonttype">Font Type:</label>
						<select id="ts_vcsc_extend_settings_general_fonttype" name="ts_vcsc_extend_settings_general_fonttype" style="width: 500px;">
							<?php
								foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts as $Font_Network => $font) {
									$Font_Item			= $Font_Network;
									$Font_Name 			= $font['syntax'];
									echo '<option value="' . $Font_Item . '" ' . selected($Font_Item, $General_Font_Type, false) . '>' . $Font_Name . '</option>';
								}
							?>
						</select>
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Font Color:</h4>
						<p style="font-size: 12px;">Define the general font color:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_general_fontcolor" name="ts_vcsc_extend_settings_general_fontcolor" data-error="General - Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_general_fontcolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["color"]; ?>" value="<?php echo $General_Font_Color; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Background Color:</h4>
						<p style="font-size: 12px;">Define the general background color:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_general_background" name="ts_vcsc_extend_settings_general_background" data-error="General - Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_general_background ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["background"]; ?>" value="<?php echo $General_Background; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px; margin-bottom: 10px;">
						<h4>Border Style:</h4>
						<p style="font-size: 12px; margin-bottom: 10px;">Define the general border style:</p>
						<div class="ts-nouislider-input-slider" style="float: left; margin-right: 20px;">
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_general_borderwidth" id="ts_vcsc_extend_settings_general_borderwidth" class="ts_vcsc_extend_settings_general_borderwidth ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $General_Border_Width; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_general_borderwidth_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $General_Border_Width; ?>" data-min="0" data-max="10" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<div style="float: left; margin-right: 20px;">
							<select id="ts_vcsc_extend_settings_general_bordertype" name="ts_vcsc_extend_settings_general_bordertype" style="width: 140px;">
								<option value="solid" <?php selected("solid", $General_Border_Type, true); ?>>Solid</option>
								<option value="dotted" <?php selected("dotted", $General_Border_Type, true); ?>>Dotted</option>
								<option value="dashed" <?php selected("dashed", $General_Border_Type, true); ?>>Dashed</option>
							</select>
						</div>
						<div style="float: left; margin-right: 20px;">
							<div class="ts-color-group">
								<input id="ts_vcsc_extend_settings_general_bordercolor" name="ts_vcsc_extend_settings_general_bordercolor" data-error="General - Border Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_general_bordercolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["bordercolor"]; ?>" value="<?php echo $General_Border_Color; ?>"/>
							</div>
						</div>
					</div>
				</div>		
			</div>	
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-editor-ol"></i>Line Number Styles</div>
				<div class="ts-vcsc-section-content slideFade" style="display: none;">
					<div style="margin-top: 10px; display: block; width: 100%; float: left;">
						<div class="ts-nouislider-input-slider" style="">
							<h4>Font Size:</h4>
							<p style="font-size: 12px;">Define the line numbers font size:</p>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_lines_fontsize" id="ts_vcsc_extend_settings_lines_fontsize" class="ts_vcsc_extend_settings_lines_fontsize ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $Lines_Font_Size; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_lines_fontsize_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $Lines_Font_Size; ?>" data-min="10" data-max="50" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>
					<div style="margin-top: 20px; margin-bottom: 10px; width: 100%; float: left;">
						<h4>Font Type:</h4>
						<p style="font-size: 12px;">Define the line numbers font type:</p>
						<label class="ThemeBuilder" style="display: inline-block; margin-left: 0;" for="ts_vcsc_extend_settings_lines_fonttype">Font Type:</label>
						<select id="ts_vcsc_extend_settings_lines_fonttype" name="ts_vcsc_extend_settings_lines_fonttype" style="width: 500px;">
							<?php
								foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts as $Font_Network => $font) {
									$Font_Item			= $Font_Network;
									$Font_Name 			= $font['syntax'];
									echo '<option value="' . $Font_Item . '" '. selected($Font_Item, $Lines_Font_Type, false) . '>' . $Font_Name . '</option>';
								}
							?>
						</select>
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Font Color:</h4>
						<p style="font-size: 12px;">Define the line numbers font color:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_lines_fontcolor" name="ts_vcsc_extend_settings_lines_fontcolor" data-error="Line Numbers - Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_lines_fontcolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["color"]; ?>" value="<?php echo $Lines_Font_Color; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Background Color:</h4>
						<p style="font-size: 12px;">Define the background color for the line numbers:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_lines_background" name="ts_vcsc_extend_settings_lines_background" data-error="Line Numbers - Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_lines_background ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["background"]; ?>" value="<?php echo $Lines_Background; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px; margin-bottom: 10px;">
						<h4>Border Style:</h4>
						<p style="font-size: 12px; margin-bottom: 10px;">Define the border style between the line numbers and code section:</p>
						<div class="ts-nouislider-input-slider" style="float: left; margin-right: 20px;">
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_lines_borderwidth" id="ts_vcsc_extend_settings_lines_borderwidth" class="ts_vcsc_extend_settings_lines_borderwidth ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $Lines_Border_Width; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_lines_borderwidth_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $Lines_Border_Width; ?>" data-min="0" data-max="10" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<div style="float: left; margin-right: 20px;">
							<select id="ts_vcsc_extend_settings_lines_bordertype" name="ts_vcsc_extend_settings_lines_bordertype" style="width: 140px;">
								<option value="solid" <?php selected("solid", $Lines_Border_Type, true); ?>>Solid</option>
								<option value="dotted" <?php selected("dotted", $Lines_Border_Type, true); ?>>Dotted</option>
								<option value="dashed" <?php selected("dashed", $Lines_Border_Type, true); ?>>Dashed</option>
							</select>
						</div>
						<div style="float: left; margin-right: 20px;">
							<div class="ts-color-group">
								<input id="ts_vcsc_extend_settings_lines_bordercolor" name="ts_vcsc_extend_settings_lines_bordercolor" data-error="General - Border Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_lines_bordercolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["bordercolor"]; ?>" value="<?php echo $Lines_Border_Color; ?>"/>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-editor-code"></i>Original Code Styles</div>
				<div class="ts-vcsc-section-content slideFade" style="display: none;">
					<div style="margin-top: 10px; display: block; width: 100%; float: left;">
						<div class="ts-nouislider-input-slider" style="">
							<h4>Font Size:</h4>
							<p style="font-size: 12px;">Define the original font size:</p>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_original_fontsize" id="ts_vcsc_extend_settings_original_fontsize" class="ts_vcsc_extend_settings_original_fontsize ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $Original_Font_Size; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_original_fontsize_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $Original_Font_Size; ?>" data-min="10" data-max="50" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>
					<div style="margin-top: 20px; display: block; width: 100%; float: left;">
						<div class="ts-nouislider-input-slider" style="">
							<h4>Line Height:</h4>
							<p style="font-size: 12px;">Define the original code line height:</p>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_original_lineheight" id="ts_vcsc_extend_settings_original_lineheight" class="ts_vcsc_extend_settings_original_lineheight ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $Original_Line_Height; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_original_lineheight_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $Original_Line_Height; ?>" data-min="12" data-max="60" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>
					<div style="margin-top: 20px; margin-bottom: 10px; width: 100%; float: left;">
						<h4>Font Type:</h4>
						<p style="font-size: 12px;">Define the original code font type:</p>
						<label class="ThemeBuilder" style="display: inline-block; margin-left: 0;" for="ts_vcsc_extend_settings_original_fonttype">Font Type:</label>
						<select id="ts_vcsc_extend_settings_original_fonttype" name="ts_vcsc_extend_settings_original_fonttype" style="width: 500px;">
							<?php
								foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts as $Font_Network => $font) {
									$Font_Item			= $Font_Network;
									$Font_Name 			= $font['syntax'];
									echo '<option value="' . $Font_Item . '" '. selected($Font_Item, $Original_Font_Type, false) . '>' . $Font_Name . '</option>';
								}
							?>
						</select>
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Font Color:</h4>
						<p style="font-size: 12px;">Define the original code font color:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_original_fontcolor" name="ts_vcsc_extend_settings_original_fontcolor" data-error="Original - Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_original_fontcolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["color"]; ?>" value="<?php echo $Original_Font_Color; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Background Color:</h4>
						<p style="font-size: 12px;">Define the original code background color:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_original_background" name="ts_vcsc_extend_settings_original_background" data-error="Original - Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_original_background ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["background"]; ?>" value="<?php echo $Original_Background; ?>"/>
						</div>
					</div>
				</div>
			</div>	
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-appearance"></i>Special Styles</div>
				<div class="ts-vcsc-section-content slideFade" style="display: none;">
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Line Highlight Color:</h4>
						<p style="font-size: 12px;">Define the background color for highlighted lines:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_special_highlight" name="ts_vcsc_extend_settings_special_highlight" data-error="Original - Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_special_highlight ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["highlight"]; ?>" value="<?php echo $Special_Highlight; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Line Hover Color:</h4>
						<p style="font-size: 12px;">Define the background colod when hovering over a line:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_special_hover" name="ts_vcsc_extend_settings_special_hover" data-error="Original - Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_special_hover ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["hover"]; ?>" value="<?php echo $Special_Hover; ?>"/>
						</div>
					</div>
				</div>
			</div>	
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-settings"></i>Segment Styles</div>
				<div class="ts-vcsc-section-content slideFade" style="display: none;">
					<?php
						foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme as $Group => $setting) {
							$Setting_Key	= $Group;
							$Setting_Main	= strtolower($Group);
							$Setting_Style	= $setting['style'];
							if ($Setting_Style == 'segment') {
								echo '<div class="clearFixMe" style="margin-top: 20px;">';
									echo '<h4>' . $setting['string'] . ':</h4>';
									echo '<div class="ts-settings-group" style="display: inline-block; margin-right: 20px;">';
										echo '<label class="ThemeBuilder" style="display: block; margin-left: 0; margin-right: 10px;" for="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_color">Font Color:</label>';
										echo '<input id="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_color" name="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_color" data-error="Original - Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_segment_' . $Setting_Main . '_color ts-color-control" data-alpha="true" type="text" data-default="' . $setting['color'] . '" value="' . ${'Segment_' . $Setting_Key . '_Color'} . '"/>';
									echo '</div>';
									echo '<div class="ts-settings-group" style="display: inline-block; margin-right: 20px;">';
										echo '<label class="ThemeBuilder" style="display: block; margin-left: 0; margin-right: 10px;" for="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_background">Background Color:</label>';
										echo '<input id="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_background" name="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_background" data-error="Original - Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_segment_' . $Setting_Main . '_background ts-color-control" data-alpha="true" type="text" data-default="' . $setting['background'] . '" value="' . ${'Segment_' . $Setting_Key . '_Back'} . '"/>';
									echo '</div>';
									echo '<div class="ts-settings-group" style="display: inline-block; margin-right: 20px;">';
										echo '<label class="ThemeBuilder" style="display: block; margin-left: 0; margin-right: 10px;" for="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_weight">Font Weight:</label>';
										echo '<select id="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_weight" name="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_weight" style="width: 140px; display: block;">';
											echo '<option value="normal" ' . selected("normal", ${'Segment_' . $Setting_Key . '_Weight'}, false) . '>Normal</option>';
											echo '<option value="bold" ' . selected("bold", ${'Segment_' . $Setting_Key . '_Weight'}, false) . '>Bold</option>';
											echo '<option value="italic" ' . selected("italic", ${'Segment_' . $Setting_Key . '_Weight'}, false) . '>Italic</option>';
											echo '<option value="bolditalic" ' . selected("bolditalic", ${'Segment_' . $Setting_Key . '_Weight'}, false) . '>Bold + Italic</option>';
										echo '</select>';
									echo '</div>';
									echo '<div class="ts-settings-group" style="display: inline-block; margin-right: 20px;">';
										echo '<label class="ThemeBuilder" style="display: block; margin-left: 0; margin-right: 10px;" for="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_decoration">Font Decoration:</label>';
										echo '<select id="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_decoration" name="ts_vcsc_extend_settings_segment_' . $Setting_Main . '_decoration" style="width: 140px; display: block;">';
											echo '<option value="none">None</option>';
											echo '<option value="underline">Underline</option>';
											echo '<option value="overline">Overline</option>';
											echo '<option value="line-through">Line Through</option>';
										echo '</select>';
									echo '</div>';
								echo '</div>';
							}
						}
					?>
				</div>
			</div>
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-editor-justify"></i>Group Button Styles</div>
				<div class="ts-vcsc-section-content slideFade" style="display: none;">
					<div class="ts-vcsc-notice-field ts-vcsc-info" style="margin-top: 10px; margin-bottom: 20px; font-size: 16px; text-align: justify; font-weight: bold;">
						General Control Settings
					</div>	
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Background Color:</h4>
						<p style="font-size: 12px;">Define the background color for the group control section:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_controls_background" name="ts_vcsc_extend_settings_controls_background" data-error="Groups - Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_controls_background ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Controls"]["background"]; ?>" value="<?php echo $Controls_Background; ?>"/>
						</div>
					</div>
					<div class="ts-vcsc-notice-field ts-vcsc-info" style="margin-top: 30px; margin-bottom: 10px; font-size: 16px; text-align: justify; font-weight: bold;">
						General Button Settings
					</div>	
					<div style="margin-top: 10px; display: block; width: 100%; float: left;">
						<div class="ts-nouislider-input-slider" style="">
							<h4>Font Size:</h4>
							<p style="font-size: 12px;">Define the buttons font size:</p>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_buttons_fontsize" id="ts_vcsc_extend_settings_buttons_fontsize" class="ts_vcsc_extend_settings_buttons_fontsize ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $Buttons_Font_Size; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_buttons_fontsize_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $Buttons_Font_Size; ?>" data-min="10" data-max="50" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>
					<div style="margin-top: 20px; margin-bottom: 10px; width: 100%; float: left;">
						<h4>Font Type:</h4>
						<p style="font-size: 12px;">Define the buttons font type:</p>
						<label class="ThemeBuilder" style="display: inline-block; margin-left: 0;" for="ts_vcsc_extend_settings_buttons_fonttype">Font Type:</label>
						<select id="ts_vcsc_extend_settings_buttons_fonttype" name="ts_vcsc_extend_settings_buttons_fonttype" style="width: 500px;">
							<?php
								foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts as $Font_Network => $font) {
									$Font_Item			= $Font_Network;
									$Font_Name 			= $font['syntax'];
									echo '<option value="' . $Font_Item . '" ' . selected($Font_Item, $Buttons_Font_Type, false) . '>' . $Font_Name . '</option>';
								}
							?>
						</select>
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Font Color:</h4>
						<p style="font-size: 12px;">Define the buttons font color:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_buttons_fontcolor" name="ts_vcsc_extend_settings_buttons_fontcolor" data-error="General - Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_buttons_fontcolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["color"]; ?>" value="<?php echo $Buttons_Font_Color; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Background Color:</h4>
						<p style="font-size: 12px;">Define the buttons background color:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_buttons_background" name="ts_vcsc_extend_settings_buttons_background" data-error="General - Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_buttons_background ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["background"]; ?>" value="<?php echo $Buttons_Background; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px; margin-bottom: 10px;">
						<h4>Border Style:</h4>
						<p style="font-size: 12px; margin-bottom: 10px;">Define the buttons border style:</p>
						<div class="ts-nouislider-input-slider" style="float: left; margin-right: 20px;">
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_buttons_borderwidth" id="ts_vcsc_extend_settings_buttons_borderwidth" class="ts_vcsc_extend_settings_buttons_borderwidth ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" value="<?php echo $Buttons_Border_Width; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_buttons_borderwidth_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $Buttons_Border_Width; ?>" data-min="0" data-max="10" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<div style="float: left; margin-right: 20px;">
							<select id="ts_vcsc_extend_settings_buttons_bordertype" name="ts_vcsc_extend_settings_buttons_bordertype" style="width: 140px;">
								<option value="solid" <?php selected("solid", $Buttons_Border_Type, true); ?>>Solid</option>
								<option value="dotted" <?php selected("dotted", $Buttons_Border_Type, true); ?>>Dotted</option>
								<option value="dashed" <?php selected("dashed", $Buttons_Border_Type, true); ?>>Dashed</option>
							</select>
						</div>
						<div style="float: left; margin-right: 20px;">
							<div class="ts-color-group">
								<input id="ts_vcsc_extend_settings_buttons_bordercolor" name="ts_vcsc_extend_settings_buttons_bordercolor" data-error="General - Border Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_buttons_bordercolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["bordercolor"]; ?>" value="<?php echo $Buttons_Border_Color; ?>"/>
							</div>
						</div>
					</div>
					<div class="ts-vcsc-notice-field ts-vcsc-info" style="margin-top: 30px; margin-bottom: 10px; font-size: 16px; text-align: justify; font-weight: bold;">
						Selected Button Settings
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Font Color:</h4>
						<p style="font-size: 12px;">Define the font color for the selected button:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_selected_fontcolor" name="ts_vcsc_extend_settings_selected_fontcolor" data-error="Buttons - Selected Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_selected_fontcolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["color"]; ?>" value="<?php echo $Selected_Font_Color; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Background Color:</h4>
						<p style="font-size: 12px;">Define the background color for the selected button:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_selected_background" name="ts_vcsc_extend_settings_selected_background" data-error="Buttons - Selected Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_selected_background ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["background"]; ?>" value="<?php echo $Selected_Background; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Border Color:</h4>
						<p style="font-size: 12px;">Define the border color for the selected button:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_selected_bordercolor" name="ts_vcsc_extend_settings_selected_bordercolor" data-error="Buttons - Selected Border Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_selected_bordercolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["bordercolor"]; ?>" value="<?php echo $Selected_Border_Color; ?>"/>
						</div>
					</div>			
					<div class="ts-vcsc-notice-field ts-vcsc-info" style="margin-top: 30px; margin-bottom: 10px; font-size: 16px; text-align: justify; font-weight: bold;">
						Hover Button Settings
					</div>
					<div class="clearFixMe" style="margin-top: 20px;">
						<h4>Font Color:</h4>
						<p style="font-size: 12px;">Define the hover font color for the buttons:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_hover_fontcolor" name="ts_vcsc_extend_settings_hover_fontcolor" data-error="Buttons - Hover Font Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_hover_fontcolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["color"]; ?>" value="<?php echo $Hover_Font_Color; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Background Color:</h4>
						<p style="font-size: 12px;">Define the hover background color for the buttons:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_hover_background" name="ts_vcsc_extend_settings_hover_background" data-error="Buttons - Hover Background Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_hover_background ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["background"]; ?>" value="<?php echo $Hover_Background; ?>"/>
						</div>
					</div>
					<div class="clearFixMe" style="margin-top: 10px;">
						<h4>Border Color:</h4>
						<p style="font-size: 12px;">Define the hover border color for the buttons:</p>
						<div class="ts-color-group">
							<input id="ts_vcsc_extend_settings_hover_bordercolor" name="ts_vcsc_extend_settings_hover_bordercolor" data-error="Buttons - Hover Border Color" data-order="2" class="validate[required,funcCall[checkColorPickerSyntax]] ts_vcsc_extend_settings_hover_bordercolor ts-color-control" data-alpha="true" type="text" data-default="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["bordercolor"]; ?>" value="<?php echo $Hover_Border_Color; ?>"/>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<div class="ts-vcsc-settings-group-bottombar ts-vcsc-settings-group-buttonbar" style="">
		<div class="ts-vcsc-settings-group-actionbar">
			<input title="Click here to save your custom theme for the syntax highlighter." type="submit" name="Submit" id="ts_vcsc_extend_settings_submit_2" class="button button-primary" value="Save Custom Theme">
		</div>
		<div class="clear"></div>
	</div>
</form>
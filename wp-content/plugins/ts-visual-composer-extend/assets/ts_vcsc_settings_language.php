<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    //var_dump($TS_VCSC_Google_Map_Language);
    //var_dump($TS_VCSC_Countdown_Language);
    //var_dump($TS_VCSC_Magnify_Language);
    //var_dump($TS_VCSC_Isotope_Posts_Language);
?>
<div id="ts-settings-language" class="tab-content">
    <div class="ts-vcsc-section-main">
	<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-translation"></i>Language Settings</div>
	<div class="ts-vcsc-section-content">
	    <div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; margin-bottom: 10px; font-size: 13px;">
		Some elements use key words or text strings on the front-end, mostly for things such as control menus or buttons. Here, you can translate those key words if you want to show them in a different language.
	    </div>
	</div>
    </div>
    <div class="ts-vcsc-section-main">
	<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-welcome-widgets-menus"></i>Isotope Posts Phrases</div>
	<div class="ts-vcsc-section-content">
	    <p style="margin-top: 10px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsButtonFilter">"Filter Posts":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsButtonFilter" name="ts_vcsc_extend_settings_languageIsotopePostsButtonFilter" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['ButtonFilter']) ? $TS_VCSC_Isotope_Posts_Language['ButtonFilter'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['ButtonFilter']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsSeeAll">"See All":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsSeeAll" name="ts_vcsc_extend_settings_languageIsotopePostsSeeAll" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['SeeAll']) ? $TS_VCSC_Isotope_Posts_Language['SeeAll'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['SeeAll']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsButtonLayout">"Change Layout":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsButtonLayout" name="ts_vcsc_extend_settings_languageIsotopePostsButtonLayout" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['ButtonLayout']) ? $TS_VCSC_Isotope_Posts_Language['ButtonLayout'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['ButtonLayout']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsTimeline">"Timeline":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsTimeline" name="ts_vcsc_extend_settings_languageIsotopePostsTimeline" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Timeline']) ? $TS_VCSC_Isotope_Posts_Language['Timeline'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Timeline']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsMasonry">"Centered Masonry":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsMasonry" name="ts_vcsc_extend_settings_languageIsotopePostsMasonry" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Masonry']) ? $TS_VCSC_Isotope_Posts_Language['Masonry'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Masonry']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsFitRows">"Fit Rows":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsFitRows" name="ts_vcsc_extend_settings_languageIsotopePostsFitRows" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['FitRows']) ? $TS_VCSC_Isotope_Posts_Language['FitRows'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['FitRows']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsStraightDown">"Straight Down":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsStraightDown" name="ts_vcsc_extend_settings_languageIsotopePostsStraightDown" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['StraightDown']) ? $TS_VCSC_Isotope_Posts_Language['StraightDown'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['StraightDown']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsButtonSort">"Sort Criteria":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsButtonSort" name="ts_vcsc_extend_settings_languageIsotopePostsButtonSort" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['ButtonSort']) ? $TS_VCSC_Isotope_Posts_Language['ButtonSort'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['ButtonSort']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsDate">"Post Date":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsDate" name="ts_vcsc_extend_settings_languageIsotopePostsDate" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Date']) ? $TS_VCSC_Isotope_Posts_Language['Date'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Date']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsModified">"Post Modified":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsModified" name="ts_vcsc_extend_settings_languageIsotopePostsModified" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Modified']) ? $TS_VCSC_Isotope_Posts_Language['Modified'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Modified']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsTitle">"Post Title":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsTitle" name="ts_vcsc_extend_settings_languageIsotopePostsTitle" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Title']) ? $TS_VCSC_Isotope_Posts_Language['Title'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Title']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsAuthor">"Post Author":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsAuthor" name="ts_vcsc_extend_settings_languageIsotopePostsAuthor" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Author']) ? $TS_VCSC_Isotope_Posts_Language['Author'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Author']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsPostID">"Post ID":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsPostID" name="ts_vcsc_extend_settings_languageIsotopePostsPostID" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['PostID']) ? $TS_VCSC_Isotope_Posts_Language['PostID'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['PostID']); ?>" size="100">
	    </p>	
	    <p style="margin-left: 25px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsComments">"Comments":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsComments" name="ts_vcsc_extend_settings_languageIsotopePostsComments" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Comments']) ? $TS_VCSC_Isotope_Posts_Language['Comments'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Comments']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsCategories">"Categories":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsCategories" name="ts_vcsc_extend_settings_languageIsotopePostsCategories" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Categories']) ? $TS_VCSC_Isotope_Posts_Language['Categories'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Categories']); ?>" size="100">
	    </p>	
	    <p style="margin-bottom: 10px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsTags">"Tags":</label>
		<input class="validate[required]" data-error="Text - Filter Posts" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsTags" name="ts_vcsc_extend_settings_languageIsotopePostsTags" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['Tags']) ? $TS_VCSC_Isotope_Posts_Language['Tags'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Tags']); ?>" size="100">
	    </p>
	</div>
    </div>    
    <div style="margin: 0; padding: 0; <?php ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerceActive == "true" ? "display: block;" : "display: none;"); ?>">
	<div class="ts-vcsc-section-main">
	    <div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-products"></i>WooCommerce Phrases</div>
	    <div class="ts-vcsc-section-content">
		<p style="margin-top: 10px;">
		    <label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsWooFilterProducts">"Filter Products":</label>
		    <input class="validate[required]" data-error="Text - Filter Products" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsWooFilterProducts" name="ts_vcsc_extend_settings_languageIsotopePostsWooFilterProducts" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['WooFilterProducts']) ? $TS_VCSC_Isotope_Posts_Language['WooFilterProducts'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooFilterProducts']); ?>" size="100">
		</p>	
		<p>
		    <label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsWooTitle">"Product Title":</label>
		    <input class="validate[required]" data-error="Text - Product Title" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsWooTitle" name="ts_vcsc_extend_settings_languageIsotopePostsWooTitle" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['WooTitle']) ? $TS_VCSC_Isotope_Posts_Language['WooTitle'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooTitle']); ?>" size="100">
		</p>	
		<p>
		    <label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsWooPrice">"Product Price":</label>
		    <input class="validate[required]" data-error="Text - Product Price" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsWooPrice" name="ts_vcsc_extend_settings_languageIsotopePostsWooPrice" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['WooPrice']) ? $TS_VCSC_Isotope_Posts_Language['WooPrice'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooPrice']); ?>" size="100">
		</p>	
		<p>
		    <label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsWooRating">"Product Rating":</label>
		    <input class="validate[required]" data-error="Text - Product Rating" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsWooRating" name="ts_vcsc_extend_settings_languageIsotopePostsWooRating" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['WooRating']) ? $TS_VCSC_Isotope_Posts_Language['WooRating'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooRating']); ?>" size="100">
		</p>	
		<p>
		    <label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsWooDate">"Product Date":</label>
		    <input class="validate[required]" data-error="Text - Product Date" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsWooDate" name="ts_vcsc_extend_settings_languageIsotopePostsWooDate" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['WooDate']) ? $TS_VCSC_Isotope_Posts_Language['WooDate'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooDate']); ?>" size="100">
		</p>	
		<p style="margin-bottom: 10px;">
		    <label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageIsotopePostsWooModified">"Product Modified":</label>
		    <input class="validate[required]" data-error="Text - Product Modified" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageIsotopePostsWooModified" name="ts_vcsc_extend_settings_languageIsotopePostsWooModified" value="<?php echo (isset($TS_VCSC_Isotope_Posts_Language['WooModified']) ? $TS_VCSC_Isotope_Posts_Language['WooModified'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooModified']); ?>" size="100">
		</p>
	    </div>
	</div>
    </div>
    <div class="ts-vcsc-section-main">
	<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-calendar"></i>Countdown Phrases</div>
	<div class="ts-vcsc-section-content">
	    <p style="margin-top: 10px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageDayPlural">"Days" (Plural):</label>
		<input class="validate[required]" data-error="Text - Multiple Days" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageDayPlural" name="ts_vcsc_extend_settings_languageDayPlural" value="<?php echo (isset($TS_VCSC_Countdown_Language['DayPlural']) ? $TS_VCSC_Countdown_Language['DayPlural'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['DayPlural']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageDaySingular">"Day" (Singular):</label>
		<input class="validate[required]" data-error="Text - Single Day" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageDaySingular" name="ts_vcsc_extend_settings_languageDaySingular" value="<?php echo (isset($TS_VCSC_Countdown_Language['DaySingular']) ? $TS_VCSC_Countdown_Language['DaySingular'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['DaySingular']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageHourPlural">"Hours" (Plural):</label>
		<input class="validate[required]" data-error="Text - Multiple Hours" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageHourPlural" name="ts_vcsc_extend_settings_languageHourPlural" value="<?php echo (isset($TS_VCSC_Countdown_Language['HourPlural']) ? $TS_VCSC_Countdown_Language['HourPlural'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['HourPlural']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageHourSingular">"Hour" (Singular):</label>
		<input class="validate[required]" data-error="Text - Single Hour" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageHourSingular" name="ts_vcsc_extend_settings_languageHourSingular" value="<?php echo (isset($TS_VCSC_Countdown_Language['HourSingular']) ? $TS_VCSC_Countdown_Language['HourSingular'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['HourSingular']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMinutePlural">"Minutes" (Plural):</label>
		<input class="validate[required]" data-error="Text - Multiple Minutes" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMinutePlural" name="ts_vcsc_extend_settings_languageMinutePlural" value="<?php echo (isset($TS_VCSC_Countdown_Language['MinutePlural']) ? $TS_VCSC_Countdown_Language['MinutePlural'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['MinutePlural']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMinuteSingular">"Minute" (Singular):</label>
		<input class="validate[required]" data-error="Text - Single Minute" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMinuteSingular" name="ts_vcsc_extend_settings_languageMinuteSingular" value="<?php echo (isset($TS_VCSC_Countdown_Language['MinuteSingular']) ? $TS_VCSC_Countdown_Language['MinuteSingular'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['MinuteSingular']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageSecondPlural">"Seconds" (Plural):</label>
		<input class="validate[required]" data-error="Text - Multiple Seconds" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageSecondPlural" name="ts_vcsc_extend_settings_languageSecondPlural" value="<?php echo (isset($TS_VCSC_Countdown_Language['SecondPlural']) ? $TS_VCSC_Countdown_Language['SecondPlural'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['SecondPlural']); ?>" size="100">
	    </p>	
	    <p style="margin-bottom: 10px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageSecondSingular">"Second" (Singular):</label>
		<input class="validate[required]" data-error="Text - Single Second" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageSecondSingular" name="ts_vcsc_extend_settings_languageSecondSingular" value="<?php echo (isset($TS_VCSC_Countdown_Language['SecondSingular']) ? $TS_VCSC_Countdown_Language['SecondSingular'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['SecondSingular']); ?>" size="100">
	    </p>
	</div>
    </div>    
    <div class="ts-vcsc-section-main">
	<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-search"></i>Magnify / Zoom Phrases</div>
	<div class="ts-vcsc-section-content">
	    <p style="margin-top: 10px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyZoomIn">"Zoom In":</label>
		<input class="validate[required]" data-error="Text - Zoom In" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyZoomIn" name="ts_vcsc_extend_settings_languageMagnifyZoomIn" value="<?php echo (isset($TS_VCSC_Magnify_Language['ZoomIn']) ? $TS_VCSC_Magnify_Language['ZoomIn'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ZoomIn']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyZoomOut">"Zoom Out":</label>
		<input class="validate[required]" data-error="Text - Zoom Out" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyZoomOut" name="ts_vcsc_extend_settings_languageMagnifyZoomOut" value="<?php echo (isset($TS_VCSC_Magnify_Language['ZoomOut']) ? $TS_VCSC_Magnify_Language['ZoomOut'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ZoomOut']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyZoomLevel">"Zoom Level":</label>
		<input class="validate[required]" data-error="Text - Zoom Level" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyZoomLevel" name="ts_vcsc_extend_settings_languageMagnifyZoomLevel" value="<?php echo (isset($TS_VCSC_Magnify_Language['ZoomLevel']) ? $TS_VCSC_Magnify_Language['ZoomLevel'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ZoomLevel']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyChangeLevel">"Change Zoom Level":</label>
		<input class="validate[required]" data-error="Text - Change Zoom Level" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyChangeLevel" name="ts_vcsc_extend_settings_languageMagnifyChangeLevel" value="<?php echo (isset($TS_VCSC_Magnify_Language['ChangeLevel']) ? $TS_VCSC_Magnify_Language['ChangeLevel'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ChangeLevel']); ?>" size="100">
	    </p>	
	    <p style="display: none;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyNext">"Next":</label>
		<input class="validate[required]" data-error="Text - Next" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyNext" name="ts_vcsc_extend_settings_languageMagnifyNext" value="<?php echo (isset($TS_VCSC_Magnify_Language['Next']) ? $TS_VCSC_Magnify_Language['Next'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Next']); ?>" size="100">
	    </p>	
	    <p style="display: none;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyPrevious">"Previous":</label>
		<input class="validate[required]" data-error="Text - Previous" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyPrevious" name="ts_vcsc_extend_settings_languageMagnifyPrevious" value="<?php echo (isset($TS_VCSC_Magnify_Language['Previous']) ? $TS_VCSC_Magnify_Language['Previous'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Previous']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyReset">"Reset Zoom":</label>
		<input class="validate[required]" data-error="Text - Reset Zoom" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyReset" name="ts_vcsc_extend_settings_languageMagnifyReset" value="<?php echo (isset($TS_VCSC_Magnify_Language['Reset']) ? $TS_VCSC_Magnify_Language['Reset'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Reset']); ?>" size="100">
	    </p>	
	    <p style="margin-bottom: 10px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyRotate">"Rotate Image":</label>
		<input class="validate[required]" data-error="Text - Rotate Image" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyRotate" name="ts_vcsc_extend_settings_languageMagnifyRotate" value="<?php echo (isset($TS_VCSC_Magnify_Language['Rotate']) ? $TS_VCSC_Magnify_Language['Rotate'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Rotate']); ?>" size="100">
	    </p>
	    <p style="margin-bottom: 10px;">
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageMagnifyLightbox">"Show Image in Lightbox":</label>
		<input class="validate[required]" data-error="Text - Show Image in Lightbox" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageMagnifyLightbox" name="ts_vcsc_extend_settings_languageMagnifyLightbox" value="<?php echo (isset($TS_VCSC_Magnify_Language['Lightbox']) ? $TS_VCSC_Magnify_Language['Lightbox'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Lightbox']); ?>" size="100">
	    </p>
	</div>
    </div>
    
    <div class="ts-vcsc-section-main">
	<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-location-alt"></i>Google Map (Deprecated) Phrases</div>
	<div class="ts-vcsc-section-content">
	    <div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; margin-bottom: 10px; font-size: 13px;">
		The following text strings only apply to the (now deprecated) Google Maps element. The (new) "TS Google Maps PLUS" element will provide you with options to translate or change text strings used for the map
		in the elements settings panel for the map directly.
	    </div>
	    <img src="<?php echo TS_VCSC_GetResourceURL('images/other/google_map.jpg'); ?>" style="border: 1px solid #eeeeee; width:900px; max-width: 100%; height: auto; margin: 20px auto;">    
	    <p style="font-size: 10px;">The iamge above doesn't show all available text items since some of them are conditional and exclude each other, but it should give you a basic idea.</p>    
	    <p style="font-weight: bold;">Text Items in Top Control Bar:</p>
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapActivate">"Show Google Map":</label>
		<input class="validate[required]" data-error="Text - Show Google Map" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapActivate" name="ts_vcsc_extend_settings_languageTextMapActivate" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapActivate']) ? $TS_VCSC_Google_Map_Language['TextMapActivate'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapActivate']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapDeactivate">"Hide Google Map":</label>
		<input class="validate[required]" data-error="Text - Hide Google Map" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapDeactivate" name="ts_vcsc_extend_settings_languageTextMapDeactivate" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapDeactivate']) ? $TS_VCSC_Google_Map_Language['TextMapDeactivate'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapDeactivate']); ?>" size="100">
	    </p>
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextResetMap">"Reset Map":</label>
		<input class="validate[required]" data-error="Text - Reset Map" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextResetMap" name="ts_vcsc_extend_settings_languageTextResetMap" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextResetMap']) ? $TS_VCSC_Google_Map_Language['TextResetMap'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextResetMap']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextCalcShow">"Show Address Input":</label>
		<input class="validate[required]" data-error="Text - Show Address Input" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextCalcShow" name="ts_vcsc_extend_settings_languageTextCalcShow" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextCalcShow']) ? $TS_VCSC_Google_Map_Language['TextCalcShow'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextCalcShow']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextCalcHide">"Hide Address Input":</label>
		<input class="validate[required]" data-error="Text - Hide Address Input" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextCalcHide" name="ts_vcsc_extend_settings_languageTextCalcHide" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextCalcHide']) ? $TS_VCSC_Google_Map_Language['TextCalcHide'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextCalcHide']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextDirectionShow">"Show Directions":</label>
		<input class="validate[required]" data-error="Text - Show Directions" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextDirectionShow" name="ts_vcsc_extend_settings_languageTextDirectionShow" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextDirectionShow']) ? $TS_VCSC_Google_Map_Language['TextDirectionShow'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDirectionShow']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextDirectionHide">"Hide Directions":</label>
		<input class="validate[required]" data-error="Text - Hide Directions" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextDirectionHide" name="ts_vcsc_extend_settings_languageTextDirectionHide" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextDirectionHide']) ? $TS_VCSC_Google_Map_Language['TextDirectionHide'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDirectionHide']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextDistance">"Total Distance:":</label>
		<input class="validate[required]" data-error="Text - Total Distance" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextDistance" name="ts_vcsc_extend_settings_languageTextDistance" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextDistance']) ? $TS_VCSC_Google_Map_Language['TextDistance'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDistance']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapMiles">"Miles":</label>
		<input class="validate[required]" data-error="Text - Miles" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapMiles" name="ts_vcsc_extend_settings_languageTextMapMiles" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapMiles']) ? $TS_VCSC_Google_Map_Language['TextMapMiles'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapMiles']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapKilometes">"Kilometers":</label>
		<input class="validate[required]" data-error="Text - Kilometers" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapKilometes" name="ts_vcsc_extend_settings_languageTextMapKilometes" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapKilometes']) ? $TS_VCSC_Google_Map_Language['TextMapKilometes'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapKilometes']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextViewOnGoogle">"View on Google":</label>
		<input class="validate[required]" data-error="Text - View on Google" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextViewOnGoogle" name="ts_vcsc_extend_settings_languageTextViewOnGoogle" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextViewOnGoogle']) ? $TS_VCSC_Google_Map_Language['TextViewOnGoogle'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextViewOnGoogle']); ?>" size="100">
	    </p>	
	    <p style="font-weight: bold;">Text Items in Address and Waypoints Section:</p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextGeoLocation">"Get My Location":</label>
		<input class="validate[required]" data-error="Text - Get My Location" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextGeoLocation" name="ts_vcsc_extend_settings_languageTextGeoLocation" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextGeoLocation']) ? $TS_VCSC_Google_Map_Language['TextGeoLocation'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextGeoLocation']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextSetTarget">"Please enter your Start Address:":</label>
		<input class="validate[required]" data-error="Text - Please enter your Start Address" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextSetTarget" name="ts_vcsc_extend_settings_languageTextSetTarget" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextSetTarget']) ? $TS_VCSC_Google_Map_Language['TextSetTarget'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextSetTarget']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextButtonAdd">"Add Stop on the Way":</label>
		<input class="validate[required]" data-error="Text - Add Stop on the Way" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextButtonAdd" name="ts_vcsc_extend_settings_languageTextButtonAdd" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextButtonAdd']) ? $TS_VCSC_Google_Map_Language['TextButtonAdd'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextButtonAdd']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextTravelMode">"Travel Mode":</label>
		<input class="validate[required]" data-error="Text - Travel Mode" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextTravelMode" name="ts_vcsc_extend_settings_languageTextTravelMode" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextTravelMode']) ? $TS_VCSC_Google_Map_Language['TextTravelMode'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextTravelMode']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextDriving">"Driving":</label>
		<input class="validate[required]" data-error="Text - Driving" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextDriving" name="ts_vcsc_extend_settings_languageTextDriving" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextDriving']) ? $TS_VCSC_Google_Map_Language['TextDriving'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDriving']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextWalking">"Walking":</label>
		<input class="validate[required]" data-error="Text - Walking" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextWalking" name="ts_vcsc_extend_settings_languageTextWalking" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextWalking']) ? $TS_VCSC_Google_Map_Language['TextWalking'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextWalking']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextBicy">"Bicycling":</label>
		<input class="validate[required]" data-error="Text - Bicycling" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextBicy" name="ts_vcsc_extend_settings_languageTextBicy" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextBicy']) ? $TS_VCSC_Google_Map_Language['TextBicy'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextBicy']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextWP">"Optimize Waypoints":</label>
		<input class="validate[required]" data-error="Text - Optimize Waypoints" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextWP" name="ts_vcsc_extend_settings_languageTextWP" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextWP']) ? $TS_VCSC_Google_Map_Language['TextWP'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextWP']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextButtonCalc">"Show Route":</label>
		<input class="validate[required]" data-error="Text - Show Route" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextButtonCalc" name="ts_vcsc_extend_settings_languageTextButtonCalc" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextButtonCalc']) ? $TS_VCSC_Google_Map_Language['TextButtonCalc'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextButtonCalc']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languagePrintRouteText">"Print Route":</label>
		<input class="validate[required]" data-error="Text - Print Route" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languagePrintRouteText" name="ts_vcsc_extend_settings_languagePrintRouteText" value="<?php echo (isset($TS_VCSC_Google_Map_Language['PrintRouteText']) ? $TS_VCSC_Google_Map_Language['PrintRouteText'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['PrintRouteText']); ?>" size="100">
	    </p>	
	    <p style="font-weight: bold;">Text Items for Custom Map Control Elements:</p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapHome">"Home":</label>
		<input class="validate[required]" data-error="Text - Home" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapHome" name="ts_vcsc_extend_settings_languageTextMapHome" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapHome']) ? $TS_VCSC_Google_Map_Language['TextMapHome'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapHome']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapBikes">"Bicycle Trails":</label>
		<input class="validate[required]" data-error="Text - Bicycle Trails" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapBikes" name="ts_vcsc_extend_settings_languageTextMapBikes" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapBikes']) ? $TS_VCSC_Google_Map_Language['TextMapBikes'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapBikes']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapTraffic">"Traffic":</label>
		<input class="validate[required]" data-error="Text - Traffic" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapTraffic" name="ts_vcsc_extend_settings_languageTextMapTraffic" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapTraffic']) ? $TS_VCSC_Google_Map_Language['TextMapTraffic'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapTraffic']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapSpeedMiles">"Miles Per Hour":</label>
		<input class="validate[required]" data-error="Text - Miles Per Hour" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapSpeedMiles" name="ts_vcsc_extend_settings_languageTextMapSpeedMiles" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapSpeedMiles']) ? $TS_VCSC_Google_Map_Language['TextMapSpeedMiles'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapSpeedMiles']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapSpeedKM">"Kilometers Per Hour":</label>
		<input class="validate[required]" data-error="Text - Kilometers Per Hour" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapSpeedKM" name="ts_vcsc_extend_settings_languageTextMapSpeedKM" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapSpeedKM']) ? $TS_VCSC_Google_Map_Language['TextMapSpeedKM'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapSpeedKM']); ?>" size="100">
	    </p>	
	    <p>
		<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_languageTextMapNoData">"No Data Available!":</label>
		<input class="validate[required]" data-error="Text - No Data Available!" data-order="2" type="text" style="width: 20%;" id="ts_vcsc_extend_settings_languageTextMapNoData" name="ts_vcsc_extend_settings_languageTextMapNoData" value="<?php echo (isset($TS_VCSC_Google_Map_Language['TextMapNoData']) ? $TS_VCSC_Google_Map_Language['TextMapNoData'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapNoData']); ?>" size="100">
	    </p>
	</div>
    </div>
</div>

<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    $url = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
    // Check if JS Files should be loaded in HEAD or BODY
    if ((get_option('ts_vcsc_extend_settings_loadHeader', 0) == 0)) 	        { $FOOTER = true; } else { $FOOTER = false; }

    
    // Icon Font Files
    // ---------------
    foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
        if ($iconfont != "Custom") {
            wp_register_style('ts-font-' . strtolower($iconfont),				$url . 'css/ts-font-' . strtolower($iconfont) . '.css', null, false, 'all');
        } else if ($iconfont == "Custom") {
            $Custom_Font_CSS = get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
            wp_register_style('ts-font-' . strtolower($iconfont) . 'vcsc', 		$Custom_Font_CSS, null, false, 'all');
        }
    }

    
    // Internal Files
    // --------------
    // Front-End Files
    wp_register_style('ts-visual-composer-extend-front',						$url . 'css/ts-visual-composer-extend-front.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-visual-composer-extend-front',						$url . 'js/ts-visual-composer-extend-front.min.js', array('jquery'), COMPOSIUM_VERSION, $FOOTER);
    wp_register_script('ts-visual-composer-extend-galleries',					$url . 'js/ts-visual-composer-extend-galleries.min.js', array('jquery'), COMPOSIUM_VERSION, $FOOTER);
    wp_register_style('ts-visual-composer-extend-demos',						$url . 'css/ts-visual-composer-extend-demos.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-visual-composer-extend-demos',						$url . 'js/ts-visual-composer-extend-demos.min.js', array('jquery'), COMPOSIUM_VERSION, $FOOTER);
    // Front-End Forms
    wp_register_style('ts-visual-composer-extend-forms',						$url . 'css/ts-visual-composer-extend-forms.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-visual-composer-extend-forms',						$url . 'js/ts-visual-composer-extend-forms.min.js', array('jquery'), COMPOSIUM_VERSION, $FOOTER);
    // General Animations Files
    wp_register_style('ts-extend-animations',                 					$url . 'css/ts-visual-composer-extend-animations.min.css', null, COMPOSIUM_VERSION, 'all');
    // General Settings Files
    wp_register_style('ts-vcsc-extend',                              			$url . 'css/ts-visual-composer-extend-settings.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-vcsc-extend', 										$url . 'js/ts-visual-composer-extend-settings.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    // Post Type Settings Files
    wp_register_script('ts-extend-posttypes', 									$url . 'js/ts-visual-composer-extend-posttypes.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    wp_register_style('ts-extend-posttypes',									$url . 'css/ts-visual-composer-extend-posttypes.min.css', null, COMPOSIUM_VERSION, 'all');
    // EnlighterJS Theme Builder
    wp_register_script('ts-extend-themebuilder', 								$url . 'js/ts-visual-composer-extend-themebuilder.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    wp_register_style('ts-extend-themebuilder',									$url . 'css/ts-visual-composer-extend-themebuilder.min.css', null, COMPOSIUM_VERSION, 'all');
    // Elements Files (VC Editor)
    wp_register_script('ts-visual-composer-extend-elements',                    $url . 'js/ts-visual-composer-extend-elements.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    wp_register_style('ts-visual-composer-extend-elements',                     $url . 'css/ts-visual-composer-extend-elements.min.css', null, COMPOSIUM_VERSION, 'all');
    // Plugin Admin Files
    wp_register_style('ts-visual-composer-extend-admin',             			$url . 'css/ts-visual-composer-extend-admin.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-visual-composer-extend-admin',            			$url . 'js/ts-visual-composer-extend-admin.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    // Google Font Manager Files
    wp_register_style('ts-visual-composer-extend-google',             			$url . 'css/ts-visual-composer-extend-google.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-visual-composer-extend-google',            			$url . 'js/ts-visual-composer-extend-google.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    // Iconicum Generator Files
    wp_register_style('ts-visual-composer-extend-generator',					$url . 'css/ts-visual-composer-extend-generator.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-visual-composer-extend-generator',					$url . 'js/ts-visual-composer-extend-generator.min.js', array('wp-color-picker'), COMPOSIUM_VERSION, true);
    // E-Commerce Font
    wp_register_style('ts-font-ecommerce',                 						$url . 'css/ts-font-ecommerce.css', null, COMPOSIUM_VERSION, 'all');
    // Teammate Font
    wp_register_style('ts-font-teammates',                 						$url . 'css/ts-font-teammates.css', null, COMPOSIUM_VERSION, 'all');
    // Mediaplayer Font
    wp_register_style('ts-font-mediaplayer',                 					$url . 'css/ts-font-mediaplayer.css', null, COMPOSIUM_VERSION, 'all');
    // Classy Gradient
    wp_register_style('ts-extend-classygradient',					            $url . 'css/jquery.vcsc.classygradient.min.css', null, false, 'all');
    wp_register_script('ts-extend-classygradient',					            $url . 'js/jquery.vcsc.classygradient.min.js', array('jquery'), false, true);
    // Advanced Colorpicker
    wp_register_style('ts-extend-colorpicker',					                $url . 'css/jquery.vcsc.colorpicker.min.css', null, false, 'all');
    wp_register_script('ts-extend-colorpicker',					                $url . 'js/jquery.vcsc.colorpicker.min.js', array('jquery'), false, true);
    // Alpha Colorpicker
    wp_register_script('ts-extend-colorpickeralpha',                            $url . 'js/jquery.vcsc.colorpickeralpha.min.js', array('jquery','wp-color-picker'), false, true);
    wp_register_script('wp-color-picker-alpha',                                 $url . 'js/jquery.vcsc.colorpickeralpha.min.js', array('jquery','wp-color-picker'), false, true);
    
    
    /* Other Main Libraries */
    /* -------------------- */
    // MooTools (NoConflict)
    wp_register_script('ts-library-mootools',								    $url . 'js/mootools.main.more.min.js', null, '1.5.2', false);

    
    // 3rd Party Files
    // ---------------
    // Hammer
    wp_register_script('ts-extend-hammer', 									    $url . 'js/jquery.vcsc.hammer.min.js', array('jquery'), '1.1.3', $FOOTER);
    // Lightbox
    if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_UseInternalLightbox == "true") {
        wp_register_style('ts-extend-nacho',									$url . 'css/jquery.vcsc.nchlightbox.min.css', null, false, 'all');
        wp_register_script('ts-extend-nacho', 									$url . 'js/jquery.vcsc.nchlightbox.min.js', array('jquery'), false, $FOOTER);
    }
    // Textillate Animations Files
    wp_register_style('ts-extend-textillate',                 					$url . 'css/jquery.vcsc.textillate.min.css', null, false, 'all');
    wp_register_script('ts-extend-textillate',									$url . 'js/jquery.vcsc.textillate.min.js', array('jquery'), false, $FOOTER);
    // Simptip Tooltips
    wp_register_style('ts-extend-simptip',                 						$url . 'css/jquery.vcsc.simptip.min.css', null, false, 'all');
    // Hint Tooltips
    wp_register_style('ts-extend-hint',                 						$url . 'css/jquery.vcsc.hint.min.css', null, false, 'all');
    // iHover Effects
    wp_register_style('ts-extend-ihover',                 						$url . 'css/jquery.vcsc.ihover.min.css', null, false, 'all');
    wp_register_script('ts-extend-ihover',										$url . 'js/jquery.vcsc.ihover.min.js', array('jquery'), false, $FOOTER);
    // Google Charts API
    wp_register_script('ts-extend-google-charts',								'https://www.google.com/jsapi', array('jquery'), false, false);
    wp_register_style('ts-extend-google-charts',                 				$url . 'css/jquery.vcsc.googlecharts.min.css', null, false, 'all');
    // Google Maps API
    wp_register_script('ts-extend-mapapi-none',									'https://maps.google.com/maps/api/js?sensor=false&libraries=places', false, false, false);
    wp_register_script('ts-extend-mapapi-geo',									'https://maps.google.com/maps/api/js?sensor=true&libraries=places', false, false, false);
    // Custom Google Map Scripts
    wp_register_script('ts-extend-infobox', 									$url . 'js/jquery.vcsc.infobox.min.js', array('jquery'), false, $FOOTER);
    wp_register_script('ts-extend-googlemap', 									$url . 'js/jquery.vcsc.googlemap.min.js', array('jquery'), false, $FOOTER);    
    wp_register_style('ts-extend-googlemapsplus',                 				$url . 'css/jquery.vcsc.gomapplus.min.css', null, false, 'all');
    wp_register_script('ts-extend-googlemapsplus', 								$url . 'js/jquery.vcsc.gomapplus.min.js', array('jquery'), false, $FOOTER);
    wp_register_script('ts-extend-markerclusterer', 							$url . 'js/jquery.vcsc.markerclusterer.min.js', array('jquery','ts-extend-googlemapsplus'), false, $FOOTER);    
    // Modernizr
    wp_register_script('ts-extend-modernizr',                					$url . 'js/jquery.vcsc.modernizr.min.js', array('jquery'), false, false);
    // Waypoints
    wp_register_script('ts-extend-waypoints',									$url . 'js/jquery.vcsc.waypoints.min.js', array('jquery'), false, $FOOTER);
    // Particles
    wp_register_script('ts-extend-particles',									$url . 'js/jquery.vcsc.particles.min.js', array('jquery'), false, $FOOTER);
    // Pricing Tables
    wp_register_style('ts-extend-pricingtables',                 				$url . 'css/jquery.vcsc.pricingtables.min.css', null, false, 'all');
    // Tooltipster Tooltips
    wp_register_style('ts-extend-tooltipster',                 					$url . 'css/jquery.vcsc.tooltipster.min.css', null, false, 'all');
    wp_register_script('ts-extend-tooltipster',									$url . 'js/jquery.vcsc.tooltipster.min.js', array('jquery'), false, $FOOTER);			
    // YouTube Player
    wp_register_style('ts-extend-ytplayer',										$url . 'css/jquery.vcsc.mb.ytplayer.min.css', null, false, 'all');
    wp_register_script('ts-extend-ytplayer',									$url . 'js/jquery.vcsc.mb.ytplayer.min.js', array('jquery'), false, false);
    // Multibackground Player
    wp_register_script('ts-extend-multibackground',								$url . 'js/jquery.vcsc.multibackground.min.js', array('jquery'), false, false);
    // CountUp Counter
    wp_register_script('ts-extend-countup',										$url . 'js/jquery.vcsc.countup.min.js', array('jquery'), false, $FOOTER);
    // CountTo Counter
    wp_register_script('ts-extend-countto',										$url . 'js/jquery.vcsc.countto.min.js', array('jquery'), false, $FOOTER);
    // Circliful Counter
    wp_register_script('ts-extend-circliful', 									$url . 'js/jquery.vcsc.circliful.min.js', array('jquery'), false, $FOOTER);
    // Countdown Script
    wp_register_style('ts-extend-countdown',									$url . 'css/jquery.vcsc.counteverest.min.css', null, false, 'all');
    wp_register_script('ts-extend-countdown',									$url . 'js/jquery.vcsc.counteverest.min.js', array('jquery'), false, $FOOTER);
    wp_register_style('ts-extend-font-roboto',									'https://fonts.googleapis.com/css?family=Roboto:400', null, false, 'all');
    wp_register_style('ts-extend-font-unica',									'https://fonts.googleapis.com/css?family=Unica+One', null, false, 'all');
    // Buttons CSS
    wp_register_style('ts-extend-buttons',                 						$url . 'css/jquery.vcsc.buttons.min.css', null, false, 'all');
    // Buttons Flat CSS
    wp_register_style('ts-extend-buttonsflat',                 					$url . 'css/jquery.vcsc.buttons.flat.min.css', null, false, 'all');
    // Buttons Creative Link
    wp_register_style('ts-extend-creativelinks',                 				$url . 'css/jquery.vcsc.creativelinks.min.css', null, false, 'all');
    // Buttons Dual CSS
    wp_register_style('ts-extend-buttonsdual',                 					$url . 'css/jquery.vcsc.buttons.dual.min.css', null, false, 'all');
    // Badonkatrunc Shortener
    wp_register_script('ts-extend-badonkatrunc',								$url . 'js/jquery.vcsc.badonkatrunc.min.js', array('jquery'), false, $FOOTER);
    // QR-Code Maker
    wp_register_script('ts-extend-qrcode',										$url . 'js/jquery.vcsc.qrcode.min.js', array('jquery'), false, $FOOTER);
    // Image Adipoli
    wp_register_script('ts-extend-adipoli', 									$url . 'js/jquery.vcsc.adipoli.min.js', array('jquery'), false, $FOOTER);
    // Amaran Popup
    wp_register_style('ts-extend-amaran',				        				$url . 'css/jquery.vcsc.amaran.min.css', null, false, 'all');
    wp_register_script('ts-extend-amaran',			            				$url . 'js/jquery.vcsc.amaran.min.js', array('jquery'), false, $FOOTER);
    // SweetAlert Popup
    wp_register_style('ts-extend-sweetalert',				        			$url . 'css/jquery.vcsc.sweetalert.min.css', null, false, 'all');
    wp_register_script('ts-extend-sweetalert',			            			$url . 'js/jquery.vcsc.sweetalert.min.js', array('jquery'), false, $FOOTER);
    // Image Caman
    wp_register_script('ts-extend-caman', 										$url . 'js/jquery.vcsc.caman.full.min.js', array('jquery'), false, $FOOTER);
    // Owl Carousel 2
    wp_register_style('ts-extend-owlcarousel2',				        			$url . 'css/jquery.vcsc.owl.carousel.min.css', null, false, 'all');
    wp_register_script('ts-extend-owlcarousel2',			            		$url . 'js/jquery.vcsc.owl.carousel.min.js', array('jquery'), false, $FOOTER);			
    // Flex Slider 2
    wp_register_style('ts-extend-flexslider2',				        			$url . 'css/jquery.vcsc.flexslider.min.css', null, false, 'all');
    wp_register_script('ts-extend-flexslider2',			            			$url . 'js/jquery.vcsc.flexslider.min.js', array('jquery'), false, $FOOTER);
    // Nivo Slider
    wp_register_style('ts-extend-nivoslider',				        			$url . 'css/jquery.vcsc.nivoslider.min.css', null, false, 'all');	
    wp_register_script('ts-extend-nivoslider',			            			$url . 'js/jquery.vcsc.nivoslider.min.js', array('jquery'), false, $FOOTER);
    // SliceBox Slider
    wp_register_style('ts-extend-slicebox',				        				$url . 'css/jquery.vcsc.slicebox.min.css', null, false, 'all');
    wp_register_script('ts-extend-slicebox',			            			$url . 'js/jquery.vcsc.slicebox.min.js', array('jquery'), false, $FOOTER);
    // Line Stack Slider
    wp_register_style('ts-extend-stackslider',				        			$url . 'css/jquery.vcsc.stackslider.min.css', null, false, 'all');
    wp_register_script('ts-extend-stackslider',			            			$url . 'js/jquery.vcsc.stackslider.min.js', array('jquery'), false, $FOOTER);
    // Polaroid Stack Slider
    wp_register_style('ts-extend-polaroidgallery',				        		$url . 'css/jquery.vcsc.polaroidgallery.min.css', null, false, 'all');
    wp_register_script('ts-extend-polaroidgallery',			            		$url . 'js/jquery.vcsc.polaroidgallery.min.js', array('jquery'), false, $FOOTER);
    wp_register_script('ts-extend-transformmatrix',			            		$url . 'js/jquery.vcsc.transformmatrix.min.js', array('jquery'), false, $FOOTER);
    // Slides.js Slider
    wp_register_style('ts-extend-slidesjs',				        			    $url . 'css/jquery.vcsc.slides.min.css', null, false, 'all');
    wp_register_script('ts-extend-slidesjs',			            			$url . 'js/jquery.vcsc.slides.min.js', array('jquery'), false, $FOOTER);
    // DropDown Script
    wp_register_style('ts-extend-dropdown', 									$url . 'css/jquery.vcsc.dropdown.min.css', null, false, 'all');
    wp_register_script('ts-extend-dropdown', 									$url . 'js/jquery.vcsc.dropdown.min.js', array('jquery'), false, true);
    // Isotope Script
    wp_register_script('ts-extend-isotope',										$url . 'js/jquery.vcsc.isotope.min.js', array('jquery'), false, $FOOTER);
    // Parallaxify Script
    wp_register_script('ts-extend-parallaxify',									$url . 'js/jquery.vcsc.parallaxify.min.js', array('jquery'), false, $FOOTER);
    // Trianglify Script
    wp_register_script('ts-extend-trianglify',									$url . 'js/jquery.vcsc.trianglify.min.js', array('jquery'), false, $FOOTER);
    // NewsTicker
    wp_register_script('ts-extend-newsticker',			            			$url . 'js/jquery.vcsc.newsticker.min.js', array('jquery'), false, $FOOTER);
    // vTicker
    wp_register_script('ts-extend-vticker',			            				$url . 'js/jquery.vcsc.vticker.min.js', array('jquery'), false, $FOOTER);
    // Typed
    wp_register_script('ts-extend-typed',			            				$url . 'js/jquery.vcsc.typed.min.js', array('jquery'), false, $FOOTER);
    // Raphaël
    wp_register_script('ts-extend-raphael',			            				$url . 'js/jquery.vcsc.raphael.min.js', array('jquery'), false, $FOOTER);
    // Mousewheel
    wp_register_script('ts-extend-mousewheel',			            			$url . 'js/jquery.vcsc.mousewheel.min.js', array('jquery'), false, $FOOTER);
    // NiceScroll
    wp_register_script('ts-extend-nicescroll',			            			$url . 'js/jquery.vcsc.nicescroll.min.js', array('jquery'), false, $FOOTER);
    // Snap SVG
    wp_register_script('ts-extend-snapsvg',			            				$url . 'js/jquery.vcsc.snap.svg.min.js', array('jquery'), false, $FOOTER);
    // iPresenter Script
    wp_register_style('ts-extend-ipresenter', 									$url . 'css/jquery.vcsc.ipresenter.min.css', null, false, 'all');
    wp_register_script('ts-extend-ipresenter', 									$url . 'js/jquery.vcsc.ipresenter.min.js', array('jquery'), false, true);
    // SlitSlider Script
    wp_register_style('ts-extend-slitslider', 									$url . 'css/jquery.vcsc.slitslider.min.css', null, false, 'all');
    wp_register_script('ts-extend-slitslider', 									$url . 'js/jquery.vcsc.slitslider.min.js', array('jquery'), false, true);
    // Image Hover Effects
    wp_register_style('ts-extend-hovereffects', 								$url . 'css/jquery.vcsc.hovereffects.min.css', null, false, 'all');
    // Zoomer Script
    wp_register_style('ts-extend-zoomer', 										$url . 'css/jquery.vcsc.zoomer.min.css', null, false, 'all');
    wp_register_script('ts-extend-zoomer', 										$url . 'js/jquery.vcsc.zoomer.min.js', array('jquery'), false, true);
    // Vegas Script
    wp_register_style('ts-extend-vegas', 										$url . 'css/jquery.vcsc.vegas.min.css', null, false, 'all');
    wp_register_script('ts-extend-vegas', 										$url . 'js/jquery.vcsc.vegas.min.js', array('jquery'), false, true);
    // Wallpaper Script
    wp_register_style('ts-extend-wallpaper', 									$url . 'css/jquery.vcsc.wallpaper.min.css', null, false, 'all');
    wp_register_script('ts-extend-wallpaper', 									$url . 'js/jquery.vcsc.wallpaper.min.js', array('jquery'), false, true);
    // Flipboard Title
    wp_register_script('ts-extend-flipflap',			            			$url . 'js/jquery.vcsc.flipflap.min.js', array('jquery'), false, $FOOTER);
    // CSS Timeline
    wp_register_style('ts-extend-csstimeline', 									$url . 'css/jquery.vcsc.csstimeline.min.css', null, false, 'all');
    wp_register_script('ts-extend-csstimeline',			            			$url . 'js/jquery.vcsc.csstimeline.min.js', array('jquery'), false, $FOOTER);
    // Sumo Select
    wp_register_style('ts-extend-sumo', 				        				$url . 'css/jquery.vcsc.sumoselect.min.css', null, false, 'all');
    wp_register_script('ts-extend-sumo', 										$url . 'js/jquery.vcsc.sumoselect.min.js', array('jquery'), false, true);
    // Fancy Tabs Script
    wp_register_style('ts-extend-fancytabs', 									$url . 'css/jquery.vcsc.pwstabs.min.css', null, false, 'all');
    wp_register_script('ts-extend-fancytabs', 									$url . 'js/jquery.vcsc.pwstabs.min.js', array('jquery'), false, true);
    // Single Page Navigator Script
    wp_register_style('ts-extend-singlepage', 									$url . 'css/jquery.vcsc.singlepage.min.css', null, false, 'all');
    wp_register_script('ts-extend-singlepage', 									$url . 'js/jquery.vcsc.singlepage.min.js', array('jquery'), false, true);
    // jQuery Transit
    wp_register_script('ts-extend-transit', 									$url . 'js/jquery.vcsc.transit.min.js', array('jquery'), false, true);
    // Icon Wall
    wp_register_style('ts-extend-iconwall', 									$url . 'css/jquery.vcsc.iconwall.min.css', null, false, 'all');
    wp_register_script('ts-extend-iconwall', 									$url . 'js/jquery.vcsc.iconwall.min.js', array('jquery'), false, true);
    // Image Shapes
    wp_register_style('ts-extend-imageshapes', 									$url . 'css/jquery.vcsc.imageshapes.min.css', null, false, 'all');
    wp_register_script('ts-extend-imageshapes', 								$url . 'js/jquery.vcsc.imageshapes.min.js', array('jquery'), false, true);
    // Honeycomb Grid
    wp_register_style('ts-extend-honeycombs', 									$url . 'css/jquery.vcsc.honeycombs.min.css', null, false, 'all');
    wp_register_script('ts-extend-honeycombs', 								    $url . 'js/jquery.vcsc.honeycombs.min.js', array('jquery'), false, true);
    // Circle Loop Steps
    wp_register_style('ts-extend-circlesteps', 									$url . 'css/jquery.vcsc.circlesteps.min.css', null, false, 'all');
    wp_register_script('ts-extend-circlesteps', 								$url . 'js/jquery.vcsc.circlesteps.min.js', array('jquery'), false, true);
    // Syntax Highlighter
    wp_register_script('ts-extend-enlighterjs',                                 $url . 'js/mootools.enlighterjs.min.js', array('ts-library-mootools'), false, true);
    wp_register_style('ts-extend-enlighterjs',                                  $url . 'css/mootools.enlighterjs.min.css', null, false, 'all');
    wp_register_style('ts-extend-syntaxinit',						            $url . 'css/jquery.vcsc.syntaxinit.min.css', null, false, 'all');
    wp_register_script('ts-extend-syntaxinit',						            $url . 'js/jquery.vcsc.syntaxinit.min.js', array('jquery','ts-library-mootools','ts-extend-enlighterjs'), false, $FOOTER);
    // PgwSlideshow
    wp_register_style('ts-extend-pgwslideshow',						            $url . 'css/jquery.vcsc.pgwslideshow.min.css', null, false, 'all');
    wp_register_script('ts-extend-pgwslideshow',                                $url . 'js/jquery.vcsc.pgwslideshow.min.js', array('jquery'), false, $FOOTER);
    
    
    // Back-End Files
    // --------------
    // NoUiSlider
    wp_register_style('ts-extend-nouislider',									$url . 'css/jquery.vcsc.nouislider.min.css', null, false, 'all');
    wp_register_script('ts-extend-nouislider',									$url . 'js/jquery.vcsc.nouislider.min.js', array('jquery'), false, true);
    // MultiSelect
    wp_register_style('ts-extend-multiselect',									$url . 'css/jquery.vcsc.multi.select.min.css', null, false, 'all');
    wp_register_script('ts-extend-multiselect',									$url . 'js/jquery.vcsc.multi.select.min.js', array('jquery'), false, $FOOTER);
    // Toggles / Switch
    wp_register_script('ts-extend-toggles',										$url . 'js/jquery.vcsc.toggles.min.js', array('jquery'), false, true);
    // Freewall
    wp_register_script('ts-extend-freewall', 									$url . 'js/jquery.vcsc.freewall.min.js', array('jquery'), false, $FOOTER);
    // Brickwork
    wp_register_script('ts-extend-brickwork', 									$url . 'js/jquery.vcsc.brickwork.min.js', array('jquery'), false, true);
    // Date & Time Picker
    wp_register_script('ts-extend-picker',										$url . 'js/jquery.vcsc.datetimepicker.min.js', array('jquery'), false, true);
    // Lightbox Me
    wp_register_script('ts-extend-lightboxme',									$url . 'js/jquery.vcsc.lightboxme.min.js', array('jquery', 'wp-color-picker'), false, true);
    // ZeroClipboard
    wp_register_script('ts-extend-zclip',										$url . 'js/jquery.vcsc.zeroclipboard.min.js', array('jquery'), false, true);
    // Rainbow Syntax
    wp_register_script('ts-extend-rainbow',										$url . 'js/jquery.vcsc.rainbow.min.js', array('jquery'), false, true);
    // Messi Popup
    wp_register_style('ts-extend-messi', 				        				$url . 'css/jquery.vcsc.messi.min.css', null, false, 'all');
    wp_register_script('ts-extend-messi',                            			$url . 'js/jquery.vcsc.messi.min.js', array('jquery'), false, true);
    // DragSort
    wp_register_script('ts-extend-dragsort',									$url . 'js/jquery.vcsc.dragsort.min.js', array('jquery'), false, true);
    // ToTop Scroller
    wp_register_style('ts-extend-uitotop', 										$url . 'css/jquery.vcsc.ui.totop.min.css', null, false, 'all');
    wp_register_script('ts-extend-uitotop', 									$url . 'js/jquery.vcsc.ui.totop.min.js', array('jquery'), false, true);
    // jQuery Easing
    wp_register_script('jquery-easing', 										$url . 'js/jquery.vcsc.easing.min.js', array('jquery'), false, true);
    // Select 2
    wp_register_style('ts-extend-select2',										$url . 'css/jquery.vcsc.select2.min.css', null, false, 'all');
    wp_register_script('ts-extend-select2',										$url . 'js/jquery.vcsc.select2.min.js', array('jquery'), false, true);
    // Validation Engine
    wp_register_script('validation-engine', 									$url . 'js/jquery.vcsc.validationengine.min.js', array('jquery'), false, true);
    wp_register_style('validation-engine',										$url . 'css/jquery.vcsc.validationengine.min.css', null, false, 'all');
    wp_register_script('validation-engine-en', 									$url . 'js/jquery.vcsc.validationengine.en.min.js', array('jquery'), false, true);
    
    // Visual Composer Backbone
    wp_register_script('ts-vcsc-backend-rows',									$url . 'js/backend/ts-vcsc-backend-rows.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    wp_register_script('ts-vcsc-backend-other',									$url . 'js/backend/ts-vcsc-backend-other.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    wp_register_script('ts-vcsc-backend-basic',									$url . 'js/backend/ts-vcsc-backend-basic.min.js', array('jquery'), COMPOSIUM_VERSION, true);
    // Visual Composer Styling
    wp_register_style('ts-visual-composer-extend-composer',				        $url . 'css/ts-visual-composer-extend-composer.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_style('ts-visual-composer-extend-preview',						$url . 'css/ts-visual-composer-extend-preview.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_style('ts-visual-composer-extend-basic',						$url . 'css/ts-visual-composer-extend-basic.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_style('ts-visual-composer-extend-editor',						$url . 'css/ts-visual-composer-extend-editor.min.css', null, COMPOSIUM_VERSION, 'all');
    // Widgets
    wp_register_style('ts-visual-composer-extend-widgets',						$url . 'css/ts-visual-composer-extend-widgets.min.css', null, COMPOSIUM_VERSION, 'all');
    wp_register_script('ts-visual-composer-extend-widgets',						$url . 'js/ts-visual-composer-extend-widgets.min.js', array('jquery'), COMPOSIUM_VERSION, $FOOTER);
?>
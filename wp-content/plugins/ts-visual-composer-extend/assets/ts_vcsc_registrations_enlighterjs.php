<?php
	$this->TS_VCENLIGHTER_Defaults_Types = array (
		// Common Formats
		'generic'			=> array('name'	=> 'Generic',				'group'	=> 'common',		'value'	=> 'generic',			'order'	=> 0),
		'html'				=> array('name'	=> 'HTML',					'group'	=> 'common',		'value'	=> 'html',				'order'	=> 1),
		'javascript'		=> array('name'	=> 'JavaScript',			'group'	=> 'common',		'value'	=> 'javascript',		'order'	=> 2),
		'jquery'			=> array('name'	=> 'jQuery',				'group'	=> 'common',		'value'	=> 'jquery',			'order'	=> 3),
		'mootools'			=> array('name'	=> 'MooTools',				'group'	=> 'common',		'value'	=> 'mootools',			'order'	=> 4),
		'css'				=> array('name'	=> 'CSS',					'group'	=> 'common',		'value'	=> 'css',				'order'	=> 5),
		'php'				=> array('name'	=> 'PHP',					'group'	=> 'common',		'value'	=> 'php',				'order'	=> 6),
		'json'				=> array('name'	=> 'JSON',					'group'	=> 'common',		'value'	=> 'json',				'order'	=> 7),
		'java'				=> array('name'	=> 'JAVA',					'group'	=> 'common',		'value'	=> 'java',				'order'	=> 8),
		'xml'				=> array('name'	=> 'XML',					'group'	=> 'common',		'value'	=> 'xml',				'order'	=> 9),
		'sql'				=> array('name'	=> 'SQL',					'group'	=> 'common',		'value'	=> 'sql',				'order'	=> 10),
		'ini'				=> array('name'	=> 'INI / Config',			'group'	=> 'common',		'value'	=> 'ini',				'order'	=> 11),
		'raw'				=> array('name'	=> 'RAW',					'group'	=> 'common',		'value'	=> 'raw',				'order'	=> 12),
		'no-highlight'		=> array('name'	=> 'No-Highlight',			'group'	=> 'common',		'value'	=> 'no-highlight',		'order'	=> 13),
		// Special Formats
		'avrasm'			=> array('name'	=> 'AVR Assembler',			'group'	=> 'special',		'value'	=> 'avrasm',			'order'	=> 14),
		'c'					=> array('name'	=> 'C',						'group'	=> 'special',		'value'	=> 'c',					'order'	=> 15),
		'cpp'				=> array('name'	=> 'C++ (CPP)',				'group'	=> 'special',		'value'	=> 'cpp',				'order'	=> 16),
		'csharp'			=> array('name'	=> 'C# (CSharp)',			'group'	=> 'special',		'value'	=> 'csharp',			'order'	=> 17),
		'diff'				=> array('name'	=> 'DIFF',					'group'	=> 'special',		'value'	=> 'diff',				'order'	=> 18),
		'less'				=> array('name'	=> 'LESS',					'group'	=> 'special',		'value'	=> 'less',				'order'	=> 19),
		'markdown'			=> array('name'	=> 'MarkDown',				'group'	=> 'special',		'value'	=> 'markdown',			'order'	=> 20),
		'matlab'			=> array('name'	=> 'Matlab',				'group'	=> 'special',		'value'	=> 'matlab',			'order'	=> 21),
		'nsis'				=> array('name'	=> 'NSIS',					'group'	=> 'special',		'value'	=> 'nsis',				'order'	=> 22),
		'python'			=> array('name'	=> 'Python',				'group'	=> 'special',		'value'	=> 'python',			'order'	=> 23),
		'ruby'				=> array('name'	=> 'Ruby',					'group'	=> 'special',		'value'	=> 'ruby',				'order'	=> 24),
		'rust'				=> array('name'	=> 'Rust',					'group'	=> 'special',		'value'	=> 'rust',				'order'	=> 25),
		'shell'				=> array('name'	=> 'Shell Script',			'group'	=> 'special',		'value'	=> 'shell',				'order'	=> 26),
		'vhdl'				=> array('name'	=> 'VHDL',					'group'	=> 'special',		'value'	=> 'vhdl',				'order'	=> 27),
	);
    $this->TS_VCENLIGHTER_Selector_Types = array(
        __( 'Generic', "ts_visual_composer_extend" )				    => "generic",
        'HTML'					                                        => "html",
        'XML'					                                        => "xml",
        'JavaScript'				                                    => "javascript",
        'jQuery'					                                    => "jquery",
        'MooTools'				                                        => "mootools",
        'CSS'					                                        => "css",
        'C'						                                        => "c",
        'C++ (CPP)'				                                        => "cpp",
        'C# (CSharp)'			                                        => "csharp",
        'Java'					                                        => "java",
        'JSON'					                                        => "json",
        'LESS'					                                        => "less",
        'Python'					                                    => "python",
        'Ruby'					                                        => "ruby",
        'MarkDown'				                                        => "markdown",
        'PHP'					                                        => "php",
        'Shell Script '			                                        => "shell",
        'SQL'					                                        => "sql",
        'NSIS'					                                        => "nsis",
        'DIFF'					                                        => "diff",
        'Rust'					                                        => "rust",
        'VHDL'					                                        => "vhdl",
        'Matlab'					                                    => "matlab",
        'Ini / Conf. Syntax'		                                    => "ini",
        'AVR Assembler'			                                        => "avrasm",
        'RAW'					                                        => "raw",
        __( 'No-Highlight', "ts_visual_composer_extend" )			    => "no-highlight",
    );
	
    if ($this->TS_VCSC_UseThemeBuider == "true") {
        $this->TS_VCENLIGHTER_Defaults_Themes = array (
            'enlighter'		=> array('name'	=> 'Enlighter',				'group'	=> 'theme',			'value'	=> 'enlighter',			'order'	=> 0),
            'classic'		=> array('name'	=> 'Classic',				'group'	=> 'theme',			'value'	=> 'classic',			'order'	=> 1),
            'godzilla'		=> array('name'	=> 'Godzilla',				'group'	=> 'theme',			'value'	=> 'godzilla',			'order'	=> 2),
            'mootwo'		=> array('name'	=> 'MooTwo',				'group'	=> 'theme',			'value'	=> 'mootwo',			'order'	=> 3),
            'eclipse'		=> array('name'	=> 'Eclipse',				'group'	=> 'theme',			'value'	=> 'eclipse',			'order'	=> 4),
            'beyond'		=> array('name'	=> 'Beyond',				'group'	=> 'theme',			'value'	=> 'beyond',			'order'	=> 5),
            'droide'		=> array('name'	=> 'Droide',				'group'	=> 'theme',			'value'	=> 'droide',			'order'	=> 6),
            'git'			=> array('name'	=> 'GitHub',				'group'	=> 'theme',			'value'	=> 'git',				'order'	=> 7),
            'mocha'			=> array('name'	=> 'Mocha',					'group'	=> 'theme',			'value'	=> 'mocha',				'order'	=> 8),
            'mootools'		=> array('name'	=> 'MooTools',				'group'	=> 'theme',			'value'	=> 'mootools',			'order'	=> 9),
            'panic'			=> array('name'	=> 'Panic',					'group'	=> 'theme',			'value'	=> 'panic',				'order'	=> 10),
            'tutti'			=> array('name'	=> 'Tutti',					'group'	=> 'theme',			'value'	=> 'tutti',				'order'	=> 11),
            'twilight'		=> array('name'	=> 'Twilight',				'group'	=> 'theme',			'value'	=> 'twilight',			'order'	=> 12),
            'custom'		=> array('name'	=> 'Custom',				'group'	=> 'theme',			'value'	=> 'custom',			'order'	=> 13),
        );
        $this->TS_VCENLIGHTER_Selector_Themes = array(
            'Enlighter'			                                        => "enlighter",
            'Classic'			                                        => "classic",
            'Godzilla'			                                        => "godzilla",
            'MooTwo'				                                    => "mootwo",
            'Eclipse'			                                        => "eclipse",
            'Beyond'				                                    => "beyond",
            'Droide'				                                    => "droide",
            'GitHub'				                                    => "git",
            'Mocha'				                                        => "mocha",
            'MooTools'			                                        => "mootools",
            'Panic'				                                        => "panic",
            'Tutti'				                                        => "tutti",
            'Twilight'			                                        => "twilight",
            'Custom'				                                    => "custom",
        );
    } else {
        $this->TS_VCENLIGHTER_Defaults_Themes = array (
            'enlighter'		=> array('name'	=> 'Enlighter',				'group'	=> 'theme',			'value'	=> 'enlighter',			'order'	=> 0),
            'classic'		=> array('name'	=> 'Classic',				'group'	=> 'theme',			'value'	=> 'classic',			'order'	=> 1),
            'godzilla'		=> array('name'	=> 'Godzilla',				'group'	=> 'theme',			'value'	=> 'godzilla',			'order'	=> 2),
            'mootwo'		=> array('name'	=> 'MooTwo',				'group'	=> 'theme',			'value'	=> 'mootwo',			'order'	=> 3),
            'eclipse'		=> array('name'	=> 'Eclipse',				'group'	=> 'theme',			'value'	=> 'eclipse',			'order'	=> 4),
            'beyond'		=> array('name'	=> 'Beyond',				'group'	=> 'theme',			'value'	=> 'beyond',			'order'	=> 5),
            'droide'		=> array('name'	=> 'Droide',				'group'	=> 'theme',			'value'	=> 'droide',			'order'	=> 6),
            'git'			=> array('name'	=> 'GitHub',				'group'	=> 'theme',			'value'	=> 'git',				'order'	=> 7),
            'mocha'			=> array('name'	=> 'Mocha',					'group'	=> 'theme',			'value'	=> 'mocha',				'order'	=> 8),
            'mootools'		=> array('name'	=> 'MooTools',				'group'	=> 'theme',			'value'	=> 'mootools',			'order'	=> 9),
            'panic'			=> array('name'	=> 'Panic',					'group'	=> 'theme',			'value'	=> 'panic',				'order'	=> 10),
            'tutti'			=> array('name'	=> 'Tutti',					'group'	=> 'theme',			'value'	=> 'tutti',				'order'	=> 11),
            'twilight'		=> array('name'	=> 'Twilight',				'group'	=> 'theme',			'value'	=> 'twilight',			'order'	=> 12),
        );
        $this->TS_VCENLIGHTER_Selector_Themes = array(
            'Enlighter'			                                        => "enlighter",
            'Classic'			                                        => "classic",
            'Godzilla'			                                        => "godzilla",
            'MooTwo'				                                    => "mootwo",
            'Eclipse'			                                        => "eclipse",
            'Beyond'				                                    => "beyond",
            'Droide'				                                    => "droide",
            'GitHub'				                                    => "git",
            'Mocha'				                                        => "mocha",
            'MooTools'			                                        => "mootools",
            'Panic'				                                        => "panic",
            'Tutti'				                                        => "tutti",
            'Twilight'			                                        => "twilight",
        );
    }
    
    $this->TS_VCENLIGHTER_Defaults_SafeFonts = array (
        'websafe01' 	    => array('syntax' 	=> 'Arial, Helvetica, sans-serif'),
        'websafe02' 	    => array('syntax' 	=> 'Arial Black, Gadget, sans-serif'),
        'websafe03' 	    => array('syntax' 	=> 'Bookman Old Style, serif'),
        'websafe04' 	    => array('syntax' 	=> 'Comic Sans MS, cursive'),
        'websafe04' 	    => array('syntax' 	=> 'Courier, monospace'),
        'websafe05' 	    => array('syntax' 	=> 'Courier New, Courier, monospace'),
        'websafe07' 	    => array('syntax' 	=> 'Garamond, serif'),
        'websafe08' 	    => array('syntax' 	=> 'Georgia, serif'),
        'websafe09' 	    => array('syntax' 	=> 'Impact, Charcoal, sans-serif'),
        'websafe10' 	    => array('syntax' 	=> 'Lucida Console, Monaco, monospace'),
        'websafe11' 	    => array('syntax' 	=> 'Lucida Grande, Lucida Sans Unicode, sans-serif'),
        'websafe12' 	    => array('syntax' 	=> 'MS Sans Serif, Geneva, sans-serif'),
        'websafe13' 	    => array('syntax' 	=> 'MS Serif, New York, sans-serif'),
        'websafe14' 	    => array('syntax' 	=> 'Palatino Linotype, Book Antiqua, Palatino, serif'),
        'websafe15' 	    => array('syntax' 	=> 'Tahoma, Geneva, sans-serif'),
        'websafe16' 	    => array('syntax' 	=> 'Times New Roman, Times, serif'),
        'websafe17' 	    => array('syntax' 	=> 'Trebuchet MS, Helvetica, sans-serif'),
        'websafe18' 	    => array('syntax' 	=> 'Verdana, Geneva, sans-serif'),
        'websafe19'		    => array('syntax'	=> 'Consolas, "Source Code Pro", "Courier New", Monospace'),
        'websafe20'		    => array('syntax'	=> 'Menlo, Monaco, Consolas, "Source Code Pro", "Courier New", Monospace'),
        'websafe21'		    => array('syntax'	=> 'Monaco, Courier, Monospace'),
    );
    
	$this->TS_VCENLIGHTER_Defaults_TokenKeys = array(
		'Keytype1'			=> array('token'    => 'kw1'),
		'Keytype2'			=> array('token'    => 'kw2'),
		'Keytype3'			=> array('token'    => 'kw3'),
		'Keytype4'			=> array('token'    => 'kw4'),		
		'Comments1'			=> array('token'    => 'co1'),
		'Comments2'			=> array('token'    => 'co2'),
		'Chaintype1'		=> array('token'    => 'st0'),
		'Chaintype2'		=> array('token'    => 'st1'),
		'Chaintype3'		=> array('token'    => 'st2'),
		'Numbers'			=> array('token'    => 'nu0'),
		'Methodstype1'		=> array('token'    => 'me0'),
		'Methodstype2'		=> array('token'    => 'me1'),
		'Brackets'			=> array('token'    => 'br0'),
		'Symbols'			=> array('token'    => 'sy0'),
		'Escape'			=> array('token'    => 'es0'),
		'Regex'				=> array('token'    => 're0'),
		'Sepstart'			=> array('token'    => 'de1'),
		'Sepstop'			=> array('token'    => 'de2'),
	);

	$this->TS_VCENLIGHTER_Defaults_CustomTheme = array (
		// General Styles
		'General'			=> array('style' => 'general',		'string' => 'General Styles', 				'type' => 'websafe19', 			'size' => '12', 			            'height' => '16', 			'color' => '#000000', 		'background' => '#ffffff',  'borderwidth' => '1',               'bordercolor' => '#e0e0e0',        'bordertype' => 'solid'),
		// Line Number Styles
		'Lines'				=> array('style' => 'lines',		'string' => 'Line Number Styles', 			'type' => 'websafe19', 			'size' => '11', 			            'color' => '#aaaaaa', 		'background' => '#f9f9f9',  'borderwidth' => '1',       'bordercolor' => '#e0e0e0',         'bordertype' => 'solid'),
		// Original Code Styles	
		'Original'			=> array('style' => 'original',		'string' => 'Original Code Styles', 		'string' => 'General Styles', 	'type' => 'websafe19', 		            'size' => '12', 			'height' => '18', 			'color' => '#717171', 		'background' => '#ffffff'),
		// Special Styles
		'Special'			=> array('style' => 'special',		'string' => 'Special Styles', 				'string' => 'General Styles', 	'highlight' => '#fdf5f0', 	            'hover' => '#fffcd3'),
		// Segment Styles
		'Keytype1'			=> array('style' => 'segment',		'string' => 'Keyword (Type 1)', 			'color' => '#286491', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'bold', 		'decoration' => 'none'),
		'Keytype2'			=> array('style' => 'segment',		'string' => 'Keyword (Type 2)', 			'color' => '#4da0d2', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Keytype3'			=> array('style' => 'segment',		'string' => 'Keyword (Type 3)', 			'color' => '#445588', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Keytype4'			=> array('style' => 'segment',		'string' => 'Keyword (Type 4)', 			'color' => '#990073', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),		
		'Comments1'			=> array('style' => 'segment',		'string' => 'Comments (One Line)', 			'color' => '#9999aa', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Comments2'			=> array('style' => 'segment',		'string' => 'Comments (Multiple Lines)', 	'color' => '#9999aa', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Chaintype1'		=> array('style' => 'segment',		'string' => 'Characters (Type 1)', 			'color' => '#dd1144', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'bold', 		'decoration' => 'none'),
		'Chaintype2'		=> array('style' => 'segment',		'string' => 'Characters (Type 2)', 			'color' => '#dd1144', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Chaintype3'		=> array('style' => 'segment',		'string' => 'Characters (Type 3)', 			'color' => '#dd1144', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Numbers'			=> array('style' => 'segment',		'string' => 'Numbers', 						'color' => '#009999', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Methodstype1'		=> array('style' => 'segment',		'string' => 'Methods (Type 1)', 			'color' => '#0086b3', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Methodstype2'		=> array('style' => 'segment',		'string' => 'Methods (Type 2)', 			'color' => '#0086b3', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Brackets'			=> array('style' => 'segment',		'string' => 'Bracket Characters', 			'color' => '#777777', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Symbols'			=> array('style' => 'segment',		'string' => 'Symbol Characters', 			'color' => '#777777', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Escape'			=> array('style' => 'segment',		'string' => 'Escape Characters', 			'color' => '#777777', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Regex'				=> array('style' => 'segment',		'string' => 'Regex', 						'color' => '#009926', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Sepstart'			=> array('style' => 'segment',		'string' => 'Start Separator', 				'color' => '#CF6A4C', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
		'Sepstop'			=> array('style' => 'segment',		'string' => 'Stop Separator', 				'color' => '#CF6A4C', 		'background' => 'rgba(255,255,255,0)', 		'weight' => 'normal', 		'decoration' => 'none'),
        // Group Styles
        'Controls'          => array('style' => 'controls',     'string' => 'Control Styles',               'background' => '#f9f9f9'),
        'Buttons'           => array('style' => 'button',       'string' => 'Button Styles',                'type' => 'websafe19',      'size' => '12',                             'color' => '#000000',       'background' => '#f9f9f9',  'borderwidth' => '1',       'bordercolor' => '#e0e0e0',         'bordertype' => 'solid'),
        'Selected'          => array('style' => 'selected',     'string' => 'Selected Styles',              'color' => '#000000',       'background' => '#e5e5e5',                  'bordercolor' => '#c9c9c9'),
        'Hover'             => array('style' => 'hover',        'string' => 'Hover Styles',                 'color' => '#000000',       'background' => '#e5e5e5',                  'bordercolor' => '#c9c9c9'),
    );
    
    $this->TS_VCENLIGHTER_Retrieve_Types      		= get_option('ts_vcsc_extend_settings_orderTypes',			$this->TS_VCENLIGHTER_Defaults_Types);
	$this->TS_VCENLIGHTER_Retrieve_Themes      		= get_option('ts_vcsc_extend_settings_orderThemes',			$this->TS_VCENLIGHTER_Defaults_Themes);
    $this->TS_VCENLIGHTER_Retrieve_CustomTheme      = get_option('ts_vcsc_extend_settings_customTheme',		    $this->TS_VCENLIGHTER_Defaults_CustomTheme);

    
    // Generate CSS for Custom Theme Styling
    // -------------------------------------
    if (!function_exists('TS_VCSC_GenerateCustomCSS')){
        function TS_VCSC_GenerateCustomCSS(){
            global $VISUAL_COMPOSER_EXTENSIONS;
            
            // Load CSS Template
            $cssTPL 						= new TS_VCSC_SimpleTemplate($VISUAL_COMPOSER_EXTENSIONS->templates_dir . 'ts-enlighter-template.css');
            
            // ========= TOKEN STYLES =====================
            foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_TokenKeys as $Group => $token) {
                $tokenstyle 		= '';
                $tokenkey			= $Group;
                $tokenname			= $token['token'];
                // Text Color Overwrite
                if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["color"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["color"] : $VISUAL_COMPOSER_ENLIGHTERJS->TS_VCENLIGHTER_Defaults_CustomTheme[$tokenkey]["color"])) != false) {
                    $tokenstyle 	.= 'color: ' . $o . ';';
                }
                // Background Color Overwrite
                if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["background"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["background"] : $VISUAL_COMPOSER_ENLIGHTERJS->TS_VCENLIGHTER_Defaults_CustomTheme[$tokenkey]["background"])) != false) {
                    $tokenstyle 	.= 'background-color: ' . $o . ';';
                }
                // Style Overwrite
                if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["weight"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["weight"] : $VISUAL_COMPOSER_ENLIGHTERJS->TS_VCENLIGHTER_Defaults_CustomTheme[$tokenkey]["weight"])) != false) {
                    switch ($o){
                        case 'bold':
                            $tokenstyle .= 'font-weight: bold;';
                            break;
                        case 'italic':
                            $tokenstyle .= 'font-style: italic;';
                            break;
                        case 'bolditalic':
                            $tokenstyle .= 'font-weight: bold; font-style: italic;';
                            break;
                    }
                }	
                // Decoration Overwrite
                if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["decoration"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme[$tokenkey]["decoration"] : $VISUAL_COMPOSER_ENLIGHTERJS->TS_VCENLIGHTER_Defaults_CustomTheme[$tokenkey]["decoration"])) != false) {
                    switch ($o){
                        case 'overline':
                            $tokenstyle .= 'text-decoration: overline;';
                            break;
                        case 'underline':
                            $tokenstyle .= 'text-decoration: underline';
                            break;
                        case 'through':
                            $tokenstyle .= 'text-decoration: line-through;';
                            break;
                    }
                }
                // Assign Token Style
                $cssTPL->assign(strtoupper($tokenname), $tokenstyle);
            }
            
            // Define Style Holders
            $fontstyles 					= '';
            $linestyles 					= '';
            $rawstyles 						= '';
            $buttonstyles 					= '';
            $selectedstyles 				= '';
            $hoverstyles 					= '';
            
            // ========= GENERAL STYLES ===================			
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["type"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["type"])) != false) {
                $fontstyles .= 'font-family: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts[$o]['syntax'] . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["size"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["size"])) != false) {
                $fontstyles .= 'font-size: ' . $o . 'px;';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["height"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["height"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["height"])) != false) {
                $fontstyles .= 'line-height: ' . $o . 'px;';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["color"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["color"])) != false) {
                $fontstyles .= 'color: ' . $o . ';';
            }
            // Assign General Styles
            $cssTPL->assign('FONTSTYLE', $fontstyles);
            // Assign General Border Styles
            $borderwidth					= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["borderwidth"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["borderwidth"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["borderwidth"]);
            $bordertype						= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["bordertype"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["bordertype"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["bordertype"]);
            $bordercolor					= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["bordercolor"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["bordercolor"]);
            $cssTPL->assign('GENERAL_BORDER', $borderwidth . 'px ' . $bordertype . ' ' . $bordercolor);
            // Assign Standard Background Color
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["background"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["General"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["General"]["background"])) != false) {
                $cssTPL->assign('GENERAL_BG_COLOR', $o);
            }
    
            // ========= LINES STYLES =====================			
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["type"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["type"])) != false) {
                $linestyles .= 'font-family: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts[$o]['syntax'] . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["size"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["size"])) != false) {
                $linestyles .= 'font-size: ' . $o . 'px;';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["color"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["color"])) != false) {
                $linestyles .= 'color: ' . $o . ';';
            }		
            // Assign Lines Styles
            $cssTPL->assign('LINESTYLE', $linestyles);
            // Assign Lines Border Styles
            $borderwidth					= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["borderwidth"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["borderwidth"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["borderwidth"]);
            $bordertype						= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["bordertype"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["bordertype"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["bordertype"]);
            $bordercolor					= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["bordercolor"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["bordercolor"]);
            $cssTPL->assign('LINES_BORDER', $borderwidth . 'px ' . $bordertype . ' ' . $bordercolor);
            // Assign Lines Background Color
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["background"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Lines"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Lines"]["background"])) != false) {
                $cssTPL->assign('LINES_BG_COLOR', $o);
            }
            
            // ========= SPECIAL STYLES ====================
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Special"]["highlight"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Special"]["highlight"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["highlight"])) != false) {
                $cssTPL->assign('HIGHLIGHT_BG_COLOR', $o);
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Special"]["hover"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Special"]["hover"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Special"]["hover"])) != false) {
                $cssTPL->assign('HOVER_BG_COLOR', $o);
            }
            
            // ========= RAW STYLES ========================			
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["type"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["type"])) != false) {
                $rawstyles .= 'font-family: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts[$o]['syntax'] . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["size"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["size"])) != false) {
                $rawstyles .= 'font-size: ' . $o . 'px;';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["height"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["height"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["height"])) != false) {
                $rawstyles .= 'line-height: ' . $o . 'px;';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["color"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["color"])) != false) {
                $rawstyles .= 'color: ' . $o . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["background"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Original"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Original"]["background"])) != false) {
                $rawstyles .= 'background-color: ' . $o . ';';
            }			
            $cssTPL->assign('RAWSTYLE', $rawstyles);
            
            // ========= BUTTON STYLES =====================			
            $borderwidth 					= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["borderwidth"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["borderwidth"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["borderwidth"]);
            $bordertype 					= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["bordertype"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["bordertype"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["bordertype"]);
            $bordercolor 					= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["bordercolor"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["bordercolor"]);
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["type"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["type"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["type"])) != false) {
                $buttonstyles .= 'font-family: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_SafeFonts[$o]['syntax'] . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["size"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["size"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["size"])) != false) {
                $buttonstyles .= 'font-size: ' . $o . 'px;';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["color"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["color"])) != false) {
                $buttonstyles .= 'color: ' . $o . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["background"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Buttons"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Buttons"]["background"])) != false) {
                $buttonstyles .= 'background-color: ' . $o . ';';
            }
            $buttonstyles .= 'border: ' . $borderwidth . 'px ' . $bordertype . ' ' . $bordercolor . ';';
            $cssTPL->assign('BUTTONS_STYLE', $buttonstyles);
    
            // ========= SELECTED STYLES ===================			
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Selected"]["color"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Selected"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["color"])) != false) {
                $selectedstyles .= 'color: ' . $o . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Selected"]["background"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Selected"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["background"])) != false) {
                $selectedstyles .= 'background-color: ' . $o . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Selected"]["bordercolor"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Selected"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Selected"]["bordercolor"])) != false) {
                $selectedstyles .= 'border-color: ' . $o . ';';
            }
            $cssTPL->assign('SELECTED_STYLE', $selectedstyles);
            
            // ========= HOVER STYLES ======================			
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Hover"]["color"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Hover"]["color"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["color"])) != false) {
                $hoverstyles .= 'color: ' . $o . ';';
            }			
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Hover"]["background"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Hover"]["background"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["background"])) != false) {
                $hoverstyles .= 'background-color: ' . $o . ';';
            }
            if (($o = (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme)) && (isset($VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Hover"]["bordercolor"]))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Retrieve_CustomTheme["Hover"]["bordercolor"] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Defaults_CustomTheme["Hover"]["bordercolor"])) != false) {
                $hoverstyles .= 'border-color: ' . $o . ';';
            }
            $cssTPL->assign('HOVER_STYLE', $hoverstyles);
            
            // ========= PREFIX / APPENDIX =================
            $enlighterJSBaseCSSPrepend 		= '';
            $enlighterJSBaseCSSAppend 		= '';
            
            $cssTPL->store('ts-enlighter-custom.css', $enlighterJSBaseCSSPrepend, $enlighterJSBaseCSSAppend);
        }
    }
    
    
    // Helper Class for Custom CSS Output
    // ----------------------------------
    if (!class_exists('TS_VCSC_SimpleTemplate')) {
        class TS_VCSC_SimpleTemplate {
            // list of assigned Variables
            private $_cssVars;	
            // Raw CSS Template
            private $_template;
            
            public function __construct($filename){
                // Initialize Variables List
                $this->_cssVars 	= array();			
                // Read Template
                $this->_template 	= file_get_contents($filename);
            }
            
            // assign key/value pair
            public function assign($key, $value){
                $this->_cssVars['$(' . $key . ')'] = $value;
            }
            
            // store rendered css file
            public function store($filename, $prepend = '', $append = ''){
                // render tpl
                $renderedTPL = $this->render();			
                echo $prepend . $renderedTPL . $append;
                // store
                //file_put_contents($filename, $prepend.$renderedTPL.$append);
            }
            
            // return tpl
            public function render(){
                // replace key/value pairs
                $tplData = str_replace(array_keys($this->_cssVars), array_values($this->_cssVars), $this->_template);			
                // filter non assigned template vars
                $tplData = preg_replace('/\$\([A-z_-]\)/i', '', $tplData);			
                return $tplData;
            }
        }
    }
?>
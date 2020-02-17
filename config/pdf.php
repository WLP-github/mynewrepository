<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'padauk' => [
				'R'  => 'Padauk-Regular.ttf',    // regular font
				'B'  => 'Padauk-Bold.ttf',       // optional: bold font
				'I'  => 'zawgyi.ttf',     // optional: italic font
				'BI' => 'zawgyi.ttf', // optional: bold-italic font
				// 'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
				// 'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
			],
			// ...add as many as you want.
			'zawgyi' => [
				'R'  => 'zawgyi.ttf',    // regular font
				'B'  => 'zawgyi.ttf',       // optional: bold font
				'I'  => 'zawgyi.ttf',     // optional: italic font
				'BI' => 'zawgyi.ttf', // optional: bold-italic font
				// 'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
				// 'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
				]
			],
			
];
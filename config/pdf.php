<?php

return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'default_font_size' => '12',
    'default_font' => 'amiri',
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10,
    'orientation' => 'P',
    'autoScriptToLang' => true,
    'autoLangToFont' => true,
    'custom_font_path' => base_path('resources/fonts/'), // تأكد من المسار
    'custom_font_data' => [
        'amiri' => [
            'R' => 'Amiri-Regular.ttf',
            'B' => 'Amiri-Bold.ttf',
            'I' => 'Amiri-Italic.ttf',
            'BI' => 'Amiri-BoldItalic.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ]
    ]
];

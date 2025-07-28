<?php

return [

    'show_warnings' => false,
    'orientation' => 'portrait',
    'default_font' => 'Cairo-Regular.ttf',

    'defines' => [
        "DOMPDF_ENABLE_REMOTE" => true,
        "DOMPDF_ENABLE_HTML5PARSER" => true,
        "DOMPDF_DEFAULT_MEDIA_TYPE" => "screen",
        "DOMPDF_DEFAULT_PAPER_SIZE" => "a4",
        "DOMPDF_FONT_DIR" => resource_path('resources/fonts/'),
        "DOMPDF_FONT_CACHE" => storage_path('resources/fonts/'),
    ],

    'font_dir' => resource_path('resources/fonts/'), // ← لازم يكون نفس مكان ملفات الخطوط
    'font_cache' => storage_path('resources/fonts/'),

    'custom_font_dir' => resource_path('resources/fonts/'),
    'custom_font_data' => [
        'amiri' => [
            'R'  => 'Cairo-Regular.ttf',   // ← تأكد أن اسم الملف يطابق الموجود فعليًا' // ← اختياري
        ],
    ],
];

<?php

return [

    'accepted' => 'يجب قبول الحقل :attribute.',
    'accepted_if' => 'يجب قبول الحقل :attribute عندما يكون :other هو :value.',
    'active_url' => 'الحقل :attribute يجب أن يكون رابطاً صحيحاً.',
    'after' => 'الحقل :attribute يجب أن يكون تاريخاً بعد :date.',
    'after_or_equal' => 'الحقل :attribute يجب أن يكون تاريخاً بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي الحقل :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي الحقل :attribute على أحرف، أرقام، شرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي الحقل :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون الحقل :attribute مصفوفة.',
    'before' => 'الحقل :attribute يجب أن يكون تاريخاً قبل :date.',
    'before_or_equal' => 'الحقل :attribute يجب أن يكون تاريخاً قبل أو يساوي :date.',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف الحقل :attribute بين :min و :max.',
        'array' => 'يجب أن يحتوي الحقل :attribute على عدد عناصر بين :min و :max.',
    ],
    'boolean' => 'يجب أن تكون قيمة الحقل :attribute إما true أو false.',
    'confirmed' => 'تأكيد الحقل :attribute غير متطابق.',
    'date' => 'الحقل :attribute ليس تاريخاً صالحاً.',
    'date_equals' => 'يجب أن يكون الحقل :attribute تاريخاً مطابقاً لـ :date.',
    'date_format' => 'لا يتوافق الحقل :attribute مع التنسيق :format.',
    'different' => 'يجب أن يكون الحقل :attribute مختلفاً عن :other.',
    'digits' => 'يجب أن يحتوي الحقل :attribute على :digits رقم.',
    'digits_between' => 'يجب أن يحتوي الحقل :attribute على عدد أرقام بين :min و :max.',
    'email' => 'يجب أن يكون الحقل :attribute بريدًا إلكترونيًا صالحًا.',
    'exists' => 'القيمة المحددة في الحقل :attribute غير صالحة.',
    'file' => 'يجب أن يكون الحقل :attribute ملفًا.',
    'filled' => 'يجب ملء الحقل :attribute.',
    'gt' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف الحقل :attribute أكبر من :value.',
        'array' => 'يجب أن يحتوي الحقل :attribute على أكثر من :value عنصر.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أكبر من أو تساوي :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من أو يساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف الحقل :attribute أكبر من أو يساوي :value.',
        'array' => 'يجب أن يحتوي الحقل :attribute على :value عنصر أو أكثر.',
    ],
    'image' => 'يجب أن يكون الحقل :attribute صورة.',
    'in' => 'الحقل :attribute يحتوي على قيمة غير صالحة.',
    'integer' => 'يجب أن يكون الحقل :attribute عدداً صحيحاً.',
    'ip' => 'يجب أن يكون الحقل :attribute عنوان IP صالحاً.',
    'ipv4' => 'يجب أن يكون الحقل :attribute عنوان IPv4 صالحاً.',
    'ipv6' => 'يجب أن يكون الحقل :attribute عنوان IPv6 صالحاً.',
    'json' => 'يجب أن يكون الحقل :attribute نص JSON صالحاً.',
    'max' => [
        'numeric' => 'يجب ألا تكون قيمة الحقل :attribute أكبر من :max.',
        'file' => 'يجب ألا يتجاوز حجم الملف :attribute :max كيلوبايت.',
        'string' => 'يجب ألا يتجاوز عدد حروف الحقل :attribute :max.',
        'array' => 'يجب ألا يحتوي الحقل :attribute على أكثر من :max عنصر.',
    ],
    'mimes' => 'يجب أن يكون الملف :attribute من نوع: :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute على الأقل :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يحتوي الحقل :attribute على الأقل :min حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute على الأقل :min عناصر.',
    ],
    'not_in' => 'القيمة المحددة في الحقل :attribute غير صالحة.',
    'numeric' => 'يجب أن يكون الحقل :attribute رقماً.',
    'required' => 'الحقل :attribute مطلوب.',
    'same' => 'يجب أن يتطابق الحقل :attribute مع :other.',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute :size.',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت.',
        'string' => 'يجب أن يحتوي الحقل :attribute على :size حروف.',
        'array' => 'يجب أن يحتوي الحقل :attribute على :size عناصر.',
    ],
    'string' => 'يجب أن يكون الحقل :attribute نصاً.',
    'timezone' => 'يجب أن يكون الحقل :attribute نطاقاً زمنياً صالحاً.',
    'unique' => 'قيمة الحقل :attribute مستخدمة من قبل.',
    'url' => 'تنسيق الرابط في الحقل :attribute غير صالح.',

    'attributes' => [],

    // أضف هذا قبل السطر الأخير ]
    'custom' => [

        'national_id' => [
            'required' => 'رقم الهوية مطلوب.',
            'digits' => 'رقم الهوية يجب أن يتكون من 9 أرقام.',

        ],

        'name' => [
            'required' => 'الاسم مطلوب.',
            'string' => 'الاسم يجب أن يكون نصاً.',
            'max' => 'الاسم يجب ألا يتجاوز 100 حرف.',
            'regex' => 'الاسم يجب أن يحتوي على أحرف عربية ومسافات فقط.',
        ],

        'birth_date' => [
            'required' => 'تاريخ الميلاد مطلوب.',
            'date' => 'تاريخ الميلاد يجب أن يكون تاريخاً صالحاً.',
            'before' => 'تاريخ الميلاد يجب أن يكون في الماضي.',
        ],

        'health_status' => [
            'required' => 'الحالة الصحية مطلوبة.',
            'string' => 'الحالة الصحية يجب أن تكون نصاً.',
            'regex' => 'الحالة الصحية يجب أن تحتوي على أحرف عربية ومسافات فقط.',
        ],

        'academic_level' => [
            'required' => 'المستوى الأكاديمي مطلوب.',
            'in' => 'المستوى الأكاديمي يجب أن يكون أحد القيم التالية: ابتدائي، إعدادي، ثانوي، دبلوم، بكالوريا، جامعي، دراسات عليا.',
        ],

        'profession' => [
            'string' => 'المهنة يجب أن تكون نصاً.',
            'max' => 'المهنة يجب ألا تتجاوز 100 حرف.',
            'regex' => 'المهنة يجب أن تحتوي على أحرف عربية ومسافات فقط.',
        ],

        'marriages_count' => [
            'required' => 'عدد الزيجات مطلوب.',
            'integer' => 'عدد الزيجات يجب أن يكون رقماً صحيحاً.',
            'min' => 'عدد الزيجات يجب أن يكون واحدً أو أكثر.',
        ],

        'has_disabilities' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'disability_family' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'family_type' => [
            'required' => 'نوع الأسرة مطلوب.',
            'in' => 'نوع الأسرة يجب أن يكون إما "ممتدة" أو "نووية".',
        ],

        'has_health_insurance' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'health_insurance_reason' => [
            'string' => 'سبب عدم وجود تأمين صحي يجب أن يكون نصاً.',
            'max' => 'سبب عدم وجود تأمين صحي يجب ألا يتجاوز 255 حرفاً.',
            'regex' => 'سبب عدم وجود تأمين صحي يجب أن يحتوي على أحرف عربية ومسافات فقط.',
        ],

        'has_rehabilitation_centers' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'healthy_adults_count' => [
            'integer' => 'عدد البالغين الأصحاء يجب أن يكون رقماً صحيحاً.',
            'min' => 'عدد البالغين الأصحاء يجب أن يكون صفراً أو أكثر.',
        ],

        'annual_income' => [
            'required' => 'الدخل السنوي مطلوب.',
            'numeric' => 'الدخل السنوي يجب أن يكون رقماً.',
            'min' => 'الدخل السنوي يجب أن يكون صفراً أو أكثر.',
        ],

        'house_ownership' => [
            'required' => 'نوع ملكية السكن مطلوب.',
            'in' => 'نوع ملكية السكن يجب أن يكون "إيجار" أو "ملك".',
        ],

        'room_count' => [
            'required' => 'عدد الغرف مطلوب.',
            'integer' => 'عدد الغرف يجب أن يكون رقماً صحيحاً.',
            'min' => 'عدد الغرف يجب أن يكون صفراً أو أكثر.',
        ],

        'monthly_rent' => [
            'numeric' => 'الإيجار الشهري يجب أن يكون رقماً.',
            'min' => 'الإيجار الشهري يجب أن يكون صفراً أو أكثر.',
        ],

        'phone' => [
            'required' => 'رقم الهاتف مطلوب.',
            'string' => 'رقم الهاتف يجب أن يكون نصاً.',
            'regex' => 'رقم الهاتف يجب أن يتكون من 10 إلى 15 رقماً ',
        ],

    ],


        'family_id' => [
            'required' => 'رقم العائلة مطلوب.',
            'exists' => 'العائلة المحددة غير موجودة.',
        ],

    'name' => [
        'required' => 'الاسم مطلوب.',
        'string' => 'الاسم يجب أن يكون نصاً.',
        'max' => 'الاسم يجب ألا يتجاوز 100 حرف.',
        'regex' => 'الاسم يجب أن يحتوي على أحرف عربية ومسافات فقط.',
    ],


    'birth_date' => [
            'required' => 'تاريخ الميلاد مطلوب.',
            'date' => 'تاريخ الميلاد يجب أن يكون تاريخاً صالحاً.',
            'before' => 'تاريخ الميلاد يجب أن يكون في الماضي.',
        ],

        'health_status' => [
            'required' => 'الحالة الصحية مطلوبة.',
            'string' => 'الحالة الصحية يجب أن تكون نصاً.',
            'max' => 'الحالة الصحية يجب ألا تتجاوز 100 حرف.',
        ],

        'academic_level' => [
            'required' => 'المستوى الأكاديمي مطلوب.',
            'in' => 'المستوى الأكاديمي يجب أن يكون أحد القيم التالية: ابتدائي، إعدادي، ثانوي، دبلوم، بكالوريا، جامعي، دراسات عليا.',
        ],

        'profession' => [
            'string' => 'المهنة يجب أن تكون نصاً.',
            'max' => 'المهنة يجب ألا تتجاوز 100 حرف.',
        ],

        'marriages_count' => [
            'integer' => 'عدد الزيجات يجب أن يكون عدداً صحيحاً.',
            'min' => 'عدد الزيجات لا يمكن أن يكون سالباً.',
        ],


        'relationship_with_father' => [
            'required' => 'العلاقة مع الأب مطلوبة.',
            'string' => 'العلاقة مع الأب يجب أن تكون نصاً.',
            'max' => 'العلاقة مع الأب يجب ألا تتجاوز 50 حرفاً.',
        ],

        'has_disabilities' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'had_diseases_during_pregnancy' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'had_accidents_during_pregnancy' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'smoked_during_pregnancy' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'visited_doctor_during_pregnancy' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],

        'disability_family' => [
            'boolean' => 'قيمة الحقل يجب أن تكون true أو false.',
        ],
    'required' => 'حقل :attribute مطلوب.',
    'string' => 'حقل :attribute يجب أن يكون نصًا.',
    'max' => [
        'string' => 'حقل :attribute لا يجب أن يتجاوز :max حرفًا.',
    ],
    'min' => [
        'numeric' => 'حقل :attribute لا يجب أن يكون أقل من :min.',
        'integer' => 'حقل :attribute يجب أن يكون على الأقل :min.',
    ],
    'regex' => 'صيغة حقل :attribute غير صحيحة.',
    'date' => 'حقل :attribute يجب أن يكون تاريخًا صحيحًا.',
    'before' => 'حقل :attribute يجب أن يكون تاريخًا قبل اليوم.',
    'digits' => 'حقل :attribute يجب أن يتكون من :digits أرقام.',
    'unique' => 'قيمة :attribute مستخدمة من قبل.',
    'exists' => 'القيمة المحددة في :attribute غير موجودة.',
    'in' => 'القيمة المختارة في :attribute غير صالحة.',
    'boolean' => 'حقل :attribute يجب أن يكون نعم أو لا.',
    'numeric' => 'حقل :attribute يجب أن يكون رقمًا.',

    'attributes' => [
        'name' => 'الاسم',
        'birth_date' => 'تاريخ الميلاد',
        'disability_type_id' => 'نوع الإعاقة',
        'disability_cause_id' => 'سبب الإعاقة',
        'injury_date' => 'تاريخ الإصابة',
        'toilet_facilities' => 'مرافق المرحاض',
        'water_source' => 'مصدر المياه',
        'electricity_source' => 'مصدر الكهرباء',
        'family_order' => 'ترتيب الفرد في الأسرة',
        'relationship_to_head' => 'العلاقة مع رب الأسرة',
        'disabled_person_residence' => 'مكان إقامة ذوي الإعاقة',
        'education_reason' => 'سبب نوع التعليم',
        'education_type' => 'نوع التعليم',
        'unwra_card_number' => 'رقم بطاقة الأونروا',
        'employment_type' => 'نوع العمل',
        'job_type' => 'نوع الوظيفة',
        'employment_method' => 'طريقة التوظيف',
        'vocational_training' => 'التدريب المهني',
        'social_case_responsible' => 'مسؤول الحالة الاجتماعية',
        'disability_union_responsible' => 'تابع لاتحاد ذوي الإعاقة',
        'employment_status' => 'حالة العمل',
        'refugee_status' => 'حالة اللاجئ',
        'education_status' => 'حالة التعليم',
        'training_location' => 'مكان التدريب',
        'training_type' => 'نوع التدريب',
        'social_case_responsible_relation' => 'صلة المسؤول الاجتماعي',
        'permanent_disability_percentage' => 'نسبة العجز الدائم',
        'phone_number' => 'رقم الهاتف',
        'self_dependence_level' => 'درجة الاعتماد على النفس',
        'monthly_income' => 'الدخل الشهري',
        'social_status' => 'الحالة الاجتماعية',
    ],

];

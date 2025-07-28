document.addEventListener('DOMContentLoaded', () => {

    /* ========== عناصر أساسية ========== */
    const form         = document.getElementById('patient-form');
    const errorMessage = document.getElementById('form-error-message');
    const requiredFields = form.querySelectorAll('[data-required="true"]');
    const inputs       = form.querySelectorAll('input, select, textarea');

    /* ========== CSRF‑Token بأمان ========== */
    const csrfMeta  = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
    if (!csrfToken) console.warn('⚠️  CSRF token not found! AJAX requests may be rejected.');

    /* ========== 1. إرسال كل حقل عند blur (AJAX) ========== */
    inputs.forEach(input => {
        input.addEventListener('blur', () => {
            const fieldName = input.name;
            if (!fieldName) return;

            const formData = new FormData();
            formData.append(fieldName, getInputValue(input));

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    ...(csrfToken && { 'X-CSRF-TOKEN': csrfToken })
                },
                body: formData,
            })
                .then(async res => {
                    if (res.ok) {
                        clearFieldError(input);
                    } else if (res.status === 422) {
                        const data = await res.json();
                        (data.errors && data.errors[fieldName])
                            ? showFieldError(input, data.errors[fieldName][0])
                            : clearFieldError(input);
                    } else {
                        clearFieldError(input);
                    }
                })
                .catch(() => clearFieldError(input));
        });
    });

    function getInputValue(input) {
        return (input.type === 'checkbox' || input.type === 'radio')
            ? (input.checked ? 1 : 0)
            : input.value;
    }

    function showFieldError(input, message) {
        clearFieldError(input);
        input.classList.add('is-invalid');
        const span = document.createElement('span');
        span.className = 'text-danger';
        span.textContent = message;
        input.parentNode?.appendChild(span);
    }

    function clearFieldError(input) {
        input.classList.remove('is-invalid');
        input.parentNode?.querySelectorAll('span.text-danger').forEach(s => s.remove());
    }



    /* ========== 3. حدود حمراء عند الخروج ========== */
    requiredFields.forEach(f => {
        f.addEventListener('blur', () => {
            const visible = f.offsetParent !== null;
            const value   = (f.type === 'checkbox') ? f.checked : f.value.trim();
            f.style.border = (visible && !value) ? '1px solid red' : '';
        });
    });

    /* ========== 4. منطق الحقول المرتبطة & flatpickr (كما هو) ========== */
    // ——— هل يتعلم؟
    const educationCheckbox   = document.getElementById('education_status');
    const educationReasonField = document.querySelector('input[name="education_reason"]');
    const educationTypeWrapper = document.getElementById('education_type_wrapper');
    const toggleEducation = () => {
        if (educationCheckbox.checked) {
            educationTypeWrapper.style.display = 'block';
            educationReasonField.closest('.mb-3').style.display = 'none';
            educationReasonField.value = '';
        } else {
            educationTypeWrapper.style.display = 'none';
            educationReasonField.closest('.mb-3').style.display = 'block';
        }
    };
    educationCheckbox.addEventListener('change', toggleEducation);
    toggleEducation();

    // ——— تدريب مهني
    const vocationalCheckbox = document.getElementById('vocational_training');
    const vocationalFields   = document.getElementById('vocational_training_fields');
    const toggleVocational = () => {
        if (vocationalCheckbox.checked) {
            vocationalFields.style.display = 'block';
        } else {
            vocationalFields.style.display = 'none';
            vocationalFields.querySelectorAll('input').forEach(i => i.value = '');
        }
    };
    vocationalCheckbox.addEventListener('change', toggleVocational);
    toggleVocational();

    // ——— حالة العمل
    const employmentStatus   = document.getElementById('employment_status');
    const employmentFields   = document.getElementById('employment_fields_group');
    const toggleEmployment = () => {
        if (employmentStatus.value === 'يعمل') {
            employmentFields.style.display = 'block';
        } else {
            employmentFields.style.display = 'none';
            employmentFields.querySelectorAll('input, select').forEach(el => {
                el.value = '';
                clearFieldError(el);
            });
        }
    };
    employmentStatus.addEventListener('change', toggleEmployment);
    toggleEmployment();

    // ——— الشؤون الاجتماعية
    const socialCheckbox = document.getElementById('social_case_responsible');
    const relationField  = document.getElementById('relation_field');
    const toggleSocial = () => {
        if (socialCheckbox.checked) {
            relationField.style.display = 'block';
        } else {
            relationField.style.display = 'none';
            relationField.querySelector('input').value = '';
        }
    };
    socialCheckbox.addEventListener('change', toggleSocial);
    toggleSocial();

    // ——— اتحاد المعاقين
    const unionCheckbox = document.getElementById('disability_union_responsible');
    const percentageFld = document.getElementById('disability_percentage_field');
    const toggleUnion = () => {
        if (unionCheckbox.checked) {
            percentageFld.style.display = 'block';
            percentageFld.querySelector('input').style.borderColor = 'blue';
        } else {
            percentageFld.style.display = 'none';
            const inp = percentageFld.querySelector('input');
            inp.value = '';
            inp.style.borderColor = '';
        }
    };
    unionCheckbox.addEventListener('change', toggleUnion);
    toggleUnion();

    // ——— لاجئ؟
    const refugeeCheckbox = document.getElementById('refugee_status');
    const unwraField      = document.getElementById('unwra_card_field');
    const unwraLabel      = document.getElementById('unwra_card_label');
    const toggleRefugee = () => {
        const inp = unwraField.querySelector('input');
        if (refugeeCheckbox.checked) {
            unwraField.style.display = 'block';
            unwraLabel.style.color = '#0043ed';
            inp.style.borderColor = 'blue';
        } else {
            unwraField.style.display = 'none';
            unwraLabel.style.color = '';
            inp.value = '';
            inp.style.borderColor = '';
        }
    };
    refugeeCheckbox.addEventListener('change', toggleRefugee);
    toggleRefugee();

    /* ========== flatpickr ========== */
    const birthCalendar = flatpickr('.flatpickr-birth', {
        dateFormat: 'Y-m-d',
        maxDate: 'today',
        locale: 'ar'
    });
    document.getElementById('calendar-birth-icon')?.addEventListener('click', () => birthCalendar.open());

    const injuryCalendar = flatpickr('.flatpickr-injury', {
        dateFormat: 'Y-m-d',
        maxDate: 'today',
        locale: 'ar'
    });
    document.getElementById('calendar-injury-icon')?.addEventListener('click', () => injuryCalendar.open());
});

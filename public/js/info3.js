document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        title: 'تسجيل معلوماتك الأساسية',
        html: `
                <div style="color:black; text-align: right; direction: rtl; font-size: 18px; font-weight: 600;">
                    أنت الآن في مرحلة <span style="color: #007bff ;;">تسجيل معلوماتك الشخصية</span> ضمن نظام الجمعية.<br><br>
                    تساعدنا هذه المعلومات في إنشاء حسابك الخاص، لتمكينك من الدخول لاحقًا إلى صفحتك الرئيسية،
                    والاطلاع على بياناتك، وحجز المواعيد، والاستفادة من كافة الخدمات التي نقدمها لك.
                </div>
            `,
        icon: 'info',
        confirmButtonText: 'فهمت',
        customClass: {
            popup: 'swal2-popup swal2-rtl',
            title: 'swal2-title fs-4',
            confirmButton: 'btn btn-primary'
        },
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    });
});

// ========== 1. التقويم لتاريخ الميلاد ==========
const birthInput = document.querySelector(".flatpickr-birth");
const birthCalendar = flatpickr(birthInput, {
    dateFormat: "Y-m-d",
    maxDate: "today",
    locale: "ar"
});

document.getElementById("calendar-birth-icon").addEventListener("click", () => {
    birthCalendar.open();
});

// ========== 2. دالة التحقق من وجود الأب ==========
function checkFatherExistence(id) {
    if (id.length === 9) {
        fetch(`/check-father/${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.exists) {
                    const familyId = data.family_id;
                    window.location.href = `/mothers/create?family_id=${encodeURIComponent(familyId)}`;
                } else {
                    document.getElementById('father-info').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('حدث خطأ أثناء التحقق من وجود الأب:', error);
            });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'تنبيه',
            text: 'رقم الهوية يجب أن يكون 9 أرقام.',
            confirmButtonText: 'حسنًا',
            customClass: {
                popup: 'rtl',
            }
        });
    }
}

// ========== 3. التحقق من وجود الأب (Enter أو blur) ==========
// ========== 3. التحقق التلقائي من وجود الأب عند كتابة 9 أرقام ==========
const nationalIdInput = document.getElementById('national_id');

nationalIdInput.addEventListener('input', function () {
    const value = this.value.trim();

    // إذا وصل لعدد 9 أرقام، يتم التحقق تلقائيًا
    if (value.length === 9) {
        checkFatherExistence(value);
    }
});


// ========== 4. إظهار/إخفاء حقل الإيجار ==========
$('#house_ownership').change(function () {
    if ($(this).val() === 'إيجار') {
        $('#monthly_rent_group').show();
    } else {
        $('#monthly_rent_group').hide();
        $('#monthly_rent').val('');
    }
}).trigger('change');



$('#has_health_insurance').change(function () {
    if ($(this).is(':checked')) {
        $('#health_insurance_reason_group').hide(); // إخفاء الحقل إذا كانت الإجابة "نعم"
    } else {
        $('#health_insurance_reason_group').show(); // إظهار الحقل إذا كانت الإجابة "لا"
        $('#health_insurance_reason').val(''); // تفريغ الحقل عند الإظهار (اختياري)
    }
}).trigger('change'); // تنفيذ التغيير فورًا عند تحميل الصفحة



// ========== 6. إرسال كل حقل عند الخروج منه (Ajax لكل حقل) ==========
const form = document.getElementById('patient-form');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const inputs = form.querySelectorAll('input, select, textarea');

inputs.forEach(input => {
    input.addEventListener('blur', () => {
        const fieldName = input.name;
        if (!fieldName) return;

        const formData = new FormData();
        formData.append(fieldName, getInputValue(input));

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
        })
            .then(async response => {
                if (response.ok) {
                    clearFieldError(input);
                } else if (response.status === 422) {
                    const data = await response.json();
                    if (data.errors && data.errors[fieldName]) {
                        showFieldError(input, data.errors[fieldName][0]);
                    } else {
                        clearFieldError(input);
                    }
                } else {
                    clearFieldError(input);
                }
            })
            .catch(() => {
                clearFieldError(input);
            });
    });
});

function getInputValue(input) {
    if (input.type === 'checkbox') {
        return input.checked ? input.value : '';
    }
    if (input.type === 'radio') {
        return input.checked ? input.value : '';
    }
    return input.value;
}

function showFieldError(input, message) {
    clearFieldError(input);
    input.classList.add('is-invalid');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback d-block';
    errorDiv.textContent = message;
    if (input.parentNode) {
        input.parentNode.appendChild(errorDiv);
    }
}

function clearFieldError(input) {
    input.classList.remove('is-invalid');
    const parent = input.parentNode;
    if (!parent) return;
    const errorDivs = parent.querySelectorAll('.invalid-feedback.d-block');
    errorDivs.forEach(div => div.remove());
}

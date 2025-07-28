document.addEventListener("DOMContentLoaded", function () {
    // ==== المتغيرات الرئيسية ====
    const form = document.getElementById("mother-form");
    const motherInfo = document.getElementById("mother-info");
    const nationalIdInput = document.getElementById("national_id");

    // ==== دوال التحقق حسب نوع الحقل ====
    function validateField(input) {
        const name = input.name;
        const value = input.value.trim();

        if (input.offsetParent === null) return;

        if (['name'].includes(name)) {
            const arabicRegex = /^[\u0600-\u06FF\s]+$/;
            if (!value) return showError(input, "الاسم مطلوب");
            if (!arabicRegex.test(value)) return showError(input, "الاسم يجب أن يحتوي على أحرف عربية فقط");
            if (value.length > 100) return showError(input, "الاسم طويل جدًا");
        }

        if (name === 'birth_date') {
            if (!value) return showError(input, "تاريخ الميلاد مطلوب");
            const today = new Date().toISOString().split('T')[0];
            if (value >= today) return showError(input, "تاريخ الميلاد يجب أن يكون قبل اليوم");
        }

        if (name === 'health_status') {
            if (!value) return showError(input, "الحالة الصحية مطلوبة");
            if (value.length > 100) return showError(input, "الحالة الصحية طويلة جدًا");
        }

        if (name === 'academic_level') {
            const levels = ['ابتدائي','إعدادي','ثانوي','دبلوم','بكالوريا','جامعي','دراسات عليا'];
            if (!value || !levels.includes(value)) return showError(input, "يرجى اختيار المستوى الأكاديمي الصحيح");
        }

        if (name === 'marriages_count') {
            if (value && (isNaN(value) || parseInt(value) < 1)) return showError(input, "عدد مرات الزواج يجب أن يكون رقمًا أكبر من أو يساوي 1");
        }

        if (name === 'relationship_with_father') {
            if (!value) return showError(input, "العلاقة مع الأب مطلوبة");
            if (!arabicRegex.test(value)) return showError(input, "العلاقة مع الأب يجب أن تحتوي على أحرف عربية ومسافات فقط");
            if (value.length > 50) return showError(input, "العلاقة مع الأب طويلة جدًا");
        }

        if (name === 'profession') {
            if (value && !arabicRegex.test(value)) return showError(input, "المهنة يجب أن تحتوي على أحرف عربية ومسافات فقط");
            if (value.length > 100) return showError(input, "المهنة طويلة جدًا");
        }

        if (name === 'national_id') {
            if (!/^\d{9}$/.test(value)) return showError(input, "رقم الهوية يجب أن يتكون من 9 أرقام");
        }

        removeError(input);
    }

    function enableDynamicValidation(container) {
        container.querySelectorAll("input:not([type=checkbox]), select, textarea").forEach(input => {
            input.addEventListener("blur", () => validateField(input));
            input.addEventListener("input", () => validateField(input));
        });
    }


    // ========== 1. التقويم لتاريخ الميلاد ==========
    const birthInput = document.querySelector(".flatpickr-birth");
    const birthCalendar = flatpickr(birthInput, {
        dateFormat: "Y-m-d",
        maxDate: "today",
        locale: "ar"
    });

    // ==== حدث الإدخال على حقل رقم الهوية ====
    nationalIdInput.addEventListener("input", function () {
        if (this.value.length === 9) {
            motherInfo.style.display = "block";
        } else {
            motherInfo.style.display = "none";
        }
    });

    // ==== حدث الضغط على Enter داخل حقل رقم الهوية ====
    nationalIdInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const nationalId = this.value.trim();

            // تحقق من طول رقم الهوية
            if (nationalId.length !== 9) {
                Swal.fire({
                    icon: "warning",
                    title: "رقم الهوية غير صحيح",
                    text: "يجب أن يكون رقم الهوية 9 أرقام.",
                });
                return;
            }



        }
    });

    document.getElementById('national_id').addEventListener('blur', function () {
        const id = this.value;
        if (id.length === 9) {
            fetch(`/check-mother/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        // ا
                        const motherId = data.mother_id;
                        window.location.href = `/patients/create?mother_id=${encodeURIComponent(motherId)}`;
                    } else {
                        //
                        document.getElementById('mother-info').style.display = 'block';

// ✅ تفعيل التحقق التلقائي على كل الحقول عند إظهار معلومات الأم
                        enableDynamicValidation(document.getElementById('mother-info'));

                    }
                })
                .catch(error => {
                    console.error('حدث خطأ أثناء التحقق:', error);
                });
        } else {
            alert("رقم الهوية يجب أن يكون 9 أرقام.");
        }
    });
    // ==== دوال مساعدة لإظهار وإزالة رسائل الخطأ ====
    function showError(input, message) {
        removeError(input);
        input.classList.add("is-invalid");

        const errorDiv = document.createElement("div");
        errorDiv.classList.add("invalid-feedback", "d-block");
        errorDiv.textContent = message;

        input.parentNode.appendChild(errorDiv);
    }

    function removeError(input) {
        input.classList.remove("is-invalid");
        const errorDiv = input.parentNode.querySelector(".invalid-feedback");
        if (errorDiv) errorDiv.remove();
    }

    // ==== تحقق من الحقول المطلوبة عند الخروج منها (blur) ====
    form.querySelectorAll("[required]").forEach(input => {
        input.addEventListener("blur", () => {
            if (!input.value.trim()) {
                showError(input, "هذا الحقل مطلوب");
            } else {
                removeError(input);
            }
        });

        // إزالة رسالة الخطأ فور كتابة المستخدم (input)
        input.addEventListener("input", () => {
            if (input.value.trim()) {
                removeError(input);
            }
        });
    });
});

var op = "";
var disability_type_id = 0;

// إعداد CSRF Token
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

// حذف نوع الإعاقة باستخدام SweetAlert
$(document).on('click', '.delete', function () {
    const id = $(this).attr('disabilitytype_id');
    if (!id) {
        Swal.fire({
            icon: "error",
            title: "خطأ",
            text: "المعرف غير موجود"
        });
        return;
    }

    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "سيتم حذف نوع الإعاقة بشكل نهائي!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "نعم، احذف",
        cancelButtonText: "إلغاء"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/disability types/delete/' + id,
                type: "GET",
                success: function () {
                    Swal.fire({
                        icon: "success",
                        title: "تم الحذف",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#disability_type_no_" + id).addClass("fade-out");
                    setTimeout(() => {
                        $("#disability_type_no_" + id).remove();
                    }, 500);
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "خطأ أثناء الحذف",
                        text: xhr.responseText
                    });
                }
            });
        }
    });
});

// فتح مودال الإضافة
$(document).on('click', '#add', function () {
    op = "ADD";
    disability_type_id = 0;
    $("#btn").val("حفظ");
    $("#name").val("");
    $("#exampleModalLabel").text("إضافة نوع إعاقة");
    $("#exampleModal").modal("show");
});

// فتح مودال التعديل
$(document).on('click', '.edit', function () {
    op = "EDIT";
    disability_type_id = $(this).attr('disabilitytype_id');
    $("#btn").val("تعديل");

    let name = $("#disability_type_name_" + disability_type_id).text().trim();

    $("#name").val(name);
    $("#exampleModalLabel").text("تعديل نوع الإعاقة");
    $("#exampleModal").modal("show");
});

// تنفيذ الإضافة أو التعديل
$("#myform").on('submit', function (e) {
    e.preventDefault();
    $("#exampleModal").modal("hide");

    let name = $("#name").val().trim();

    if (name === "") {
        Swal.fire({
            icon: "warning",
            title: "يرجى ملء جميع الحقول"
        });
        return;
    }

    let url = (op === "ADD")
        ? "/disability types/add"
        : "/disability types/edit/" + disability_type_id;

    $.ajax({
        url: url,
        type: "POST",
        data: {
            name: name
        },
        success: function (disability_type) {
            Swal.fire({
                icon: "success",
                title: (op === "ADD") ? "تمت الإضافة بنجاح" : "تم التعديل بنجاح",
                showConfirmButton: false,
                timer: 1500
            });

            if (op === "ADD") {
                $("#mydisabilitytypelist").append(newDisabilityType(disability_type));
            } else {
                $("#disability_type_name_" + disability_type.id).text(disability_type.name);
            }
        },
        error: function (xhr) {
            Swal.fire({
                icon: "error",
                title: "خطأ أثناء الحفظ",
                text: xhr.responseText
            });
        }
    });
});

// توليد صف جديد
function newDisabilityType(disability_type) {
    return `
        <tr id="disability_type_no_${disability_type.id}">
            <td>${disability_type.id}</td>
            <td id="disability_type_name_${disability_type.id}">${disability_type.name}</td>
            <td><span class="btn btn-success btn-sm edit" disabilitytype_id="${disability_type.id}">تعديل</span></td>
            <td><span class="btn btn-danger btn-sm delete" disabilitytype_id="${disability_type.id}">حذف</span></td>
        </tr>
    `;
}

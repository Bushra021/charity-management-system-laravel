var op = "";
var area_id = 0;

// إعداد CSRF Token لكل طلبات AJAX
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

// حذف المنطقة
$(document).on('click', '.delete', function () {
    const id = $(this).attr('area_id');

    if (!id) {
        Swal.fire("خطأ", "لا يمكن العثور على المعرف!", "error");
        return;
    }

    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لا يمكن التراجع بعد الحذف!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، احذفها!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/areas/delete/' + id,
                type: "GET",
                success: function (response) {
                    $("#area_no_" + id).remove();
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحذف',
                        text: response,
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function (xhr) {
                    Swal.fire("خطأ", "حدث خطأ أثناء الحذف:\n" + xhr.responseText, "error");
                }
            });
        }
    });
});

// فتح نافذة الإضافة
$(document).on('click', '#add', function () {
    op = "ADD";
    area_id = 0;
    $("#btn").val("حفظ");
    $("#name").val("");
    $("#type").val("");
    $("#exampleModalLabel").text("إضافة منطقة جديدة");
    $("#exampleModal").modal("show");
});

// فتح نافذة التعديل
$(document).on('click', '.edit', function () {
    op = "EDIT";
    $("#btn").val("تعديل");
    area_id = $(this).attr('area_id');

    if (!area_id) {
        Swal.fire("خطأ", "لا يمكن العثور على المعرف!", "error");
        return;
    }

    let name = $("#area_name_" + area_id).html();
    let type = $("#area_type_" + area_id).html();
    $("#exampleModalLabel").text("تعديل المنطقة الحالية");
    $("#exampleModal").modal("show");
    $("#name").val(name);
    $("#type").val(type);
});

// حفظ الإضافة أو التعديل
$("#myform").on('submit', function (e) {
    e.preventDefault();
    $("#exampleModal").modal("hide");

    let name = $("#name").val().trim();
    let type = $("#type").val().trim();

    if (name === "" || type === "") {
        Swal.fire("تنبيه", "يرجى ملء جميع الحقول!", "warning");
        return;
    }

    if (op === "ADD") {
        $.ajax({
            url: "/areas/add",
            type: "POST",
            data: { name: name, type: type },
            success: function (area) {
                if (area && area.id) {
                    $("#myarealist").append(newarea(area));
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحفظ',
                        text: 'تمت إضافة المنطقة بنجاح.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire("خطأ", "فشل في إضافة المنطقة!", "error");
                }
            },
            error: function (xhr) {
                Swal.fire("خطأ", "حدث خطأ أثناء الإضافة:\n" + xhr.responseText, "error");
            }
        });

    } else if (op === "EDIT") {
        $.ajax({
            url: "/areas/edit/" + area_id,
            type: "POST",
            data: { name: name, type: type },
            success: function (response) {
                if (response && response.name && response.type) {
                    $("#area_name_" + area_id).html(response.name);
                    $("#area_type_" + area_id).html(response.type);
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث',
                        text: 'تم تعديل بيانات المنطقة بنجاح.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire("خطأ", "فشل في تحديث البيانات!", "error");
                }
            },
            error: function (xhr) {
                Swal.fire("خطأ", "حدث خطأ أثناء التعديل:\n" + xhr.responseText, "error");
            }
        });
    }
});

// دالة إنشاء عنصر جديد في الجدول
function newarea(area) {
    return '<tr id="area_no_' + area.id + '">\n' +
        '    <th scope="row">' + area.id + '</th>\n' +
        '    <td id="area_name_' + area.id + '">' + area.name + '</td>\n' +
        '    <td id="area_type_' + area.id + '">' + area.type + '</td>\n' +
        '    <td>\n' +
        '        <span class="btn btn-success btn-sm edit" area_id="' + area.id + '">تعديل </span>\n' +
        '    </td>\n' +
        '    <td>\n' +
        '        <span class="btn btn-danger btn-sm delete" area_id="' + area.id + '">حذف </span>\n' +
        '    </td>\n' +
        '</tr>';
}

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
        alert("خطأ: لا يمكن العثور على المعرف!");
        return;
    }

    if (confirm("هل أنت متأكد من حذف هذه المنطقة؟")) {
        $.ajax({
            url: '/notes/delete/' + id,
            type: "GET",
            success: function (response) {
                alert(response);
                $("#area_no_" + id).remove();
            },
            error: function (xhr) {
                alert("حدث خطأ أثناء الحذف: " + xhr.responseText);
            }
        });
    }
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
        alert("خطأ: لا يمكن العثور على المعرف!");
        return;
    }

    let name = $("#area_name_" + area_id).html();
    let date = $("#area_type_" + area_id).html();
    $("#exampleModalLabel").text("تعديل المنطقة الحالية");
    $("#exampleModal").modal("show");
    $("#name").val(name);
    $("#type").val(date);
});

// حفظ الإضافة أو التعديل
$("#myform").on('submit', function (e) {
    e.preventDefault();
    $("#exampleModal").modal("hide");

    let name = $("#name").val().trim();
    let type = $("#type").val().trim();

    if (name === "" || type === "") {
        alert("يرجى ملء جميع الحقول!");
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
                } else {
                    alert("خطأ في إضافة المنطقة!");
                }
            },
            error: function (xhr) {
                alert("حدث خطأ أثناء الإضافة: " + xhr.responseText);
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
                } else {
                    alert("خطأ في تحديث البيانات!");
                }
            },
            error: function (xhr) {
                alert("حدث خطأ أثناء التعديل: " + xhr.responseText);
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

function deleteRow(button) {/*خاص بحذف صف من الجدول*/
    const row = button.closest('tr'); // بجيب الصف اللي يحتوي الزر
    row.classList.add('fade-out'); // بضيف كلاس الأنيميشن

    setTimeout(() => {
        row.remove(); // بحذف الصف فعليًا بعد انتهاء الأنيميشن
    }, 500); // لازم يكون نفس وقت الأنيميشن بالـ CSS
}

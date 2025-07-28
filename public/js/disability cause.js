var op = "";
var disability_cause_id = 0;

// إعداد CSRF Token
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

// حذف سبب إعاقة
$(document).on('click', '.delete', function () {
    const id = $(this).attr('disabilitycause_id');
    if (!id) return alert("المعرف غير موجود");

    if (confirm("هل أنت متأكد من حذف سبب الإعاقة؟")) {
        $.ajax({
            url: '/disability causes/delete/' + id,
            type: "GET",
            success: function () {
                alert("تم الحذف");
                $("#disability_cause_no_" + id).addClass("fade-out");
                setTimeout(() => {
                    $("#disability_cause_no_" + id).remove();
                }, 500);
            },
            error: function (xhr) {
                alert("خطأ أثناء الحذف: " + xhr.responseText);
            }
        });
    }
});

// فتح مودال الإضافة
$(document).on('click', '#add', function () {
    op = "ADD";
    disability_cause_id = 0;
    $("#btn").val("حفظ");
    $("#name").val("");
    $("#exampleModalLabel").text("إضافة سبب إعاقة");
    $("#exampleModal").modal("show");
});

// فتح مودال التعديل
$(document).on('click', '.edit', function () {
    op = "EDIT";
    disability_cause_id = $(this).attr('disabilitycause_id');
    $("#btn").val("تعديل");

    let name = $("#disability_cause_name_" + disability_cause_id).text().trim();

    $("#name").val(name);
    $("#exampleModalLabel").text("تعديل سبب الإعاقة");
    $("#exampleModal").modal("show");
});

// تنفيذ الإضافة أو التعديل
$("#myform").on('submit', function (e) {
    e.preventDefault();
    $("#exampleModal").modal("hide");

    let name = $("#name").val().trim();

    if (name === "") {
        alert("يرجى ملء جميع الحقول");
        return;
    }

    let url = (op === "ADD")
        ? "/disability causes/add"
        : "/disability causes/edit/" + disability_cause_id;

    $.ajax({
        url: url,
        type: "POST",
        data: {
            name: name
        },
        success: function (disability_cause) {
            if (op === "ADD") {
                $("#mydisabilitycauselist").append(newDisabilityCause(disability_cause));
            } else {
                $("#disability_cause_name_" + disability_cause.id).text(disability_cause.name);
            }
        },
        error: function (xhr) {
            alert("خطأ أثناء الحفظ: " + xhr.responseText);
        }
    });
});

// توليد صف سبب إعاقة جديد
function newDisabilityCause(disability_cause) {
    return `
        <tr id="disability_cause_no_${disability_cause.id}">
            <th scope="row">${disability_cause.id}</th>
            <td id="disability_cause_name_${disability_cause.id}">${disability_cause.name}</td>
            <td><span class="btn btn-success btn-sm edit" disabilitycause_id="${disability_cause.id}">تعديل</span></td>
            <td><span class="btn btn-danger btn-sm delete" disabilitycause_id="${disability_cause.id}">حذف</span></td>
        </tr>
    `;
}

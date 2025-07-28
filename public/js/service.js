// service.js

let op = "";
let service_id = 0;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

// حذف خدمة
$(document).on("click", ".delete", function () {
    const id = $(this).data("service-id");
    if (!id) return;

    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "لن تتمكن من التراجع بعد الحذف!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "نعم، احذفها!",
        cancelButtonText: "إلغاء"
    }).then((result) => {
        if (result.isConfirmed) {
            $.get("/services/delete/" + id, function () {
                $("#service_no_" + id).remove();
                Swal.fire("تم الحذف", "تم حذف الخدمة بنجاح", "success");
            }).fail(function (xhr) {
                Swal.fire("خطأ", xhr.responseText, "error");
            });
        }
    });
});

// فتح المودال للإضافة
$("#add").on("click", function () {
    op = "ADD";
    service_id = 0;
    $("#btn").val("حفظ");
    $("#name").val("");
    $("#user_id").val("");
    $("#exampleModalLabel").text("إضافة خدمة");
    $("#exampleModal").modal("show");
});

// فتح المودال للتعديل
$(document).on("click", ".edit", function () {
    op = "EDIT";
    service_id = $(this).data("service-id");
    $("#btn").val("تعديل");

    const name = $(`#service_name_${service_id}`).text().trim();
    const user_id = $(`#service_user_id_${service_id}`).data("userid");

    $("#name").val(name);
    $("#user_id").val(user_id);
    $("#exampleModalLabel").text("تعديل الخدمة");
    $("#exampleModal").modal("show");
});

// تنفيذ إضافة أو تعديل
$("#myform").on("submit", function (e) {
    e.preventDefault();
    const name = $("#name").val().trim();
    const user_id = $("#user_id").val();
    if (!name || !user_id) {
        Swal.fire("تنبيه", "يرجى ملء جميع الحقول", "warning");
        return;
    }

    const url = op === "ADD" ? "/services/add" : "/services/edit/" + service_id;
    $.post(url, { name, user_id }, function (service) {
        service.user_name = $(`#user_id option[value='${user_id}']`).text();

        if (op === "ADD") {
            $("#myservicelist").append(newService(service));
            Swal.fire("تمت الإضافة", "تمت إضافة الخدمة بنجاح", "success");
        } else {
            $(`#service_name_${service.id}`).text(service.name);
            $(`#service_user_id_${service.id}`).text(service.user_name).data("userid", service.user_id);
            Swal.fire("تم التعديل", "تم تعديل الخدمة بنجاح", "success");
        }
        $("#exampleModal").modal("hide");
    }).fail(function (xhr) {
        Swal.fire("خطأ", xhr.responseText, "error");
    });
});

// زر التفعيل / إلغاء التفعيل
$(document).on("click", ".toggle-active", function () {
    const btn = $(this);
    const id = btn.data("id");
    $.post("/services/toggle-active/" + id, {}, function (data) {
        if (data.active) {
            btn.removeClass("btn-secondary").addClass("btn-success").text("مفعّلة");
        } else {
            btn.removeClass("btn-success").addClass("btn-secondary").text("غير مفعّلة");
        }
    });
});

// توليد صف جديد
function newService(service) {
    return `
        <tr id="service_no_${service.id}">
            <td>${service.id}</td>
            <td id="service_name_${service.id}">${service.name}</td>
            <td id="service_user_id_${service.id}" data-userid="${service.user_id}">${service.user_name}</td>
            <td>
                <button class="btn btn-sm toggle-active btn-success" data-id="${service.id}">مفعّلة</button>
            </td>
            <td>
                <span class="btn btn-success btn-sm edit" data-service-id="${service.id}">تعديل</span>
            </td>
            <td>
                <span class="btn btn-danger btn-sm delete" data-service-id="${service.id}">حذف</span>
            </td>
        </tr>
    `;
}

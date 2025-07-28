var op = "";
var tool_id = 0;

// إعداد CSRF Token لكل طلبات AJAX
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

// حذف الأداة
$(document).on('click', '.delete', function () {
    const id = $(this).attr('tool_id');

    if (!id) {
        Swal.fire("خطأ", "المعرف غير موجود!", "error");
        return;
    }

    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لن تتمكن من التراجع بعد الحذف!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، احذفها!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/tools/delete/' + id,
                type: "GET",
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحذف',
                        text: response,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $("#tool_no_" + id).addClass("fade-out");
                    setTimeout(() => {
                        $("#tool_no_" + id).remove();
                    }, 500);
                },
                error: function (xhr) {
                    Swal.fire("خطأ أثناء الحذف", xhr.responseText, "error");
                }
            });
        }
    });
});

// فتح نافذة الإضافة
$(document).on('click', '#add', function () {
    op = "ADD";
    tool_id = 0;
    $("#btn").val("حفظ");
    $("#name").val("");
    $("#price").val("");
    $("#exampleModalLabel").text("إضافة أداة جديدة");
    $("#exampleModal").modal("show");
});

// فتح نافذة التعديل
$(document).on('click', '.edit', function () {
    op = "EDIT";
    tool_id = $(this).attr('tool_id');

    if (!tool_id) {
        Swal.fire("خطأ", "المعرف غير موجود!", "error");
        return;
    }

    let name = $("#tool_name_" + tool_id).html();
    let price = $("#tool_price_" + tool_id).html();
    $("#exampleModalLabel").text("تعديل الأداة الحالية");
    $("#exampleModal").modal("show");
    $("#name").val(name);
    $("#price").val(price);
});

// حفظ التعديل والاضافة

$("#myform").on('submit', function (e) {
    e.preventDefault();
    $("#exampleModal").modal("hide");

    let name = $("#name").val().trim();
    let price = parseFloat($("#price").val().trim());

    if (name === "" || isNaN(price)) {
        Swal.fire("تنبيه", "يرجى إدخال اسم وسعر صحيح!", "warning");
        return;
    }

    if (price < 0) {
        Swal.fire("خطأ", "لا يمكن أن يكون السعر سالبًا!", "error");
        return;
    }

    let url = (op === "ADD") ? "/tools/add" : "/tools/edit/" + tool_id;

    $.ajax({
        url: url,
        type: "POST",
        data: { name: name, price: price },
        success: function (response) {
            if (response && response.id) {
                if (op === "ADD") {
                    $("#mytoollist").append(newtool(response));
                    Swal.fire({
                        icon: 'success',
                        title: 'تمت الإضافة',
                        text: 'تمت إضافة الأداة بنجاح',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    $("#tool_name_" + response.id).html(response.name);
                    $("#tool_price_" + response.id).html(response.price);
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التعديل',
                        text: 'تم تعديل الأداة بنجاح',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            } else {
                Swal.fire("خطأ", "حدث خطأ أثناء حفظ البيانات", "error");
            }
        },
        error: function (xhr) {
            Swal.fire("خطأ أثناء الحفظ", xhr.responseText, "error");
        }
    });
});


// دالة إنشاء عنصر جديد في الجدول
function newtool(tool) {
    return `
        <tr id="tool_no_${tool.id}">
            <th scope="row">${tool.id}</th>
            <td id="tool_name_${tool.id}">${tool.name}</td>
            <td id="tool_price_${tool.id}">${tool.price}</td>
            <td>
                <span class="btn btn-success btn-sm edit" tool_id="${tool.id}">تعديل</span>
            </td>
            <td>
                <span class="btn btn-danger btn-sm delete" tool_id="${tool.id}">حذف</span>
            </td>
        </tr>
    `;
}

// دالة لحذف صف مع أنيميشن
function deleteRow(button) {
    const row = button.closest('tr');
    row.classList.add('fade-out');

    setTimeout(() => {
        row.remove();
    }, 500);
}

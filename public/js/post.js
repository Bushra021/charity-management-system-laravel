// var op = "";
// var post_id = 0;
//
// // إعداد CSRF Token لكل طلبات AJAX
// $.ajaxSetup({
//     headers: {
//         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//     }
// });
//
// // حذف منشور
// $(document).on('click', '.delete', function () {
//     const id = $(this).attr('post_id');
//     if (!id) {
//         Swal.fire("خطأ", "المعرف غير موجود!", "error");
//         return;
//     }
//
//     Swal.fire({
//         title: 'هل أنت متأكد؟',
//         text: "لن تتمكن من التراجع بعد الحذف!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'نعم، احذف المنشور!',
//         cancelButtonText: 'إلغاء'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             $.ajax({
//                 url: '/posts/delete/' + id,
//                 type: "GET",
//                 success: function (res) {
//                     Swal.fire({
//                         icon: 'success',
//                         title: 'تم الحذف',
//                         text: res,
//                         timer: 1500,
//                         showConfirmButton: false
//                     });
//                     $("#post_no_" + id).remove();
//                 },
//                 error: function (xhr) {
//                     Swal.fire("خطأ أثناء الحذف", xhr.responseText, "error");
//                 }
//             });
//         }
//     });
// });
//
// // فتح مودال الإضافة
// $(document).on('click', '#add', function () {
//     op = "ADD";
//     post_id = 0;
//     $("#btn").val("حفظ");
//     $("#name").val("");
//     $("#exampleModalLabel").text("إضافة منشور");
//     $("#exampleModal").modal("show");
// });
//
// // فتح مودال التعديل
// $(document).on('click', '.edit', function () {
//     op = "EDIT";
//     post_id = $(this).attr('post_id');
//     $("#btn").val("تعديل");
//
//     const content = $("#post_content_" + post_id).text().trim();
//     $("#name").val(content);
//     $("#exampleModalLabel").text("تعديل المنشور");
//     $("#exampleModal").modal("show");
// });
//
// // إرسال الفورم (إضافة أو تعديل)
// $("#myform").on('submit', function (e) {
//     e.preventDefault();
//     $("#exampleModal").modal("hide");
//
//     const formData = new FormData(this);
//     const url = (op === "ADD") ? "/posts/add" : "/posts/edit/" + post_id;
//
//     $.ajax({
//         url: url,
//         type: "POST",
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//             if (op === "ADD") {
//                 $("#myPostList").append(newPost(response));
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'تمت الإضافة',
//                     text: 'تمت إضافة المنشور بنجاح',
//                     timer: 1500,
//                     showConfirmButton: false
//                 });
//             } else {
//                 $("#post_content_" + response.id).text(response.post);
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'تم التعديل',
//                     text: 'تم تعديل المنشور بنجاح',
//                     timer: 1500,
//                     showConfirmButton: false
//                 });
//             }
//         },
//         error: function(xhr) {
//             Swal.fire("خطأ أثناء إضافة المنشور", xhr.responseText, "error");
//         }
//     });
// });
//
// // دالة توليد صف منشور جديد
// function newPost(post) {
//     return `
//     <tr id="post_no_${post.id}">
//         <th scope="row">${post.id}</th>
//         <td id="post_content_${post.id}">${post.post}</td>
//         <td><img src="${post.photo}" height="100"/></td>
//         <td><span class="btn btn-success btn-sm edit" post_id="${post.id}">تعديل</span></td>
//         <td><span class="btn btn-danger btn-sm delete" post_id="${post.id}">حذف</span></td>
//     </tr>`;
// }

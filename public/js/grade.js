$(document).ready(function () {
    // فتح المودال عند الضغط على زر الإضافة
    $('#add').on('click', function () {
        $('#name').val('');
        $('#exampleModalLabel').text('إضافة درجة');
        $('#btn').text('حفظ');
        $('#btn').attr('data-action', 'add').removeAttr('data-id');
        $('#exampleModal').modal('show');
    });

    // إضافة أو تعديل الدرجة
    $('#myform').on('submit', function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let action = $('#btn').attr('data-action');
        let id = $('#btn').attr('data-id');
        let url = action === 'add' ? '/grades/add' : '/grades/edit/' + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: { name: name },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (action === 'add') {
                    $('#mygradelist').append(`
                        <tr id="grade_no_${data.id}">
                            <th scope="row">${data.id}</th>
                            <td id="grade_name_${data.id}">${data.name}</td>
                            <td><span class="btn btn-success btn-sm edit" data-grade-id="${data.id}">تعديل</span></td>
                            <td><span class="btn btn-danger btn-sm delete" data-grade-id="${data.id}">حذف</span></td>
                        </tr>
                    `);
                } else {
                    $(`#grade_name_${data.id}`).text(data.name);
                }

                $('#exampleModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'تم الحفظ',
                    text: action === 'add' ? 'تمت إضافة الدرجة بنجاح.' : 'تم تعديل الدرجة بنجاح.',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء حفظ البيانات. تأكد من صحة الحقول.',
                });
            }
        });
    });

    // تعديل الدرجة
    $(document).on('click', '.edit', function () {
        let id = $(this).data('grade-id');
        let name = $(`#grade_name_${id}`).text();

        $('#name').val(name);
        $('#exampleModalLabel').text('تعديل درجة الإعاقة');
        $('#btn').text('تحديث');
        $('#btn').attr('data-action', 'edit').attr('data-id', id);
        $('#exampleModal').modal('show');
    });

    // حذف الدرجة
    $(document).on('click', '.delete', function () {
        let id = $(this).data('grade-id');

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
                    url: '/grades/delete/' + id,
                    type: 'GET',
                    success: function () {
                        $(`#grade_no_${id}`).remove();

                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحذف',
                            text: 'تم حذف الدرجة بنجاح.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'حدث خطأ أثناء الحذف. حاول مرة أخرى.',
                        });
                    }
                });
            }
        });
    });
});

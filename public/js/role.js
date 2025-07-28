<!-- سكربت البحث والتحديث -->

// البحث باستخدام AJAX
document.getElementById('search').addEventListener('keyup', function() {
    let query = this.value;
    fetch(`/admin/users/search?query=${query}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('userTable').innerHTML = data;
        });
});

// تحديث الدور باستخدام AJAX
document.querySelectorAll('.role-select').forEach(select => {
    select.addEventListener('change', function() {
        let userId = this.closest('tr').querySelector('.user-id').innerText;
        let newRole = this.value;

        fetch(`/admin/users/updateRole`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                userId: userId,
                newRole: newRole
            })
        })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'تم تحديث الدور',
                    text: data.message || 'تم التحديث بنجاح',
                    timer: 1500,
                    showConfirmButton: false
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'حدث خطأ',
                    text: error.message || 'لم يتم تحديث الدور',
                });
            });
    });
});

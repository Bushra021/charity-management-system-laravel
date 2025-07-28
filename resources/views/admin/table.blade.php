@foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->username }}</td>
        @php
            $rolesMap = [
                'admin' => 'مدير',
                'employee' => 'موظف',
                'employee_services' => 'موظف خدمات',
                'patient' => 'مراجع',
            ];
        @endphp
        <td>{{ $rolesMap[$user->role] ?? 'غير معروف' }}</td>

        <td>
            <form method="POST" action="{{ route('admin.update', $user->id) }}" style="display: inline-flex; gap: 6px;">
                @csrf
                @method('PUT')
                <select name="role" class="role-select">
                    <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>موظف</option>
                    <option value="employee_services" {{ $user->role == 'employee_services' ? 'selected' : '' }}>موظف خدمات</option>
                    <option value="patient" {{ $user->role == 'patient' ? 'selected' : '' }}>مراجع</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير</option>


                </select>
                <button type="submit" class="btn-update">تحديث</button>
            </form>
        </td>
        <td>
            @if ($user->is_active)
                <span class="text-success">مفعل</span>
            @else
                <span class="text-danger">غير مفعل</span>
            @endif
        </td>
        <td>
            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                    {{ $user->is_active ? 'إيقاف الحساب' : 'تفعيل الحساب' }}
                </button>
            </form>
        </td>
    </tr>
@endforeach

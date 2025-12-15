<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👥 User Management</h2>
        <div>
            <a href="{{ route('visitors.index') }}" class="btn btn-secondary">Back to Dashboard</a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Create User</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->StaffID }}</td>
                        <td>{{ $user->Name }}</td>
                        <td>{{ $user->Username }}</td>
                        <td>
                            @if($user->RoleID == 1) <span class="badge bg-info">Reception</span>
                            @elseif($user->RoleID == 2) <span class="badge bg-secondary">Security</span>
                            @elseif($user->RoleID == 3) <span class="badge bg-danger">Admin</span>
                            @endif
                        </td>
                        <td>{{ $user->DepartmentName }}</td>
                        <td>
                            <form action="{{ route('admin.users.delete', $user->StaffID) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
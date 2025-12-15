<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Create New Staff Account</h4>
        </div>
        <div class="card-body">
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="Name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="Username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="Password" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Role</label>
                        <select name="RoleID" class="form-select" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->RoleID }}">{{ $role->RoleName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Department</label>
                        <select name="DeptID" class="form-select" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->DepartmentID }}">{{ $dept->DepartmentName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">Create Account</button>
                <a href="{{ route('admin.users') }}" class="btn btn-link w-100 mt-2">Cancel</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>
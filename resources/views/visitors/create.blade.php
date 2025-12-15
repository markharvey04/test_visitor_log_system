<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Registration</title>
    <!-- 1. LINK TO BOOTSTRAP CSS (This "downloads" it for you automatically) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>🏢 Visitor Log System</h2>
                <a href="{{ route('visitors.index') }}" class="btn btn-secondary">
                    View Dashboard &rarr;
                </a>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Error Alert -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">New Visitor Registration</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('visitors.store') }}" method="POST">
                        @csrf 

                        <h5 class="text-secondary mb-3">👤 Visitor Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="Name" class="form-control" required placeholder="Ex: Juan Dela Cruz">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="ContactNumber" class="form-control" required placeholder="Ex: 09123456789">
                            </div>
                        </div>

                        <hr>

                        <h5 class="text-secondary mb-3">📍 Visit Details</h5>
                        <div class="mb-3">
                            <label class="form-label">Purpose of Visit</label>
                            <input type="text" name="Purpose" class="form-control" required placeholder="Ex: Submit Documents">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <select name="DeptID" class="form-select" required>
                                    <option value="">-- Select Department --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->DepartmentID }}">{{ $dept->DepartmentName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Person to Visit</label>
                                <select name="StaffID" class="form-select" required>
                                    <option value="">-- Select Staff --</option>
                                    @foreach($staffMembers as $staff)
                                        <option value="{{ $staff->StaffID }}">{{ $staff->Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Register Visitor</button>
                        </div>

                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3 text-muted">
                <small>San Francisco Municipal Hall Visitor System &copy; 2025</small>
            </div>

        </div>
    </div>
</div>

<!-- 2. LINK TO BOOTSTRAP JS (For the little "x" buttons on alerts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
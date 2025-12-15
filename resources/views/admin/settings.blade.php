<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 800px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>⚙️ System Settings</h2>
        <a href="{{ route('visitors.index') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">General Configuration</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <!-- System Name -->
                <div class="mb-3">
                    <label class="form-label fw-bold">System Name</label>
                    <!-- We use $settings->system_name here -->
                    <input type="text" name="system_name" class="form-control" value="{{ $settings->system_name }}" required>
                    <small class="text-muted">This name will appear on the dashboard.</small>
                </div>

                <!-- Maintenance Mode -->
                <div class="mb-3 p-3 border rounded bg-light">
                    <div class="form-check form-switch">
                        <!-- We check if $settings->maintenance_mode is 1 (true) -->
                        <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenanceMode" 
                            {{ $settings->maintenance_mode ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="maintenanceMode">Maintenance Mode</label>
                    </div>
                    <small class="text-danger">
                        * If enabled, you might want to add logic to block non-admins. (Currently just saves the status).
                    </small>
                </div>

                <hr>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
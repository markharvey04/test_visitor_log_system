<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Dashboard</title>
    
    <!-- 1. Modern Font (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- 2. Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- 3. FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5; /* Soft Gray-Blue Background */
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .card {
            border: none;
            border-radius: 16px; /* Smooth rounded corners */
            transition: transform 0.2s;
        }
        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            color: #6c757d;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.005); /* Micro interaction on hover */
            transition: 0.2s;
        }
        .avatar-circle {
            width: 35px;
            height: 35px;
            background-color: #4e73df;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .btn-round {
            border-radius: 50px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <div class="bg-primary text-white rounded p-1">
                <i class="fa-solid fa-building"></i>
            </div>
            <span class="fw-bold text-dark">
                {{ \App\Models\SystemSetting::firstOrCreate(['id'=>1], ['system_name'=>'Visitor Log'])->system_name }}
            </span>
        </a>
        
        <div class="d-flex align-items-center gap-3">
            <!-- User Info -->
            <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-light border">
                <div class="avatar-circle" style="font-size: 0.8rem;">
                    {{ substr(session('Name'), 0, 1) }}
                </div>
                <span class="text-secondary small fw-bold">{{ session('Name') }}</span>
            </div>

            <!-- ADMIN TOOLS DROP DOWN -->
            @if(session('RoleID') == 3)
                <div class="dropdown">
                    <button class="btn btn-warning btn-sm btn-round px-3 fw-bold dropdown-toggle text-dark" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-screwdriver-wrench me-1"></i> Admin
                    </button>
                    <ul class="dropdown-menu shadow border-0 mt-2 rounded-3">
                        <li><a class="dropdown-item py-2" href="{{ route('admin.users') }}"><i class="fa-solid fa-users me-2 text-primary"></i> Manage Users</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear me-2 text-secondary"></i> Settings</a></li>
                    </ul>
                </div>
            @endif

            <!-- LOGOUT -->
            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm btn-round px-3">
                <i class="fa-solid fa-power-off"></i>
            </a>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container" style="margin-top: 100px;">

    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Dashboard</h2>
            <p class="text-muted small mb-0">Overview of today's visitors</p>
        </div>
        
        <!-- NEW VISITOR BUTTON -->
        @if(session('RoleID') == 1 || session('RoleID') == 3)
            <a href="{{ route('visitors.create') }}" class="btn btn-primary btn-round shadow px-4 py-2">
                <i class="fa-solid fa-plus me-1"></i> New Visitor
            </a>
        @endif
    </div>

    <!-- NOTIFICATIONS -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- MAIN CARD -->
    <div class="card shadow-lg mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Visitor Name</th>
                            <th class="py-3">Details</th>
                            <th class="py-3">Timings</th>
                            <th class="py-3">Status</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visits as $visit)
                        <tr>
                            <!-- VISITOR NAME -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle bg-light text-primary">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $visit->visitor->Name }}</div>
                                        <div class="small text-muted">ID: #{{ $visit->VisitID }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- DEPARTMENT INFO -->
                            <td>
                                <div class="small text-muted"><i class="fa-solid fa-building me-1"></i> {{ $visit->department->DepartmentName }}</div>
                                <div class="small text-muted"><i class="fa-solid fa-user-tie me-1"></i> {{ $visit->staff->Name }}</div>
                            </td>

                            <!-- TIMING -->
                            <td>
                                <div class="badge bg-light text-dark border fw-normal">
                                    IN: {{ \Carbon\Carbon::parse($visit->CheckInTime)->format('h:i A') }}
                                </div>
                                <br>
                                @if($visit->CheckOutTime)
                                    <div class="badge bg-light text-secondary border fw-normal mt-1">
                                        OUT: {{ \Carbon\Carbon::parse($visit->CheckOutTime)->format('h:i A') }}
                                    </div>
                                @endif
                            </td>

                            <!-- STATUS BADGE -->
                            <td>
                                @if($visit->Status == 'Active')
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                        <span class="spinner-grow spinner-grow-sm me-1" style="width: 8px; height: 8px;"></span> Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                        <i class="fa-solid fa-check-double me-1"></i> Completed
                                    </span>
                                @endif
                            </td>
                            
                            <!-- ACTIONS -->
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    
                                    <!-- CHECK OUT BTN -->
                                    @if(session('RoleID') == 1 || session('RoleID') == 3)
                                        @if($visit->Status == 'Active')
                                            <form action="{{ route('visitors.checkout', $visit->VisitID) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm btn-round" title="Check Out">
                                                    <i class="fa-solid fa-person-walking-arrow-right"></i> Out
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-light btn-sm btn-round text-muted" disabled>
                                                <i class="fa-solid fa-lock"></i>
                                            </button>
                                        @endif
                                    @endif

                                    <!-- DELETE BTN (Admin) -->
                                    @if(session('RoleID') == 3)
                                        <form action="{{ route('visitors.delete', $visit->VisitID) }}" method="POST" onsubmit="return confirm('Delete this record permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light text-danger btn-sm btn-round hover-shadow" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted opacity-50">
                                    <i class="fa-regular fa-clipboard fa-3x mb-3"></i>
                                    <h5>No visitors logged today.</h5>
                                    <p class="small">Click "New Visitor" to start.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
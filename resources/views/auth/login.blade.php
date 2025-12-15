<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Visitor System</title>
    
    <!-- Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px); /* Glass effect */
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 40px;
            animation: fadeIn 0.8s ease-in-out;
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 20px auto;
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }

        .form-floating > .form-control:focus ~ label {
            color: #4e73df;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.1);
        }

        .btn-primary {
            background: #4e73df;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logo / Icon -->
        <div class="brand-icon">
            <i class="fa-solid fa-building-shield"></i>
        </div>

        <!-- Dynamic Title from Settings -->
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark">Welcome</h4>
            <p class="text-muted small">
                {{ \App\Models\SystemSetting::firstOrCreate(['id'=>1], ['system_name'=>'Visitor Log'])->system_name }}
            </p>
        </div>

        <!-- Error Alert -->
        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 shadow-sm d-flex align-items-center mb-3">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                <div class="small">{{ session('error') }}</div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <!-- Username with Floating Label -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="Username" placeholder="Enter username" required>
                <label for="username"><i class="fa-regular fa-user me-1"></i> Username</label>
            </div>

            <!-- Password with Floating Label -->
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                <label for="password"><i class="fa-solid fa-lock me-1"></i> Password</label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                Login to Dashboard <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </form>

        <div class="text-center mt-4">
            <span class="text-muted small">Need access? Contact Admin.</span>
        </div>
    </div>

</body>
</html>
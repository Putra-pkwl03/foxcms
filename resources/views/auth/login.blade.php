<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AHF Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #eef2ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background Shapes */
        .shape-1 {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
        .shape-2 {
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: rgba(76, 201, 240, 0.1);
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(67, 97, 238, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        .form-label {
            font-weight: 500;
            color: #64748b;
            font-size: 0.9rem;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #4361ee;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .input-group-text {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            border-radius: 12px;
            border-right: none;
            color: #94a3b8;
        }
        
        .input-group .form-control {
            border-left: none;
        }
        
        .input-group .form-control:focus {
            border-left: 1px solid #4361ee;
            margin-left: -1px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.25);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.35);
        }

        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        
        .welcome-text {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .subtitle-text {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
        }

    </style>
</head>
<body>

    <div class="shape-1"></div>
    <div class="shape-2"></div>

    <div class="login-card">
        <div class="text-center">
            <div class="brand-logo">
                <i class="bi bi-building-fill"></i>
            </div>
            <h3 class="welcome-text">Welcome Back</h3>
            <p class="subtitle-text">Please sign in to continue</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                           id="username" name="username" value="{{ old('username') }}" 
                           placeholder="Enter your username" required autofocus>
                </div>
                @error('username')
                    <div class="d-block invalid-feedback text-danger">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" 
                           placeholder="Enter your password" required>
                </div>
                @error('password')
                    <div class="d-block invalid-feedback text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid pt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                </button>
            </div>
            
            <div class="text-center mt-4">
                <small class="text-muted">TakeOff Launcher Admin &copy; {{ date('Y') }}</small>
            </div>
        </form>
    </div>

</body>
</html>

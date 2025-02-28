<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9d5ff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .login-container {
            max-width: 400px;
            width: 90%;
            padding: 40px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .login-container:hover {
            transform: translateY(-5px);
        }
        .login-container h3 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #9333ea;
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.25);
        }
        .form-check-input:checked {
            background-color: #9333ea;
            border-color: #9333ea;
        }
        a {
            color: #9333ea;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #7e22ce;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="text-center mb-4">Login</h3>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <p class="text-center mt-3"><a href="#">Forgot your password?</a></p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    {{-- <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // You can add your login API request here.
            // Example:
            // fetch('/api/login', { method: 'POST', body: JSON.stringify({ email, password }) })
            //     .then(response => response.json())
            //     .then(data => {
            //         if (data.success) {
            //             window.location.href = '/dashboard';
            //         } else {
            //             alert('Invalid credentials');
            //         }
            //     });

            // For now, we'll just log the input
            console.log('Email:', email);
            console.log('Password:', password);
        });
    </script> --}}
</body>
</html>

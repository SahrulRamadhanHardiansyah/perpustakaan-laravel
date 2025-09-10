<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Laravel Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=:Poppinswght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        #togglePassword {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center p-5">
        @if (session('status'))
            <div class="alert alert-primary">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops! There are some problems with your input.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="auth-box">
            <h2 class="auth-title text-center">Welcome Back</h2>
            <p class="auth-desc text-center">Please sign in to your account</p>

            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Enter your name">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                        <span class="input-group-text" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-3 text-end">
                    <a href="{{ route('password.request') }}">
                        <small>Forgot Password?</small>
                    </a>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn form-control btn-primary">Login</button>
                </div>
                <div class="auth-link text-center">
                    <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
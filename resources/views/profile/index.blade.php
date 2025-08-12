<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome Page | Laravel Auth</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="main d-flex flex-column">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('welcome') }}" style="font-weight: 700; color: var(--primary-color);">TokoKita</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Selamat Datang, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <div class="body-content flex-grow-1">
            <div class="row g-0 h-100">
                <div class="content-container p-4 col-lg-10">
                    <div class="content h-100 p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Welcome, {{ $user->name }}</h2>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">User Profile</h5>

                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary d-flex align-items-center">
                                        <lord-icon
                                            src="https://cdn.lordicon.com/exymduqj.json"
                                            trigger="hover"
                                            stroke="bold"
                                            state="in-dynamic"
                                            colors="primary:#ffffff"
                                            class="me-2"
                                            style="width:25px;height:25px">
                                        </lord-icon>
                                        Edit Profile
                                    </a>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                <dl class="row">
                                    <dt class="col-sm-3 d-flex align-items-center">
                                        <lord-icon src="https://cdn.lordicon.com/bgebyztw.json" stroke="bold" trigger="hover" class="me-2" style="width:25px;height:25px"></lord-icon>
                                        Name
                                    </dt>
                                    <dd class="col-sm-9 user-info">{{ $user->name }}</dd>

                                    <dt class="col-sm-3 d-flex align-items-center">
                                        <lord-icon src="https://cdn.lordicon.com/ebjjjrhp.json" stroke="bold" trigger="hover" class="me-2" style="width:25px;height:25px"></lord-icon>
                                        Email
                                    </dt>
                                    <dd class="col-sm-9 user-info">{{ $user->email }}</dd>

                                    <dt class="col-sm-3 d-flex align-items-center">
                                        <lord-icon src="https://cdn.lordicon.com/ssvybplt.json" stroke="bold" trigger="hover" class="me-2" style="width:25px;height:25px"></lord-icon>
                                        Phone Number
                                    </dt>
                                    <dd class="col-sm-9 user-info">{{ $user->phone ? : '-' }}</dd>

                                    <dt class="col-sm-3 d-flex align-items-center">
                                        <lord-icon src="https://cdn.lordicon.com/onmwuuox.json" trigger="hover" stroke="bold" class="me-2" style="width:25px;height:25px"></lord-icon>
                                        Address
                                    </dt>
                                    <dd class="col-sm-9 user-info">{{ $user->address }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>
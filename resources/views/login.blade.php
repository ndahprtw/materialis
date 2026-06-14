<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="{{ asset('assets/img/logo.jpg') }}" rel="icon">
      <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="apple-touch-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <title>Login Sistem Materialis</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url("{{ asset('assets/img/bg.jpg') }}") no-repeat center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 420px;
            padding: 50px 40px;
            border-radius: 25px;
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            color: #fff;
            text-align: center;
        }

        .login-box img {
            width: 90px;
            margin-bottom: 15px;
        }

        .login-box h3 {
            font-weight: 700;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        /* INPUT */
        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group-custom input {
            width: 100%;
            padding: 15px 50px;
            border-radius: 35px;
            border: none;
            outline: none;
            font-size: 15px;
            background: rgba(255,255,255,0.2);
            color: #fff;
            transition: 0.3s;
        }

        .input-group-custom input::placeholder {
            color: #eee;
        }

        .input-group-custom input:focus {
            background: rgba(255,255,255,0.3);
            box-shadow: 0 0 12px rgba(13,110,253,0.8);
        }

        /* ICON */
        .input-group-custom i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #fff;
        }

        .left-icon {
            left: 18px;
        }

        .right-icon {
            right: 18px;
            cursor: pointer;
        }

        /* BUTTON */
        .btn-login {
            width: 100%;
            border-radius: 35px;
            background: linear-gradient(45deg, #0d6efd, #0b5ed7);
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s;
            color: #fff;
        }

        .btn-login:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(13,110,253,0.8);
        }

        .alert {
            font-size: 14px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <img src="{{ asset('assets/img/logo.png') }}" alt="">
    <h3 class="m-0">MATERIALIS</h3>
    <p>(Material Information System)</p>

    @if(session('wrong'))
        <div class="alert alert-danger">
            {{ session('wrong') }}
        </div>
    @endif

    <form method="post" action="/login">
        @csrf

        <!-- EMAIL -->
        <div class="input-group-custom">
            <i class="fas fa-envelope left-icon"></i>
            <input type="email" name="email" placeholder="Masukkan Email" required>
        </div>

        <!-- PASSWORD -->
        <div class="input-group-custom">
            <i class="fas fa-lock left-icon"></i>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            <i class="fas fa-eye right-icon" onclick="togglePassword()"></i>
        </div>

        <button type="submit" class="btn btn-login">Login</button>
    </form>
</div>

<script>
function togglePassword() {
    let pwd = document.getElementById("password");
    pwd.type = pwd.type === "password" ? "text" : "password";
}
</script>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

</body>
</html>
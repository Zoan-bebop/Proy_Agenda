<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control')</title>

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .login-box, .register-box {
            width: 400px;
        }
        .card {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>

    @stack('styles')
</head>
<body class="hold-transition login-page">

    {{-- Contenido principal --}}
    @yield('content')

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    @stack('scripts')
</body>
</html>

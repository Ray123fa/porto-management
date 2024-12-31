<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sign-in.css') }}">
</head>

<body class="d-flex align-items-center py-4 bg-body">
    <main class="form-signin w-100 m-auto bg-body-tertiary p-4 rounded-lg">
        <form>
            <h1 class="h3 mb-3 fw-bold text-center">{{ config('app.name') }}</h1>
            <h2 class="h4 mb-3 fw-semibold text-center">Sign in</h2>
            <a href="{{ route('auth.google') }}" class="btn btn-primary w-100">Login with Google</a>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

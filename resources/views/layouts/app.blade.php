<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Insurtech App')</title>
</head>
<body>
    <header>
        <h1>Insurtech Demo</h1>
        <nav>
            <a href="{{ route('landing') }}">Home</a>
            {{-- More links later --}}

            <nav>
    <a href="{{ route('landing') }}">Home</a> |
    <a href="{{ route('policies.index') }}">Policies</a>
</nav>

        </nav>
        <hr>
    </header>

    <main>
        <main>
    @if (session('success'))
        <div style="padding: 10px; background: #d1fae5; border: 1px solid #10b981; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>


    <footer>
        <hr>
        <p>&copy; {{ date('Y') }} Insurtech Demo</p>
    </footer>

    @yield('scripts')
</body>
</html>

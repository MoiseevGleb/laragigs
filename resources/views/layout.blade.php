<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="#" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    },
                },
            },
        };
    </script>
    <title>LaraGigs | Find Laravel Jobs & Projects</title>
</head>
<body class="mb-48">
<x-flash-message/>
<nav class="flex justify-between items-center mb-4">
    <a href="{{ route('home') }}"
    ><img class="w-24" src="{{ asset('images/logo.png') }}" alt="" class="logo"
        /></a>
    <ul class="flex space-x-6 mr-6 text-lg">
        @guest
            <li>
                <a href="{{ route('register') }}" class="hover:text-laravel"
                ><i class="fa-solid fa-user-plus"></i> Register</a
                >
            </li>

            <li>
                <a href="{{ route('login') }}" class="hover:text-laravel"
                ><i class="fa-solid fa-arrow-right-to-bracket"></i>
                    Login</a
                >
            </li>
        @endguest

        @auth
            <li>
                <span class="font-bold uppercase">
                    welcome, {{ auth()->user()->name }}
                </span>
            </li>

            <li>
                <a href="{{ route('listings.manage') }}" class="hover:text-laravel"
                ><i class="fa-solid fa-gear"></i>
                    Manage Listings</a
                >
            </li>

            <li>
                <form action="{{ route('users.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:text-laravel">
                        <i class="fa-solid fa-door-closed"></i>
                        Logout
                    </button>
                </form>
            </li>
        @endauth
    </ul>
</nav>

<main>
    @yield('content')
</main>

<footer
    class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center"
>
    <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>

    <a
        href="{{ route('listings.create') }}"
        class="absolute top-1/3 right-10 bg-black text-white py-2 px-5"
    >Post Job</a
    >
</footer>
</body>
</html>

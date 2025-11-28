<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <script>
        (function() {
            const stored = localStorage.getItem('theme');
            const osPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldUseDark = stored ? stored === 'dark' : osPrefersDark;
            document.documentElement.classList.toggle('dark', shouldUseDark);
            document.documentElement.classList.toggle('dark-ums', shouldUseDark);
        })();
    </script>

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ asset('user/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
        /* define the background colors for the striped effect */
        select.stripe option:nth-child(odd) {
            background-color: #f2f2f2;
        }
        select.stripe option:nth-child(even) {
            background-color: #fff;
        }
    </style>
    @if (file_exists(public_path('css/dark-mode.css')))
        <link href="{{ asset('css/dark-mode.css') }}" rel="stylesheet">
    @endif
    @livewireScripts
    <script src="{{ asset('user/js/app.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-200">


<div class="py-10">

    <main>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between md:space-x-5 mb-5">
                <div class="flex items-start space-x-5">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        Settings
                    </h1>
                </div>
                <div class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                        Back to Portal
                    </a>
                </div>
            </div>


            @yield('content')
        </div>
    </main>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #9eeaf9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 12px 16px;
            z-index: 1;
            margin-top: 30px;
        }

        .dropdown-content li {
            list-style-type: none;
            padding: 8px 0;
        }

        .show {
            display: block;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif

                    @else
                        <i id="notificationIcon" style='font-size:24px; margin-right: 0px; margin-top: 5px;' class='fas'>&#xf0f3;</i>
                        <span style="color: #0a58ca " class="badge badge-light">{{auth()->user()->notifications->count()}}</span>

                        <ul id="notificationDropdown"  class="dropdown-content">
                            <li>Notification 1</li>
                            <li>Notification 2</li>
                        </ul>

                        <script>
                            document.getElementById("notificationIcon").addEventListener("click", function() {
                                toggleDropdown();
                            });

                            function toggleDropdown() {
                                var dropdown = document.getElementById("notificationDropdown");
                                dropdown.classList.toggle("show");
                            }

                            function fetchNotifications() {
                                // Use AJAX to fetch new notifications from the server
                                // Update the notification dropdown with the new notifications
                            }
                        </script>
                </ul>
            </div>
        </div>
    </nav>
</div>


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    @livewireStyles

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fonts -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->






    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>


<body>


    <!-- تقسيم الصفحه الى قسمين بالطول  -->

    <div class="flex flex-col bg-white h-screen border-b border-gray-200 ">
        <!-- navbar -->
        <div class="flex h-16 w-full">
            <!-- logo -->
            <div class="h-16 w-16 border-l border-gray-200 flex justify-center flex-col items-center md:w-40">
                <x-logo class="size-10 md:size-15" />
            </div>
            <!-- center-->
            <div class="flex-1 border-b border-gray-200 ">
                @yield('navbar-row')
            </div>
            <!-- left -->
            <div class="w-16 border-b border-gray-200  flex flex-col justify-center items-center lg:hidden">
                <x-nav-bar />

            </div>

            <!-- left in lg and above -->
            <div class="hidden w-55 flex border-b border-gray-200 items-center space-x-6 lg:inline-flex">
                <x-massege />
                <x-profile-img />
            </div>



        </div>

        <div class="flex-1 flex overflow-hidden  ">
            <!-- sidebar -->
            <div
                class="border-l border-gray-200  h-full w-16 flex justify-center hover:justify-start hover:pr-4 hover:w-40  transition-all duration-300 border   hover:overflow-y-auto custom-scroll
                md:w-40 md:justify-start md:pr-4  ">
                <x-col-nav />
            </div>
            <!-- content -->
            <div class="flex-1 overflow-y-auto ">
                @yield('content')
            </div>
        </div>





    </div>


    @livewireScripts
</body>
@yield('script')


</html>

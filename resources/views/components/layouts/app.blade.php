<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'WashUp' }}</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg bg-base-200 min-h-screen">
    @auth

        <div class="drawer lg:drawer-open">
            <input id="drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                @livewire('partial.navbar')
                {{ $slot }}
            </div>
            <div class="drawer-side">
                <label for="drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                @livewire('partial.sidebar')
            </div>
        </div>
    @endauth
    @guest
        <div class="flex flex-col justify-center items-center h-screen gap-8">
            <h1 class="font-blod text-4xl">{{ env('APP_NAME') }}</h1>
            {{ $slot }}
        </div>
    @endguest

    @stack('scripts')
    @stack('js')


</body>


</html>

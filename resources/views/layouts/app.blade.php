<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{config('app.name', 'Webアンケート作成')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
        <link rel="stylesheet" href="{{mix('css/main.css')}}">
            
    </head>
    <body class="antialiased">
        <div id="app">
            <x-header></x-header>
    
            <main class="py-5 bg-gray-100">
                {{$slot}}
            </main>
        </div>


        <!-- JS -->
        <script src="{{mix('js/app.js')}}" defer></script>
    </body>
</html>

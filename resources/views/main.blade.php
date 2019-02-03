<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SpalopiaApi</title>

        <!-- Styles -->
        <style>

        </style>
    </head>
    <body>
        <div id="app">
            <app-component></app-component>
            <date-component></date-component>
            <booking-component></booking-component>
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
</html>

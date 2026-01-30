<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Gudangku</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Styles -->
        <style>
            /* Warehouse Background */
            .warehouse-bg {
                background: linear-gradient(135deg, #92400e 0%, #78350f 50%, #92400e 100%);
                position: relative;
            }
            .warehouse-bg::before {
                content: '';
                position: absolute;
                inset: 0;
                background: repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 35px,
                    rgba(255,255,255,.03) 35px,
                    rgba(255,255,255,.03) 70px
                );
                pointer-events: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="warehouse-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
            
            <!-- Decorative Gradient Overlay -->
            <div class="absolute inset-0 z-0 bg-gradient-to-br from-amber-900/40 via-transparent to-orange-900/40 pointer-events-none"></div>

            <!-- Content Container -->
            <div class="relative z-10 w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
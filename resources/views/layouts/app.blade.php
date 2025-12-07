<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Dynamic Theme Colors -->
    @if($siteSetting && $siteSetting->primary_color)
    <style>
        :root {
            --primary-color: {{ $siteSetting->primary_color ?? '#C2410C' }};
            --secondary-color: {{ $siteSetting->secondary_color ?? '#FBBF24' }};
        }

        /* Override all orange-600 variants with primary color */
        .bg-orange-600,
        .from-orange-600,
        .hover\:bg-orange-600:hover {
            background-color: var(--primary-color) !important;
        }

        /* Override orange-700 (darker shade for hover states) */
        .bg-orange-700,
        .hover\:bg-orange-700:hover {
            background-color: color-mix(in srgb, var(--primary-color) 85%, black) !important;
        }

        /* Override all yellow-600 variants with secondary color */
        .bg-yellow-600,
        .to-yellow-600 {
            background-color: var(--secondary-color) !important;
        }

        /* Text colors */
        .text-orange-600,
        .hover\:text-orange-600:hover {
            color: var(--primary-color) !important;
        }

        /* Border colors */
        .border-orange-600,
        .hover\:border-orange-600:hover {
            border-color: var(--primary-color) !important;
        }

        /* Ring/Focus colors */
        .ring-orange-600,
        .focus\:ring-orange-600:focus {
            --tw-ring-color: var(--primary-color) !important;
        }

        /* Gradient backgrounds */
        .bg-gradient-to-br.from-orange-600.to-yellow-600,
        .bg-gradient-to-r.from-orange-600.to-yellow-600 {
            background: linear-gradient(to bottom right, var(--primary-color), var(--secondary-color)) !important;
        }

        /* Group hover states */
        .group:hover .group-hover\:text-orange-600 {
            color: var(--primary-color) !important;
        }

        .group:hover .group-hover\:bg-orange-600 {
            background-color: var(--primary-color) !important;
        }

        /* Background hover for orange-50 (light backgrounds) */
        .hover\:bg-orange-50:hover {
            background-color: color-mix(in srgb, var(--primary-color) 10%, white) !important;
        }
    </style>
    @endif
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    @livewire('frontend.navigation')

    <!-- Main Content -->
    <main class="pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    @livewire('frontend.footer')

    <!-- WhatsApp Floating Button -->
    @livewire('frontend.whats-app-button')

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Global Toaster Function -->
    <script>
        function showToast(message, type = 'success') {
            const colors = {
                success: 'linear-gradient(to right, #10b981, #059669)',
                error: 'linear-gradient(to right, #ef4444, #dc2626)',
                info: 'linear-gradient(to right, #3b82f6, #2563eb)',
                warning: 'linear-gradient(to right, #f59e0b, #d97706)'
            };

            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: colors[type] || colors.success,
                }
            }).showToast();
        }
    </script>

    @stack('scripts')
</body>
</html>

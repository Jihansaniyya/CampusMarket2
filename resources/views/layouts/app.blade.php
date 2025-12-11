<!DOCTYPE html>
<html lang="en" x-data class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CampusMarket - Temukan produk terbaik dari seller terpercaya.">
    <meta name="keywords" content="marketplace, ecommerce, tokopedia, belanja online">
    <meta name="author" content="CampusMarket">
    <link rel="icon" type="image/png" href="{{ asset('assets/logo1.png') }}">
    <title>@yield('title', 'CampusMarket | Belanja Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('quickView', {
                open: false,
                product: {},
                openModal(product) {
                    this.product = product;
                    this.open = true;
                    document.body.classList.add('overflow-hidden');
                    queueMicrotask(() => document.getElementById('quick-view-modal')?.focus());
                },
                closeModal() {
                    this.open = false;
                    document.body.classList.remove('overflow-hidden');
                },
            });
        });
    </script>
    @stack('head')
</head>

<body class="bg-gray-50 text-gray-900 font-sans">
    <div class="min-h-screen flex flex-col">
        @include('components.header')

        <main class="flex-1">
            @yield('content')
        </main>

        <div class="mt-16">
            @include('components.footer')
        </div>
    </div>

    @stack('scripts')
</body>

</html>

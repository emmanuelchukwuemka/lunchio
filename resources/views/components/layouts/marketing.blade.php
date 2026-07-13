<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }} — Launch your business, all in one place</title>
    <meta name="description" content="{{ $description ?? 'Launchio bundles business registration, brand identity, and a launch-ready website into one simple package.' }}">

    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|sora:500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <x-analytics />
</head>
<body class="min-h-screen bg-[#F3F4F6] font-sans text-slate-800 antialiased" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">

    <header class="fixed top-0 w-full z-50 transition-all duration-300" :class="scrolled ? 'bg-slate-900/95 backdrop-blur shadow-lg border-b border-white/10' : 'bg-transparent border-b border-transparent'">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 transition-all duration-300" :class="scrolled ? 'py-4' : 'py-6'">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-9 w-auto transition-all brightness-0 invert">
            </a>

            <div class="hidden items-center gap-8 text-sm font-medium lg:flex transition-colors text-white/90">
                <a href="/#how-it-works" class="hover:text-brand-600 transition-colors">How It Works</a>
                <a href="/#packages" class="hover:text-brand-600 transition-colors">Packages</a>
                <a href="/#services" class="hover:text-brand-600 transition-colors">Services</a>
                <a href="/#about" class="hover:text-brand-600 transition-colors">About</a>
                <a href="/#blog" class="hover:text-brand-600 transition-colors">Blog</a>
                <a href="/#faq" class="hover:text-brand-600 transition-colors">FAQ</a>
                <a href="/#contact" class="hover:text-brand-600 transition-colors">Contact</a>
            </div>

            <div class="flex items-center gap-3 transition-colors text-white/90">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold transition-colors hover:text-brand-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold transition-colors hover:text-brand-600">Log in</a>
                @endauth
                <a href="{{ route('get-started') }}" class="rounded-lg px-5 py-2.5 text-sm font-bold shadow-sm transition-all bg-brand-600 text-white hover:bg-brand-700">
                    Start Your Launch
                </a>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-[#FFFFFF1A] bg-[#0A0F1A] text-slate-300">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="flex items-center gap-2 text-lg font-bold text-white">
                    <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-12 w-auto filter brightness-0 invert">
                </div>
                <p class="mt-3 text-sm text-slate-400">One platform to register, brand, and launch your business.</p>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Product</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="/#how-it-works" class="hover:text-white">How It Works</a></li>
                    <li><a href="/#packages" class="hover:text-white">Packages & Pricing</a></li>
                    <li><a href="/#services" class="hover:text-white">Services</a></li>
                    <li><a href="/#blog" class="hover:text-white">Blog</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Company</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="/#about" class="hover:text-white">About</a></li>
                    <li><a href="/#contact" class="hover:text-white">Contact</a></li>
                    <li><a href="/#faq" class="hover:text-white">FAQ</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Legal</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ route('legal', 'terms') }}" class="hover:text-white">Terms of Service</a></li>
                    <li><a href="{{ route('legal', 'privacy') }}" class="hover:text-white">Privacy Policy</a></li>
                    <li><a href="{{ route('legal', 'refund') }}" class="hover:text-white">Refund Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-6 text-center text-xs text-slate-500">
            &copy; {{ now()->year }} Launchio. All rights reserved.
        </div>
    </footer>

    <x-whatsapp-button />

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        // Stop observing once revealed
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: "0px 0px -50px 0px" });

            document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>

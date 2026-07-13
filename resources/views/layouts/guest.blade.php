<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Launchio') }} | Secure Access</title>
        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|sora:500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-white">
        
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Left Side: Brand Panel -->
            <div class="hidden md:flex md:w-1/2 lg:w-5/12 bg-slate-950 flex-col p-12 lg:p-16 relative overflow-hidden">
                <!-- Abstract Background Pattern -->
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

                <div class="relative z-10 flex-1 flex flex-col justify-center items-center text-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:scale-105 transition-transform duration-500 mb-10">
                        <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-24 md:h-32 w-auto filter brightness-0 invert drop-shadow-2xl">
                    </a>

                    <blockquote class="space-y-6 max-w-sm">
                        <div x-data="{
                            text: '',
                            fullText: 'The fastest way to register your business, build your brand, and start acquiring customers.',
                            isDeleting: false,
                            type() {
                                let speed = this.isDeleting ? 15 : 40;
                                
                                if (!this.isDeleting && this.text === this.fullText) {
                                    speed = 4000;
                                    this.isDeleting = true;
                                } else if (this.isDeleting && this.text === '') {
                                    this.isDeleting = false;
                                    speed = 1000;
                                }

                                if (this.isDeleting) {
                                    this.text = this.fullText.substring(0, this.text.length - 1);
                                } else {
                                    this.text = this.fullText.substring(0, this.text.length + 1);
                                }

                                setTimeout(() => this.type(), speed);
                            }
                        }" x-init="setTimeout(() => type(), 500)">
                            <p class="text-2xl font-medium text-white/90 leading-snug tracking-tight min-h-[120px]">
                                "<span x-text="text"></span><span class="animate-pulse text-brand-500 font-light">|</span>"
                            </p>
                        </div>
                        <footer class="text-slate-400 text-sm font-medium uppercase tracking-widest">
                            Join hundreds of founders
                        </footer>
                    </blockquote>
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 lg:p-20 relative bg-white">
                <!-- Mobile Logo -->
                <div class="md:hidden absolute top-8 left-8">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-8 w-auto">
                    </a>
                </div>

                <div class="w-full max-w-sm xl:max-w-md">
                    {{ $slot }}
                </div>
                
                <div class="absolute bottom-8 text-center w-full max-w-md px-6 text-xs text-slate-500">
                    By continuing, you agree to Launchio's <a href="{{ route('legal', 'terms') }}" class="underline hover:text-slate-900 transition">Terms of Service</a> and <a href="{{ route('legal', 'privacy') }}" class="underline hover:text-slate-900 transition">Privacy Policy</a>.
                </div>
            </div>

        </div>

    </body>
</html>

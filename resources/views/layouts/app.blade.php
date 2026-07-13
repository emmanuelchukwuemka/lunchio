<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Launchio') }}</title>
        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|sora:500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50 relative selection:bg-brand-500 selection:text-white">
        <!-- Abstract subtle background decoration -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[30%] -right-[10%] w-[70%] h-[70%] rounded-full bg-brand-400/5 mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-400/5 mix-blend-multiply filter blur-3xl"></div>
        </div>

        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col relative z-20 shadow-sm">
                <div class="h-20 flex items-center px-6 border-b border-slate-100">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-8 w-auto transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>
                
                <nav class="flex-1 px-4 py-8 space-y-6 overflow-y-auto">
                    <!-- General -->
                    <div>
                        <div class="px-3 mb-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Workspace</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Overview
                            </a>
                            <a href="{{ route('customer.launches.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.launches.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                My Launches
                            </a>
                            <a href="{{ route('customer.assets.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.assets.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Assets & Files
                            </a>
                            <a href="{{ route('calendar.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('calendar.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Content Calendar
                            </a>
                        </div>
                    </div>

                    <!-- Account -->
                    <div>
                        <div class="px-3 mb-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Account</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('customer.billing.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.billing.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Billing & Invoices
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Settings
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="p-4 border-t border-slate-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-slate-200">
                            @else
                                <div class="h-12 w-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold text-lg border-2 border-white shadow-sm ring-1 ring-slate-200">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-bold text-slate-900 leading-none">{{ explode(' ', Auth::user()->name)[0] }}</p>
                                <p class="text-xs text-slate-500 mt-1">Founder</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" title="Log out">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-slate-600 transition-colors rounded-lg hover:bg-slate-100">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col relative min-w-0">
                <!-- Top Header -->
                <header class="h-20 sticky top-0 z-10 backdrop-blur-md bg-white/80 border-b border-slate-200/60 flex items-center justify-between px-8 shadow-sm">
                    <div class="flex items-center gap-8 w-full max-w-4xl">
                        <h1 class="text-xl font-sora font-bold tracking-tight text-slate-900 whitespace-nowrap">{{ $header ?? '' }}</h1>
                    </div>
                    @role('admin')
                    <div class="flex items-center space-x-6 ml-6">
                        <a href="{{ route('admin.home') }}" class="text-sm font-semibold text-slate-500 hover:text-brand-600 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <span>Admin Portal</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                    @endrole
                </header>

                <!-- Page Content -->
                <main class="flex-1 w-full pb-16 overflow-y-auto px-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>

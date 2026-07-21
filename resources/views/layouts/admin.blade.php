<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Workspace | {{ config('app.name', 'Launchio') }}</title>
        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|sora:500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 selection:bg-brand-500 selection:text-white">
        
        <div class="min-h-screen flex">
            <!-- Sleek Dark Sidebar -->
            <aside class="w-72 bg-slate-950 text-white hidden md:flex flex-col relative z-20 shadow-2xl">
                <!-- Abstract Subtle Glow -->
                <div class="absolute top-0 left-0 w-full h-64 bg-brand-600/10 rounded-full mix-blend-screen filter blur-3xl opacity-50 pointer-events-none"></div>

                <div class="h-20 flex items-center px-8 border-b border-white/10 relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-9 w-auto filter brightness-0 invert transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>
                
                <nav class="flex-1 px-4 py-8 space-y-6 relative z-10 overflow-y-auto custom-scrollbar">

                    <!-- Overview -->
                    <div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.home') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.home') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.home') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.analytics.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.analytics.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.analytics.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                Analytics
                            </a>
                        </div>
                    </div>

                    <!-- Founders -->
                    <div>
                        <div class="px-4 mb-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Founders</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.founders.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.founders.index') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                All Founders
                            </a>
                            <a href="{{ route('admin.leads.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.leads.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Leads
                            </a>
                            <a href="{{ route('admin.founders.businesses') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.founders.businesses') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 6v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                                Businesses
                            </a>
                        </div>
                    </div>

                    <!-- Service Delivery -->
                    <div>
                        <div class="px-4 mb-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Service Delivery</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.orders.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Orders
                            </a>
                            <a href="{{ route('admin.projects.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.projects.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                                Projects
                            </a>
                            <a href="{{ route('admin.deliverables.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.deliverables.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Deliverables
                            </a>
                            <a href="{{ route('admin.websites.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.websites.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Websites
                            </a>
                            <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.bookings.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Bookings
                            </a>
                        </div>
                    </div>

                    <!-- Services -->
                    <div>
                        <div class="px-4 mb-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Services</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.services.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485"></path></svg>
                                Service Catalog
                            </a>
                        </div>
                    </div>

                    <!-- Finance -->
                    <div>
                        <div class="px-4 mb-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Finance</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.payments.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.payments.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Payments
                            </a>
                            <a href="{{ route('admin.subscriptions.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.subscriptions.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Subscriptions
                            </a>
                            <a href="{{ route('admin.invoices.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.invoices.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Invoices
                            </a>
                            <a href="{{ route('admin.payouts.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.payouts.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 9h14l1 12H4L5 9z"></path></svg>
                                Payouts
                            </a>
                        </div>
                    </div>

                    <!-- Team -->
                    <div>
                        <div class="px-4 mb-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Team</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.staff.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.staff.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Staff
                            </a>
                            <a href="{{ route('admin.assignments.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.assignments.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                Assignments
                            </a>
                            @role('admin')
                            <a href="{{ route('admin.roles.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.roles.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Roles
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                All Users
                            </a>
                            @endrole
                        </div>
                    </div>

                    <!-- CRM -->
                    <div>
                        <div class="px-4 mb-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">CRM</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.founders.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 text-slate-300 hover:text-white hover:bg-white/5">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Customers
                            </a>
                            <a href="{{ route('admin.leads.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 text-slate-300 hover:text-white hover:bg-white/5">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Leads
                            </a>
                            <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.messages.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Messages
                            </a>
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <div class="px-4 mb-2">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Content</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.packages.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.packages.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                Packages
                            </a>
                            <a href="{{ route('admin.blog.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.blog.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                Blog Posts
                            </a>
                            <a href="{{ route('admin.faqs.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.faqs.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                FAQs
                            </a>
                            <a href="{{ route('admin.testimonials.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.testimonials.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l1.586-1.586z"></path></svg>
                                Testimonials
                            </a>
                        </div>
                    </div>

                    <!-- Reports & Settings -->
                    <div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                                Reports
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin.settings.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-900/50' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Settings
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="p-4 relative z-10 border-t border-white/10">
                    <div class="bg-slate-900/50 rounded-2xl p-4 flex items-center justify-between hover:bg-slate-900 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-10 flex items-center justify-center">
                                <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-8 w-auto filter brightness-0 invert">
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" title="Log out">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-white transition-colors rounded-lg hover:bg-slate-800">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col bg-slate-50 relative min-w-0">
                <!-- Glassmorphism Top Header -->
                <header class="h-20 sticky top-0 z-10 backdrop-blur-md bg-white/80 border-b border-slate-200/60 flex items-center justify-between px-8 shadow-sm">
                    <div class="flex items-center gap-8 w-full max-w-4xl">
                        <h1 class="text-2xl font-sora font-bold tracking-tight text-slate-900 whitespace-nowrap">{{ $header ?? 'Dashboard' }}</h1>
                        
                        <!-- Global Search -->
                        <div class="hidden md:flex flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl leading-5 bg-white/50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition-colors" placeholder="Global Search (Orders, Users, Leads...)">
                        </div>
                    </div>
                    <div class="flex items-center space-x-6 ml-6">
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-500 hover:text-brand-600 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <span>User App</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto px-8 py-10">
                    @if(session('status'))
                        <div class="mb-8 bg-emerald-50 border border-emerald-200 p-4 rounded-xl shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-emerald-800">{{ session('status') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="max-w-7xl mx-auto pb-12">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        
    </body>
</html>

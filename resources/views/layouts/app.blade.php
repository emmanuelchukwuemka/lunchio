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
                
                <nav class="flex-1 px-4 py-8 space-y-5 overflow-y-auto">

                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('business.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('business.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('business.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 6v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                        My Business
                    </a>

                    <a href="{{ route('customer.package.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.package.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('customer.package.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        My Package
                    </a>

                    @if(Auth::user()->canAccess('manage-orders'))
                        <div>
                            <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('projects.index') && !request('bucket') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('projects.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                                My Projects
                            </a>
                            <div class="ml-8 mt-1 space-y-1">
                                <a href="{{ route('projects.index', ['bucket' => 'active']) }}" class="block px-3 py-1.5 rounded-lg text-xs font-medium {{ request('bucket') === 'active' ? 'text-brand-700 bg-brand-50' : 'text-slate-400 hover:text-slate-700' }}">Active Projects</a>
                                <a href="{{ route('projects.index', ['bucket' => 'pending_review']) }}" class="block px-3 py-1.5 rounded-lg text-xs font-medium {{ request('bucket') === 'pending_review' ? 'text-brand-700 bg-brand-50' : 'text-slate-400 hover:text-slate-700' }}">Pending Review</a>
                                <a href="{{ route('projects.index', ['bucket' => 'completed']) }}" class="block px-3 py-1.5 rounded-lg text-xs font-medium {{ request('bucket') === 'completed' ? 'text-brand-700 bg-brand-50' : 'text-slate-400 hover:text-slate-700' }}">Completed</a>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->canAccess('view-assets'))
                        <a href="{{ route('customer.brand-assets.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.brand-assets.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('customer.brand-assets.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485"></path></svg>
                            Brand Assets
                        </a>
                    @endif

                    @if(Auth::user()->canAccess('manage-website') && Auth::user()->hasPackageFeatureLike('Website'))
                        <a href="{{ route('websites.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('websites.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('websites.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            My Website
                        </a>
                    @endif

                    @if(Auth::user()->canAccess('view-assets'))
                        <a href="{{ route('customer.business-documents.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.business-documents.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('customer.business-documents.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Business Documents
                        </a>
                    @endif

                    @if(Auth::user()->canAccess('manage-calendar'))
                        <a href="{{ route('marketing.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('marketing.*', 'calendar.*', 'campaigns.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('marketing.*', 'calendar.*', 'campaigns.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            Marketing
                        </a>
                    @endif

                    @if(Auth::user()->canAccess('view-billing'))
                        <div>
                            <p class="px-3 mt-2 mb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sales & Payments</p>
                            <div class="space-y-1">
                                <a href="{{ route('payment-setup.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('payment-setup.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 9h14l1 12H4L5 9z"></path></svg>
                                    Payment Setup
                                </a>
                                <a href="{{ route('customer.billing.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.billing.*') || request()->routeIs('invoices.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Invoices & Transactions
                                </a>
                                @if(Auth::user()->canAccess('manage-crm'))
                                    <a href="{{ route('crm.index', ['status' => 'customer']) }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 text-slate-500 hover:bg-slate-50 hover:text-slate-900">
                                        <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Customers
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    @unless(Auth::user()->isTeamMember())
                        <a href="{{ route('team.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('team.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('team.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Team
                        </a>
                    @endunless

                    @if(Auth::user()->canAccess('view-billing'))
                        <a href="{{ route('customer.analytics.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.analytics.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('customer.analytics.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Analytics
                        </a>
                    @endif

                    @if(Auth::user()->canAccess('use-copilot'))
                        <a href="{{ route('copilot.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('copilot.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('copilot.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            AI Tools
                        </a>
                    @endif

                    @if(Auth::user()->canAccess('manage-crm'))
                        <div>
                            <p class="px-3 mt-2 mb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">CRM</p>
                            <div class="space-y-1">
                                <a href="{{ route('crm.index', ['status' => 'lead']) }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('crm.index') && request('status') === 'lead' ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Leads
                                </a>
                                <a href="{{ route('crm.index', ['status' => 'customer']) }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('crm.index') && request('status') === 'customer' ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Customers
                                </a>
                                <a href="{{ route('crm.follow-ups') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('crm.follow-ups') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Follow-ups
                                </a>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('experts.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('experts.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('experts.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Hire Experts
                    </a>

                    @if(Auth::user()->canAccess('view-assets'))
                        <a href="{{ route('customer.assets.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.assets.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('customer.assets.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            My Assets
                        </a>
                    @endif

                    @if(Auth::user()->canAccess('view-billing'))
                        <div>
                            <p class="px-3 mt-2 mb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Billing</p>
                            <div class="space-y-1">
                                <a href="{{ route('customer.subscription.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('customer.subscription.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Subscription
                                </a>
                                <a href="{{ route('customer.billing.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 text-slate-500 hover:bg-slate-50 hover:text-slate-900">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    Payments
                                </a>
                                <a href="{{ route('package.upgrade') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('package.upgrade') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    Upgrade Package
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->canAccess('manage-orders'))
                        <a href="{{ route('messages.index') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('messages.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('messages.*') ? 'text-brand-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Messages & Support
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="mr-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </a>
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
                                <p class="text-xs text-slate-500 mt-1">{{ Auth::user()->isTeamMember() ? 'Team Member' : 'Founder' }}</p>
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

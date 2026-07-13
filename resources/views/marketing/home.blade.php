<x-layouts.marketing>

    {{-- Hero --}}
    <section class="relative min-h-[95vh] flex flex-col justify-center overflow-hidden bg-slate-900 pb-20 pt-40" 
        style="background-image: linear-gradient(135deg, rgba(30,41,59,0.95) 0%, rgba(37,99,235,0.9) 50%, rgba(15,23,42,0.95) 100%), url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center;">
        
        <div class="relative z-10 mx-auto max-w-7xl px-6 flex flex-col items-center text-center w-full">
            
            <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-6 py-2 mb-8 shadow-2xl backdrop-blur-sm">
                <div class="h-2 w-2 rounded-full bg-brand-600 shadow-[0_0_10px_rgba(37,99,235,0.8)]"></div>
                <p class="text-sm text-white/90 font-medium tracking-wide">The Complete Business Launch System</p>
            </div>

            <h1 class="mx-auto max-w-5xl text-5xl font-bold tracking-tight text-white sm:text-7xl lg:text-[80px] leading-[1.1] mb-6">
                Move from idea to
                <span class="block mt-2 text-[#51A2FF] pb-4">market-ready faster.</span>
            </h1>
            
            <p class="mx-auto max-w-3xl text-xl text-slate-300 font-medium leading-relaxed mb-12">
                Business registration, branding, website, social media presence, and launch marketing — all brought together in one simple, guided package.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 w-full mb-16">
                <a href="{{ route('get-started') }}" class="bg-brand-600 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-brand-700 transition-colors shadow-[0_0_20px_rgba(37,99,235,0.4)] w-full sm:w-auto">
                    Start Your Launch
                </a>
            </div>

            <div class="mt-8 border-t border-white/10 pt-12 w-full max-w-5xl">
                <p class="text-sm font-medium text-slate-400 mb-8 tracking-wide uppercase">Built for</p>
                <div class="flex flex-wrap justify-center gap-6 md:gap-12 opacity-80">
                    <span class="text-lg font-bold text-white">First-time Entrepreneurs</span>
                    <span class="text-lg font-bold text-white">Small Business Owners</span>
                    <span class="text-lg font-bold text-white">Side Hustlers</span>
                    <span class="text-lg font-bold text-white">Freelancers</span>
                    <span class="text-lg font-bold text-white">Student Entrepreneurs</span>
                </div>
            </div>
        </div>
    </section>

    {{-- The Problem --}}
    <section id="problem" class="py-32 bg-white relative border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="inline-flex items-center justify-center rounded-full border-2 border-red-100 bg-red-50 px-6 py-2 font-bold text-xs uppercase tracking-widest mb-6 shadow-sm">
                        <p class="text-red-600">The Problem</p>
                    </div>
                    <h2 class="text-4xl font-bold text-slate-900 sm:text-5xl tracking-tight leading-[1.1] mb-6">
                        Starting a business is still too difficult.
                    </h2>
                    <div class="space-y-6 text-xl text-slate-600 leading-relaxed font-medium">
                        <p>Many people want to start a business, but they get stuck because the process is scattered.</p>
                        <p>You need business registration, branding, a website, social media designs, and payment setups. But dealing with different vendors means unclear pricing, slow delivery, and poor-quality execution.</p>
                        <p>Because these services are scattered, business owners waste time, spend too much money, and still end up with a weak launch. Many start without a clear identity or digital presence, making it harder for customers to trust them.</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-red-50 rounded-[40px] opacity-50 blur-lg"></div>
                    <div class="bg-white border border-slate-100 shadow-2xl rounded-3xl p-10 relative z-10">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6">The struggle of a new founder:</h3>
                        <ul class="space-y-4">
                            @foreach([
                                'Registering the business properly',
                                'Creating a professional brand identity',
                                'Building a website or landing page',
                                'Setting up social media pages',
                                'Designing launch materials',
                                'Setting up digital payment channels',
                                'Knowing how to announce and promote'
                            ] as $struggle)
                                <li class="flex items-start gap-4">
                                    <div class="mt-1 bg-red-100 text-red-600 rounded-full p-1 flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </div>
                                    <span class="text-lg text-slate-700 font-medium">{{ $struggle }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- The Solution (Core Offer) --}}
    <section id="services" class="bg-[#F9FAFB] py-32 relative">
        <div class="mx-auto max-w-7xl px-6 relative z-10">
            <div class="text-center mb-24">
                <div class="inline-flex items-center justify-center rounded-full border-2 border-emerald-100 bg-emerald-50 px-6 py-2 font-bold text-xs uppercase tracking-widest mb-6 shadow-sm">
                    <p class="text-emerald-600">The Solution</p>
                </div>
                <h2 class="text-4xl font-bold text-slate-900 sm:text-5xl md:text-[64px] tracking-tight leading-[1.1]">
                    Everything you need to <br />
                    <span class="text-brand-600">launch strongly.</span>
                </h2>
                <p class="mt-8 text-xl text-slate-600 max-w-3xl mx-auto font-medium leading-relaxed">
                    Launchio solves this by giving businesses a complete launch kit. We are not just a design service or a registration service. We are a business launch system.
                </p>
            </div>

            <div class="space-y-24 mt-16">
                @foreach ([
                    ['title' => 'Business Setup', 'color' => '#155DFC', 'bg' => '#E0E7FF', 'scope' => 'Business registration guidance, name support, basic compliance, and foundational documents.', 'img' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80'],
                    ['title' => 'Brand Identity', 'color' => '#FF6900', 'bg' => '#FFEDD5', 'scope' => 'Clear and credible visual identity including logo, colors, fonts, and a simple brand guide.', 'img' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=800&q=80'],
                    ['title' => 'Digital Presence', 'color' => '#059669', 'bg' => '#D1FAE5', 'scope' => 'Websites, landing pages, official email, Google Business Profile, and WhatsApp Business setup.', 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80'],
                    ['title' => 'Marketing Assets', 'color' => '#E7000B', 'bg' => '#FEE2E2', 'scope' => 'Launch flyers, social media templates, announcement posts, and promotional graphics.', 'img' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=800&q=80'],
                    ['title' => 'Growth Support', 'color' => '#8B5CF6', 'bg' => '#EDE9FE', 'scope' => 'Content planning, lead generation, basic ads setup, and monthly digital growth support.', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80']
                ] as $index => $pillar)
                    <div class="grid lg:grid-cols-2 gap-16 items-center group">
                        <!-- Image Card side -->
                        <div class="relative {{ $index % 2 !== 0 ? 'lg:order-last' : '' }}">
                            <div class="absolute -inset-4 bg-gradient-to-r from-slate-200 to-slate-100 rounded-[40px] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="rounded-3xl overflow-hidden shadow-2xl relative h-[400px] transform transition-transform duration-700 group-hover:scale-[1.02]">
                                <img src="{{ $pillar['img'] }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $pillar['title'] }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                                
                                <div class="absolute bottom-8 left-8 right-8">
                                    <div class="inline-block px-4 py-1 rounded-full mb-3 text-xs font-bold uppercase tracking-widest text-white shadow-lg" style="background-color: {{ $pillar['color'] }}">
                                        Pillar {{ $index + 1 }}
                                    </div>
                                    <h3 class="text-3xl font-bold text-white">{{ $pillar['title'] }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Details side -->
                        <div class="relative z-10">
                            <div class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-2 font-bold text-xs uppercase tracking-widest mb-8 shadow-sm">
                                <span class="text-slate-900">{{ $pillar['title'] }} Solutions</span>
                            </div>
                            
                            <p class="text-2xl text-slate-600 leading-relaxed font-medium">{{ $pillar['scope'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-32 bg-white relative border-y border-slate-200/60">
        <div class="mx-auto max-w-7xl px-6">
            <div class="text-center mb-24">
                <div class="inline-flex items-center justify-center rounded-full border-2 border-slate-200 bg-slate-50 px-6 py-2 font-bold text-xs uppercase tracking-widest mb-6">
                    <p class="text-slate-600">The Process</p>
                </div>
                <h2 class="text-4xl font-bold text-slate-900 sm:text-5xl md:text-[56px] tracking-tight leading-[1.1]">
                    How Launchio Works
                </h2>
            </div>

            <div class="grid md:grid-cols-2 gap-10 max-w-5xl mx-auto">
                @foreach ([
                    ['step' => '1', 'title' => 'Describe Your Business', 'desc' => 'Provide basic information about your idea, audience, and goals.'],
                    ['step' => '2', 'title' => 'Choose a Package', 'desc' => 'Select the launch kit that fits your stage, from basic to premium.'],
                    ['step' => '3', 'title' => 'We Build Your Kit', 'desc' => 'We prepare your registration, brand, website, and marketing.'],
                    ['step' => '4', 'title' => 'Review & Approve', 'desc' => 'Review your materials, request adjustments, and approve.'],
                    ['step' => '5', 'title' => 'Go Live & Sell', 'desc' => 'Launch with a professional identity and online presence.']
                ] as $index => $step)
                    <div class="relative bg-slate-50 rounded-3xl p-8 border border-slate-100 flex items-start gap-6 hover:-translate-y-1 transition-transform duration-300 {{ $index === 4 ? 'md:col-span-2 md:w-1/2 md:justify-self-center md:flex-col md:items-center md:text-center' : '' }}">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-2xl font-bold text-brand-600 shadow-sm border border-slate-100 flex-shrink-0">
                            {{ $step['step'] }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $step['title'] }}</h3>
                            <p class="text-slate-600 font-medium leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Packages --}}
    <section id="packages" class="py-32 bg-[#F9FAFB] relative">
        <div class="mx-auto max-w-7xl px-6">
            <div class="text-center mb-24">
                <div class="inline-flex items-center justify-center rounded-full border-2 border-brand-100 bg-brand-50 px-6 py-2 font-bold text-xs uppercase tracking-widest mb-6">
                    <p class="text-brand-600">Launch Packages</p>
                </div>
                <h2 class="text-4xl font-bold text-slate-900 sm:text-5xl md:text-[64px] tracking-tight leading-[1.1]">Pricing</h2>
            </div>
            
            <div class="grid gap-8 lg:grid-cols-4 sm:grid-cols-2">
                @foreach ($packages as $package)
                    <div class="relative flex flex-col rounded-[32px] border {{ $package->most_popular ? 'border-brand-600 shadow-[0_20px_50px_-12px_rgba(37,99,235,0.15)]' : 'border-slate-200 shadow-sm' }} bg-white p-8 transition-transform hover:-translate-y-2 duration-300">
                        @if ($package->most_popular)
                            <div class="absolute -top-5 left-1/2 -translate-x-1/2 rounded-full bg-brand-600 px-5 py-2 text-xs font-bold uppercase tracking-widest text-white shadow-xl whitespace-nowrap">
                                Most Popular
                            </div>
                        @endif
                        <h3 class="text-3xl font-bold text-slate-900 mt-4">{{ $package->name }}</h3>
                        <p class="mt-3 text-sm text-slate-500 min-h-[60px] font-medium leading-relaxed">{{ $package->tagline }}</p>
                        
                        <div class="my-6 border-t border-slate-100 pt-6">
                            <p class="text-4xl font-bold text-slate-900 tracking-tight">
                                ₦{{ number_format($package->price_one_time) }}
                            </p>
                            @if ($package->is_recurring)
                                <p class="mt-2 text-sm font-bold text-brand-600 bg-brand-600/10 inline-block px-3 py-1 rounded-full">+ ₦{{ number_format($package->price_recurring) }}/mo</p>
                            @else
                                <p class="mt-2 text-sm text-slate-400 font-medium">One-time payment</p>
                            @endif
                        </div>
                        
                        <ul class="space-y-4 mb-10 flex-1">
                            @foreach ($package->features as $feature)
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-brand-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <span class="text-sm font-medium text-slate-700">{{ $feature->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                        
                        <a href="{{ route('get-started') }}?package={{ $package->id }}" class="w-full rounded-2xl border-2 {{ $package->most_popular ? 'border-brand-600 bg-brand-600 text-white hover:bg-brand-700' : 'border-slate-200 bg-white text-slate-900 hover:border-slate-900 hover:bg-slate-900 hover:text-white' }} px-4 py-4 text-center text-sm font-bold transition-all shadow-sm hover:shadow-md">
                            Choose {{ $package->name }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Blog Section --}}
    <section id="blog" class="py-32 bg-white relative">
        <div class="mx-auto max-w-7xl px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
                <div>
                    <div class="inline-flex items-center justify-center rounded-full border-2 border-slate-200 bg-slate-50 px-6 py-2 font-bold text-xs uppercase tracking-widest mb-6">
                        <p class="text-slate-600">Latest Insights</p>
                    </div>
                    <h2 class="text-4xl font-bold text-slate-900 sm:text-5xl tracking-tight">The Launchio Blog</h2>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="group flex flex-col bg-slate-50 rounded-[24px] border border-slate-100 overflow-hidden hover:shadow-xl hover:border-slate-200 transition-all duration-300">
                        @if($post->cover_image)
                            <div class="aspect-video w-full overflow-hidden bg-slate-200">
                                <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="aspect-video w-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                            </div>
                        @endif
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center gap-3 text-sm text-slate-500 font-medium mb-4">
                                <time datetime="{{ $post->published_at->format('Y-m-d') }}">{{ $post->published_at->format('M d, Y') }}</time>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">{{ $post->title }}</h3>
                            <p class="text-slate-600 font-medium line-clamp-3 mb-6">{{ $post->excerpt }}</p>
                            <div class="mt-auto flex items-center text-brand-600 font-bold text-sm">
                                Read article <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-12 bg-slate-50 rounded-3xl border border-slate-100">
                        <p class="text-slate-500 font-medium">New articles are being written! Check back soon.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Future Vision / Roadmap --}}
    <section class="py-32 bg-slate-900 relative overflow-hidden border-t border-slate-800">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="mx-auto max-w-7xl px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-white sm:text-5xl tracking-tight leading-[1.1] mb-6">
                        Building the future of business operations.
                    </h2>
                    <p class="text-xl text-slate-400 leading-relaxed font-medium mb-8">
                        Launchio is growing from a launch platform into a full business operating platform. We are currently building automated tools to help you scale effortlessly.
                    </p>
                    <ul class="space-y-4 mb-10">
                        @foreach([
                            'AI Business Idea Assistant',
                            'Automated Business Plan Generator',
                            'Automated Website Builder',
                            'AI Content & Social Generator',
                            'CRM and Customer Follow-up System'
                        ] as $future)
                            <li class="flex items-center gap-4 text-slate-300 font-medium text-lg">
                                <div class="bg-slate-800 rounded-full p-2">
                                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                {{ $future }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('get-started') }}" class="inline-flex items-center gap-2 text-brand-400 hover:text-brand-300 font-bold text-lg transition-colors">
                        Launch your business with us today <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
                <div class="relative">
                    <div class="aspect-square bg-gradient-to-tr from-brand-600/20 to-purple-600/20 rounded-full blur-3xl absolute -inset-10"></div>
                    <div class="bg-slate-800 border border-slate-700 rounded-3xl p-8 relative shadow-2xl">
                        <div class="flex justify-center border-b border-slate-700 pb-8 mb-6 animate-bounce">
                            <img src="{{ asset('logo.png') }}" alt="Launchio" class="h-24 md:h-32 w-auto filter brightness-0 invert drop-shadow-[0_0_15px_rgba(255,255,255,0.2)]">
                        </div>
                        <p class="text-slate-400 italic">"Instead of a business owner looking for a lawyer, designer, developer, social media manager, and marketer separately, Launchio brings the full launch process into one place."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.marketing>

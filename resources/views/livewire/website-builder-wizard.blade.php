<div class="max-w-4xl mx-auto py-10">
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm font-semibold text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm font-semibold text-rose-800 rounded-xl bg-rose-50 border border-rose-200 shadow-sm" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full z-0"></div>
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-indigo-600 rounded-full z-0 transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
            
            @for ($i = 1; $i <= $totalSteps; $i++)
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold {{ $currentStep >= $i ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        {{ $i }}
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        
        <!-- Step 1: Choose Website Type -->
        @if ($currentStep == 1)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">What type of website do you want?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(['Landing Page', 'Business Website', 'Ecommerce Store', 'Portfolio', 'Personal Website', 'Blog', 'Restaurant Website', 'Real Estate Website', 'Custom Website'] as $typeOption)
                        <label class="relative flex cursor-pointer rounded-xl border {{ $type === $typeOption ? 'border-indigo-600 bg-indigo-50 ring-2 ring-indigo-600' : 'border-gray-200 bg-white hover:border-indigo-300' }} p-5 shadow-sm transition-all">
                            <input type="radio" wire:model.live="type" value="{{ $typeOption }}" class="sr-only" />
                            <span class="flex flex-col">
                                <span class="block text-lg font-semibold {{ $type === $typeOption ? 'text-indigo-900' : 'text-gray-900' }}">{{ $typeOption }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('type') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>
        @endif

        <!-- Step 2: Website Information -->
        @if ($currentStep == 2)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Tell us about your business</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Business Name</label>
                        <input type="text" wire:model="businessName" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Website Name (Optional)</label>
                        <input type="text" wire:model="websiteName" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tagline</label>
                        <input type="text" wire:model="tagline" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Business Description</label>
                        <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Industry</label>
                        <select wire:model="industry" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4">
                            <option value="">Select Industry</option>
                            <option value="Technology">Technology</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Education">Education</option>
                            <option value="Finance">Finance</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 3: Domain -->
        @if ($currentStep == 3)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Let's set up your domain</h2>
                <div class="space-y-4">
                    <label class="flex items-center p-4 border rounded-xl hover:bg-gray-50 cursor-pointer">
                        <input type="radio" wire:model.live="domainChoice" value="own" class="h-5 w-5 text-indigo-600">
                        <span class="ml-3 font-medium">I already own a domain</span>
                    </label>
                    <label class="flex items-center p-4 border rounded-xl hover:bg-gray-50 cursor-pointer">
                        <input type="radio" wire:model.live="domainChoice" value="register" class="h-5 w-5 text-indigo-600">
                        <span class="ml-3 font-medium">Register a new domain</span>
                    </label>
                </div>
                
                @if($domainChoice)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Enter Domain Name</label>
                        <input type="text" wire:model="domainName" placeholder="example.com" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4">
                    </div>
                @endif
            </div>
        @endif

        <!-- Step 4: Hosting -->
        @if ($currentStep == 4)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Where will your site live?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative flex cursor-pointer rounded-xl border p-6 hover:bg-indigo-50">
                        <input type="radio" wire:model="hostingChoice" value="launchio" class="sr-only" />
                        <span class="flex flex-col">
                            <span class="text-xl font-bold text-gray-900">Launchio Hosting</span>
                            <span class="text-sm text-gray-500 mt-2">Fast, secure, and optimized for your business.</span>
                        </span>
                    </label>
                    <label class="relative flex cursor-pointer rounded-xl border p-6 hover:bg-gray-50">
                        <input type="radio" wire:model="hostingChoice" value="own" class="sr-only" />
                        <span class="flex flex-col">
                            <span class="text-xl font-bold text-gray-900">Use My Own Hosting</span>
                            <span class="text-sm text-gray-500 mt-2">I have my own servers or hosting provider.</span>
                        </span>
                    </label>
                </div>
            </div>
        @endif

        <!-- Step 5: Pages -->
        @if ($currentStep == 5)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Select pages for your site</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach(['Home', 'About', 'Services', 'Products', 'Portfolio', 'Testimonials', 'Pricing', 'Gallery', 'Blog', 'FAQ', 'Contact', 'Privacy Policy'] as $pageOption)
                        <label class="flex items-center space-x-3 bg-gray-50 p-4 rounded-xl cursor-pointer hover:bg-gray-100 transition">
                            <input type="checkbox" wire:model="selectedPages" value="{{ $pageOption }}" class="h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                            <span class="text-gray-900 font-medium">{{ $pageOption }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Step 6: Style -->
        @if ($currentStep == 6)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Choose your aesthetic</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['Minimal', 'Corporate', 'Luxury', 'Dark', 'Modern', 'Creative', 'Classic', 'Bold'] as $styleOption)
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="themeStyle" value="{{ $styleOption }}" class="sr-only" />
                            <div class="{{ $themeStyle === $styleOption ? 'border-indigo-600 ring-2 ring-indigo-600' : 'border-gray-200 hover:border-indigo-300' }} border-2 rounded-xl p-4 text-center transition">
                                <div class="h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg mb-3"></div>
                                <span class="font-bold text-gray-800">{{ $styleOption }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Step 7: Features -->
        @if ($currentStep == 7)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Enable powerful features</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach(['Live Chat', 'Contact Form', 'Newsletter', 'Booking', 'WhatsApp Chat', 'Google Maps', 'Blog', 'Reviews', 'Analytics', 'SEO', 'Search'] as $featureOption)
                        <label class="flex items-center space-x-3 bg-white border p-4 rounded-xl cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition">
                            <input type="checkbox" wire:model="selectedFeatures" value="{{ $featureOption }}" class="h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                            <span class="text-gray-900 font-medium">{{ $featureOption }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Step 8: AI Assistant -->
        @if ($currentStep == 8)
            <div>
                <h2 class="text-3xl font-bold text-indigo-600 mb-6 tracking-tight flex items-center">
                    <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Let AI build your dream website
                </h2>
                <p class="text-gray-600 mb-4 text-lg">Describe the website you want in detail, and Launchio's AI will configure the pages, styles, and content for you.</p>
                <textarea wire:model="aiPrompt" rows="6" placeholder="I need a modern ecommerce website selling shoes with black and gold branding..." class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-6 text-lg"></textarea>
                
                <div class="mt-6">
                    <button wire:click="generateWithAI" class="bg-indigo-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-indigo-700 transition shadow-lg flex items-center">
                        Generate Magic
                    </button>
                </div>
            </div>
        @endif

        <!-- Step 9: Final Review -->
        @if ($currentStep == 9)
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 tracking-tight">Final Review</h2>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <ul class="space-y-4">
                        <li class="flex justify-between border-b pb-2"><span class="text-gray-500 font-medium">Type</span> <span class="font-bold text-gray-900">{{ $type }}</span></li>
                        <li class="flex justify-between border-b pb-2"><span class="text-gray-500 font-medium">Name</span> <span class="font-bold text-gray-900">{{ $websiteName ?: $businessName }}</span></li>
                        <li class="flex justify-between border-b pb-2"><span class="text-gray-500 font-medium">Theme Style</span> <span class="font-bold text-gray-900">{{ $themeStyle }}</span></li>
                        <li class="flex justify-between border-b pb-2"><span class="text-gray-500 font-medium">Pages</span> <span class="font-bold text-gray-900">{{ count($selectedPages) }} selected</span></li>
                        <li class="flex justify-between border-b pb-2"><span class="text-gray-500 font-medium">Features</span> <span class="font-bold text-gray-900">{{ count($selectedFeatures) }} selected</span></li>
                    </ul>
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="mt-10 flex justify-between pt-6 border-t border-gray-100">
            @if ($currentStep > 1 && $currentStep < 9)
                <button wire:click="previousStep" class="px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 transition">
                    Back
                </button>
            @else
                <div></div> <!-- Empty div for flex spacing -->
            @endif

            @if ($currentStep < $totalSteps)
                <button wire:click="nextStep" class="px-8 py-3 border border-transparent text-base font-bold rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    Next Step
                </button>
            @elseif ($currentStep == 8)
                <button wire:click="nextStep" class="px-8 py-3 border border-transparent text-base font-bold rounded-full shadow-sm text-white bg-gray-900 hover:bg-black transition">
                    Skip AI & Review
                </button>
            @elseif ($currentStep == 9)
                <button wire:click="submit" class="px-8 py-3 border border-transparent text-base font-bold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 transition transform hover:scale-105">
                    Publish Website
                </button>
            @endif
        </div>
        
    </div>
</div>

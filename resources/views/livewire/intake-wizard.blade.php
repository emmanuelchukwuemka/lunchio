<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Progress Header -->
        <div class="bg-brand-50 px-8 py-6 border-b border-brand-100 relative">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-2xl font-bold text-brand-900">Start Your Launch</h2>
                <a href="{{ route('ai-onboarding') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white text-sm font-semibold rounded-lg hover:bg-slate-800 transition-colors shadow-sm border border-slate-700">
                    <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Switch to AI Intake
                </a>
            </div>
            
            <div class="relative">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-brand-200">
                    <div style="width: {{ ($currentStep / $totalSteps) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-brand-600 transition-all duration-500"></div>
                </div>
                <div class="flex justify-between text-xs font-semibold text-brand-700">
                    <span class="{{ $currentStep >= 1 ? 'text-brand-900' : '' }}">Package</span>
                    <span class="{{ $currentStep >= 2 ? 'text-brand-900' : '' }}">Business Info</span>
                    <span class="{{ $currentStep >= 3 ? 'text-brand-900' : '' }}">Target</span>
                    <span class="{{ $currentStep >= 4 ? 'text-brand-900' : '' }}">Assets & Review</span>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="submit" class="p-8">
            <!-- Step 1: Package & Basic Info -->
            @if ($currentStep === 1)
                <div class="space-y-6 animate-fade-in-up">
                    <h3 class="text-xl font-semibold text-gray-900">Select Your Package & Basics</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select a Package</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($packages as $package)
                                <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:bg-gray-50 {{ $data['package_id'] == $package->id ? 'border-brand-500 ring-1 ring-brand-500' : 'border-gray-300' }}">
                                    <input type="radio" wire:model.live="data.package_id" value="{{ $package->id }}" class="sr-only">
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">{{ $package->name }}</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">{{ $package->price_formatted ?? '$'.number_format($package->price, 2) }}</span>
                                        </span>
                                    </span>
                                    @if($data['package_id'] == $package->id)
                                        <svg class="h-5 w-5 text-brand-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        @error('data.package_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700">Business Name</label>
                                <button type="button" wire:click="generateNameWithAi" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors bg-brand-50 hover:bg-brand-100 px-2.5 py-1 rounded-md">
                                    <svg wire:loading.remove wire:target="generateNameWithAi" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <svg wire:loading wire:target="generateNameWithAi" class="animate-spin w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span wire:loading.remove wire:target="generateNameWithAi">AI Aid</span>
                                    <span wire:loading wire:target="generateNameWithAi">Thinking...</span>
                                </button>
                            </div>
                            <input type="text" wire:model.live="data.business_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            @error('data.business_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700">Business Description</label>
                                <button type="button" wire:click="generateDescriptionWithAi" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors bg-brand-50 hover:bg-brand-100 px-2.5 py-1 rounded-md">
                                    <svg wire:loading.remove wire:target="generateDescriptionWithAi" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <svg wire:loading wire:target="generateDescriptionWithAi" class="animate-spin w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span wire:loading.remove wire:target="generateDescriptionWithAi">AI Aid</span>
                                    <span wire:loading wire:target="generateDescriptionWithAi">Thinking...</span>
                                </button>
                            </div>
                            <textarea wire:model.live="data.business_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="Tell us what your business does..."></textarea>
                            @error('data.business_description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 2: Industry & Stage -->
            @if ($currentStep === 2)
                <div class="space-y-6 animate-fade-in-up">
                    <h3 class="text-xl font-semibold text-gray-900">Industry & Stage</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Industry</label>
                            <input type="text" wire:model.live="data.industry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="e.g. Technology, Real Estate, Consulting">
                            @error('data.industry') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Business Stage</label>
                            <select wire:model.live="data.business_stage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                <option value="">Select Stage...</option>
                                <option value="Idea">Just an Idea</option>
                                <option value="Pre-revenue">Pre-revenue / Building</option>
                                <option value="Generating Revenue">Generating Revenue</option>
                                <option value="Scaling">Scaling / Growth</option>
                            </select>
                            @error('data.business_stage') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 3: Target Audience -->
            @if ($currentStep === 3)
                <div class="space-y-6 animate-fade-in-up">
                    <h3 class="text-xl font-semibold text-gray-900">Target Audience</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Who is your ideal customer?</label>
                            <textarea wire:model.live="data.target_audience" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="Describe their demographics, interests, pain points..."></textarea>
                            @error('data.target_audience') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location / Operational Area</label>
                            <input type="text" wire:model.live="data.location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="e.g. Global, Nigeria, Lagos specifically">
                            @error('data.location') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 4: Assets & Review -->
            @if ($currentStep === 4)
                <div class="space-y-6 animate-fade-in-up">
                    <h3 class="text-xl font-semibold text-gray-900">Existing Assets</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2 text-sm font-medium text-gray-700 cursor-pointer">
                                <input type="checkbox" wire:model.live="data.has_logo" class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                                <span>I already have a logo</span>
                            </label>

                            <label class="flex items-center space-x-2 text-sm font-medium text-gray-700 cursor-pointer">
                                <input type="checkbox" wire:model.live="data.has_website" class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                                <span>I already have a website</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asset Notes (Links to existing folders, websites, etc.)</label>
                            <textarea wire:model.live="data.existing_assets_notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="Any links or notes..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Upload Files (Brand guidelines, mockups, etc.)</label>
                            <input type="file" wire:model="existingAsset" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                            <div wire:loading wire:target="existingAsset" class="text-sm text-brand-600 mt-2">Uploading...</div>
                            @error('existingAsset') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
                @if ($currentStep > 1)
                    <button type="button" wire:click="previousStep" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        Back
                    </button>
                @else
                    <div></div>
                @endif

                @if ($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep" class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        Next Step
                    </button>
                @else
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        <span wire:loading.remove wire:target="submit">Submit & Proceed to Checkout</span>
                        <span wire:loading wire:target="submit">Processing...</span>
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

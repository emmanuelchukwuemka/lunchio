<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-brand-900 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">Complete Your Order</h3>
                        <p class="text-gray-500 mt-2">You're one step away from launching your business.</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-100">
                        <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">{{ $order->package->name }} Package</h4>
                                <p class="text-sm text-gray-500">Order #{{ $order->reference }} &mdash; {{ $order->business_name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-gray-900">${{ number_format($order->package->price, 2) }}</span>
                                <span class="block text-xs text-gray-500">USD</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            @foreach($order->package->features as $feature)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="h-4 w-4 text-brand-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $feature->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form action="{{ route('checkout.process', $order) }}" method="POST">
                        @csrf
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md mb-8">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        This is a simulated checkout. Click the button below to mock a successful payment and proceed to your dashboard.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                            Pay ${{ number_format($order->package->price, 2) }} securely
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-gray-500 flex items-center justify-center">
                            <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Payments are securely processed. No data is stored on our servers.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

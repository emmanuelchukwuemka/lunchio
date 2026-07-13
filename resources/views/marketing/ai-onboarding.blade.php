<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Onboarding | {{ config('app.name', 'Launchio') }}</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|sora:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Sora', sans-serif; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #E2E8F0; border-radius: 10px; }
    </style>
</head>
<body class="bg-white text-slate-900 min-h-screen flex flex-col overflow-hidden selection:bg-brand-100 selection:text-brand-900" x-data="aiOnboarding()">
    
    <!-- Top Navigation (Minimal) -->
    <nav class="absolute top-0 left-0 right-0 z-50 px-6 py-5 flex items-center justify-between bg-gradient-to-b from-white/80 to-transparent">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center shadow-sm shadow-brand-500/20 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <span class="font-sora font-bold text-xl tracking-tight text-slate-900 group-hover:text-brand-600 transition-colors">Launchio</span>
        </a>
        <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">
            Cancel
        </a>
    </nav>

    <!-- Chat Interface (Immersive Full Page) -->
    <main class="flex-1 flex flex-col h-screen pt-20 pb-[120px] relative">
        
        <div class="flex-1 overflow-y-auto custom-scrollbar" id="chat-container">
            <div class="max-w-3xl mx-auto w-full flex flex-col">
                
                <!-- Intro Header -->
                <div class="text-center py-16 px-6 animate-fade-in-up">
                    <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-slate-900 mb-4">How can I help you launch?</h1>
                    <p class="text-lg text-slate-500 font-light max-w-xl mx-auto">I'm your Launchio AI. Tell me about the business you're building, and I'll tailor the perfect setup for you.</p>
                </div>

                <!-- Messages -->
                <div class="flex flex-col pb-10">
                    
                    <template x-for="(msg, index) in messages" :key="index">
                        <div class="group px-6 py-8 transition-colors" :class="msg.role === 'user' ? 'bg-white' : 'bg-slate-50/80 border-y border-slate-100/50'">
                            <div class="max-w-3xl mx-auto flex gap-6 items-start">
                                
                                <!-- Avatar -->
                                <div class="w-8 h-8 rounded-md flex-shrink-0 flex items-center justify-center mt-1" :class="msg.role === 'user' ? 'bg-slate-100 text-slate-500' : 'bg-brand-600 text-white shadow-sm shadow-brand-500/20'">
                                    <template x-if="msg.role === 'user'">
                                        <span class="text-xs font-bold uppercase">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                                    </template>
                                    <template x-if="msg.role === 'ai'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </template>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 prose prose-slate max-w-none text-slate-700 leading-relaxed text-[15px]">
                                    <span x-html="formatMessage(msg.content)"></span>
                                    
                                    <template x-if="msg.checkout_url">
                                        <div class="mt-8 not-prose">
                                            <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                                                <div class="flex items-center gap-4 mb-5">
                                                    <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600">
                                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-sora font-semibold text-slate-900 text-lg">Recommended Setup</h4>
                                                        <p class="text-sm text-slate-500">Based on your business model</p>
                                                    </div>
                                                </div>
                                                <a :href="msg.checkout_url" class="flex w-full items-center justify-center gap-2 px-6 py-3.5 bg-slate-900 text-white font-medium rounded-xl hover:bg-slate-800 transition-all shadow-sm group">
                                                    Continue to Checkout 
                                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <!-- Loading Indicator -->
                    <div x-show="loading" class="px-6 py-8 bg-slate-50/80 border-y border-slate-100/50">
                        <div class="max-w-3xl mx-auto flex gap-6 items-start">
                            <div class="w-8 h-8 rounded-md bg-brand-600 flex-shrink-0 flex items-center justify-center text-white shadow-sm shadow-brand-500/20 mt-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div class="flex-1 flex items-center h-10 gap-1.5">
                                <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Floating Input Area -->
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-white via-white to-transparent pt-10 pb-8 px-4">
            <div class="max-w-3xl mx-auto relative">
                <form @submit.prevent="sendMessage" class="relative flex items-center bg-white border border-slate-200/80 shadow-lg shadow-slate-200/40 rounded-2xl overflow-hidden focus-within:ring-2 focus-within:ring-brand-500/20 focus-within:border-brand-500 transition-all">
                    <input type="text" x-model="inputText" placeholder="E.g. I want to start an eco-friendly cleaning service..." class="w-full pl-6 pr-16 py-4 border-none bg-transparent focus:ring-0 text-slate-900 placeholder-slate-400 text-[15px]" :disabled="loading || isComplete">
                    
                    <button type="submit" class="absolute right-2 p-2 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition-colors disabled:opacity-30 disabled:hover:bg-brand-600" :disabled="!inputText.trim() || loading || isComplete">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" /></svg>
                    </button>
                </form>
                <div class="text-center mt-3" x-show="!isComplete">
                    <p class="text-[11px] text-slate-400 font-medium tracking-wide uppercase">AI can make mistakes. Verify important information.</p>
                </div>
            </div>
        </div>
        
    </main>

    <script>
        function aiOnboarding() {
            return {
                messages: [],
                inputText: '',
                loading: false,
                step: 1,
                isComplete: false,
                
                scrollToBottom() {
                    setTimeout(() => {
                        const container = document.getElementById('chat-container');
                        container.scrollTop = container.scrollHeight;
                    }, 50);
                },

                formatMessage(text) {
                    return text.replace(/\*\*(.*?)\*\*/g, '<strong class="font-semibold text-slate-900">$1</strong>')
                               .replace(/\n/g, '<br>');
                },

                async sendMessage() {
                    if (!this.inputText.trim() || this.loading || this.isComplete) return;
                    
                    const userMsg = this.inputText.trim();
                    this.messages.push({ role: 'user', content: userMsg });
                    this.inputText = '';
                    this.loading = true;
                    
                    // Remove intro header if it's the first message to give chat full focus
                    const intro = document.querySelector('.animate-fade-in-up');
                    if(intro) intro.style.display = 'none';

                    this.scrollToBottom();

                    try {
                        const response = await fetch('{{ route('ai-onboarding.chat') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ message: userMsg, step: this.step })
                        });
                        
                        const data = await response.json();
                        
                        this.loading = false;
                        this.messages.push({ 
                            role: 'ai', 
                            content: data.reply,
                            checkout_url: data.checkout_url ?? null 
                        });
                        
                        this.step = data.next_step;
                        if (data.checkout_url) {
                            this.isComplete = true;
                        }
                        
                        this.scrollToBottom();
                        
                    } catch (error) {
                        this.loading = false;
                        this.messages.push({ role: 'ai', content: 'Sorry, I encountered an error. Please try again.' });
                        this.scrollToBottom();
                    }
                }
            }
        }
    </script>
</body>
</html>

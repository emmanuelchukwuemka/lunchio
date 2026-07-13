<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight flex items-center gap-3">
            <svg class="w-8 h-8 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            {{ __('AI Launch Copilot') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="copilotChat()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 h-[calc(100vh-200px)] min-h-[600px] flex flex-col">
            
            <!-- Chat Window -->
            <div class="flex-1 bg-white rounded-t-3xl shadow-sm border border-slate-200 flex flex-col overflow-hidden relative">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Idea Assistant</h3>
                            <p class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50/50" id="chat-container">
                    
                    <!-- Welcome Message -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-brand-100 flex-shrink-0 flex items-center justify-center text-brand-600 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm px-5 py-3 shadow-sm max-w-[80%] text-slate-700 text-sm leading-relaxed">
                            <p>Hi {{ explode(' ', Auth::user()->name)[0] }}! I'm your AI Launch Copilot.</p>
                            <p class="mt-2">I can help you brainstorm business names, create a quick 1-page business plan, generate a brand kit, draft legal documents, or analyze your competitors. What are you working on today?</p>
                            
                            <div class="mt-4 flex flex-wrap gap-2">
                                <button @click="sendSuggestion('Help me generate a 1-page business plan for my idea.')" class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 rounded-lg text-xs font-medium transition-colors border border-brand-200">
                                    Generate Business Plan
                                </button>
                                <button @click="sendSuggestion('Can you suggest 5 creative business names for my industry?')" class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 rounded-lg text-xs font-medium transition-colors border border-brand-200">
                                    Brainstorm Names
                                </button>
                                <button @click="sendSuggestion('Create a brand kit with colors and fonts for my business.')" class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 rounded-lg text-xs font-medium transition-colors border border-brand-200">
                                    Generate Brand Kit
                                </button>
                                <button @click="sendSuggestion('Draft a basic privacy policy document.')" class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 rounded-lg text-xs font-medium transition-colors border border-brand-200">
                                    Draft Document
                                </button>
                                <button @click="sendSuggestion('Give me a quick competitor and market analysis.')" class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-700 rounded-lg text-xs font-medium transition-colors border border-brand-200">
                                    Analyze Competitors
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <template x-for="(msg, index) in messages" :key="index">
                        <div class="flex gap-4" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                            
                            <!-- Avatar -->
                            <div class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center mt-1" :class="msg.role === 'user' ? 'bg-slate-200 text-slate-600' : 'bg-brand-100 text-brand-600'">
                                <template x-if="msg.role === 'user'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </template>
                                <template x-if="msg.role === 'ai'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </template>
                            </div>

                            <!-- Bubble -->
                            <div class="rounded-2xl px-5 py-3 shadow-sm max-w-[80%] text-sm leading-relaxed whitespace-pre-wrap"
                                 :class="msg.role === 'user' ? 'bg-brand-600 text-white rounded-tr-sm' : 'bg-white border border-slate-200 text-slate-700 rounded-tl-sm'"
                                 x-text="msg.content">
                            </div>
                        </div>
                    </template>
                    
                    <!-- Loading Indicator -->
                    <div x-show="loading" class="flex gap-4">
                        <div class="w-8 h-8 rounded-full bg-brand-100 flex-shrink-0 flex items-center justify-center text-brand-600 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm px-5 py-4 shadow-sm flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-bounce"></div>
                            <div class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <!-- Input Area -->
            <div class="bg-white p-4 rounded-b-3xl shadow-sm border-x border-b border-slate-200">
                <form @submit.prevent="sendMessage" class="relative flex items-center">
                    <input type="text" x-model="inputText" placeholder="Ask the copilot something..." class="w-full pl-5 pr-14 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-slate-700 placeholder-slate-400 text-sm transition-all" :disabled="loading">
                    
                    <button type="submit" class="absolute right-3 p-2 bg-brand-600 text-white rounded-xl hover:bg-brand-700 transition-colors disabled:opacity-50" :disabled="!inputText.trim() || loading">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
            
        </div>
    </div>

    <script>
        function copilotChat() {
            return {
                messages: [],
                inputText: '',
                loading: false,
                
                sendSuggestion(text) {
                    this.inputText = text;
                    this.sendMessage();
                },
                
                scrollToBottom() {
                    setTimeout(() => {
                        const container = document.getElementById('chat-container');
                        container.scrollTop = container.scrollHeight;
                    }, 50);
                },

                async sendMessage() {
                    if (!this.inputText.trim() || this.loading) return;
                    
                    const userMsg = this.inputText.trim();
                    this.messages.push({ role: 'user', content: userMsg });
                    this.inputText = '';
                    this.loading = true;
                    this.scrollToBottom();

                    try {
                        const response = await fetch('{{ route('copilot.chat') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ message: userMsg })
                        });
                        
                        const data = await response.json();
                        
                        this.loading = false;
                        this.messages.push({ role: 'ai', content: data.reply });
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
</x-app-layout>

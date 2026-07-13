@php
    $number = preg_replace('/\D/', '', config('services.whatsapp.number', ''));
    $message = urlencode('Hi Launchio, I\'d like to know more about your packages.');
@endphp

@if ($number)
    <a
        href="https://wa.me/{{ $number }}?text={{ $message }}"
        target="_blank"
        rel="noopener"
        class="fixed bottom-5 right-5 z-40 flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-3 text-white shadow-lg transition hover:brightness-95"
        aria-label="Chat with us on WhatsApp"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
            <path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.77.46 3.45 1.26 4.9L2 22l5.25-1.38a9.94 9.94 0 0 0 4.79 1.22h.01c5.52 0 10-4.48 10-10s-4.48-9.84-10.01-9.84Zm5.86 14.2c-.25.7-1.45 1.35-2 1.44-.5.08-1.15.11-1.86-.12-.43-.13-.98-.32-1.69-.62-2.97-1.28-4.9-4.27-5.05-4.47-.15-.2-1.2-1.6-1.2-3.05 0-1.46.77-2.17 1.04-2.47.27-.3.6-.37.8-.37.2 0 .4 0 .58.01.19.01.44-.07.68.53.25.6.85 2.07.92 2.22.07.15.12.33.02.53-.1.2-.15.32-.3.5-.15.18-.32.4-.45.53-.15.15-.31.32-.13.62.18.3.8 1.33 1.73 2.15 1.19 1.05 2.19 1.38 2.5 1.53.3.15.48.13.65-.08.18-.2.75-.87.95-1.17.2-.3.4-.25.65-.15.27.1 1.71.81 2 .96.3.15.5.22.57.35.08.13.08.75-.17 1.45Z"/>
        </svg>
        <span class="hidden text-sm font-semibold sm:inline">Chat on WhatsApp</span>
    </a>
@endif

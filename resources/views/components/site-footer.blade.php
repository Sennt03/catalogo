{{-- ── Síguenos ────────────────────────────────────────────────────────── --}}
<section id="redes" class="py-24 bg-white overflow-hidden">
    <div class="max-w-xl mx-auto px-6 text-center">
        <p class="text-xs font-bold uppercase tracking-widest text-pink-400 mb-3" data-reveal>Nuestras redes</p>
        <h2 class="text-4xl font-bold text-gray-900" data-reveal data-reveal-delay="80">Síguenos</h2>
        <p class="mt-3 text-gray-400 leading-relaxed" data-reveal data-reveal-delay="160">
            Mantente al día con nuestras últimas colecciones y ofertas especiales
        </p>

        <div class="mt-10 flex justify-center gap-4" data-reveal data-reveal-delay="240">

            {{-- Instagram --}}
            <a href="#" target="_blank" rel="noopener"
               class="group relative w-16 h-16 rounded-2xl flex items-center justify-center shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
               style="background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </a>

            {{-- Facebook --}}
            <a href="#" target="_blank" rel="noopener"
               class="w-16 h-16 rounded-2xl bg-[#1877F2] flex items-center justify-center shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>

            {{-- WhatsApp --}}
            <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener"
               class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
               style="background-color:#25D366;">
                <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                </svg>
            </a>

            {{-- TikTok --}}
            <a href="#" target="_blank" rel="noopener"
               class="w-16 h-16 rounded-2xl bg-gray-900 flex items-center justify-center shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.69a8.18 8.18 0 0 0 4.77 1.52V6.76a4.85 4.85 0 0 1-1-.07z"/>
                </svg>
            </a>

        </div>
    </div>
</section>

{{-- ── Footer bar ───────────────────────────────────────────────────────── --}}
<footer class="bg-gray-950">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">

            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                <svg class="w-7 h-7 text-pink-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span class="text-white font-bold text-lg">Bella Moda</span>
            </a>

            <nav class="flex flex-wrap justify-center gap-x-8 gap-y-2 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-pink-400 transition-colors">Inicio</a>
                <a href="{{ route('catalogo.index') }}" class="hover:text-pink-400 transition-colors">Catálogo</a>
                <a href="{{ route('home') }}#contacto" class="hover:text-pink-400 transition-colors">Contacto</a>
                <a href="{{ route('home') }}#ubicacion" class="hover:text-pink-400 transition-colors">Ubicación</a>
            </nav>

            <p class="text-gray-600 text-sm flex-shrink-0">© {{ date('Y') }} Bella Moda</p>
        </div>
    </div>
</footer>

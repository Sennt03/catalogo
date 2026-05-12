<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head', ['title' => 'Bella Moda'])
    <style>
        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(32px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hero-animate       { animation: heroFadeUp 0.8s cubic-bezier(0.16,1,0.3,1) both; }
        .hero-animate-delay { animation: heroFadeUp 0.8s cubic-bezier(0.16,1,0.3,1) 0.15s both; }
        .hero-animate-cta   { animation: heroFadeUp 0.8s cubic-bezier(0.16,1,0.3,1) 0.28s both; }
        .hero-animate-img   { animation: heroFadeUp 0.9s cubic-bezier(0.16,1,0.3,1) 0.1s both; }
    </style>
</head>
<style>
    /* Subtle dot-grid background */
    body {
        background-color: #fdf4f7;
        background-image: radial-gradient(circle, rgba(244,114,182,0.13) 1.5px, transparent 1.5px);
        background-size: 38px 38px;
    }
</style>
<body class="antialiased">
@include('partials.sparkles')

    {{-- Page wrapper: z-index:2 keeps content above the z-index:1 star layer --}}
    <div style="position:relative;z-index:2">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-sm border-b border-pink-100 transition-shadow duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <svg class="w-8 h-8 text-pink-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span class="text-xl font-bold text-gray-900">Bella Moda</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('catalogo.index') }}" class="font-semibold text-gray-900 hover:text-pink-500 transition-colors">Catálogo</a>
                <a href="#contacto" class="text-gray-500 hover:text-pink-500 transition-colors">Contacto</a>
                <a href="#ubicacion" class="text-gray-500 hover:text-pink-500 transition-colors">Ubicación</a>
                <a href="#redes" class="text-gray-500 hover:text-pink-500 transition-colors">Redes Sociales</a>
            </div>

            <a href="{{ route('catalogo.index') }}" class="text-gray-500 hover:text-pink-500 transition-colors">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </a>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="min-h-[calc(100vh-73px)] flex items-center" style="background: linear-gradient(135deg, #fce8ef 0%, #fdf4f7 50%, #fff0f5 100%);">
        <div class="max-w-7xl mx-auto px-6 py-16 w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <p class="hero-animate text-xs font-bold uppercase tracking-widest text-pink-400 mb-4">Nueva colección</p>
                <h1 class="hero-animate-delay text-5xl font-extrabold text-gray-900 leading-tight">
                    Elegancia y Estilo<br>
                    <span class="text-pink-500">Para Ti.</span>
                </h1>
                <p class="hero-animate-delay mt-6 text-gray-500 text-lg leading-relaxed max-w-md">
                    Descubre nuestra colección exclusiva de ropa femenina. Diseños únicos que realzan tu belleza natural y personalidad.
                </p>
                <div class="hero-animate-cta mt-8 flex items-center gap-4 flex-wrap">
                    <a href="{{ route('catalogo.index') }}" class="inline-flex items-center gap-2 bg-pink-500 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-pink-600 transition-all hover:shadow-lg hover:shadow-pink-200 active:scale-95">
                        Ver Catálogo
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                    <a href="#contacto" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-pink-500 transition-colors font-medium text-sm">
                        Contáctanos
                    </a>
                </div>
            </div>

            <div class="hero-animate-img flex justify-center">
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-0 bg-pink-300 rounded-3xl blur-3xl opacity-20 translate-y-4 scale-95"></div>
                    <div class="relative w-full aspect-square bg-gradient-to-br from-pink-200 to-rose-100 rounded-3xl flex items-center justify-center shadow-2xl shadow-pink-100">
                        <svg class="w-36 h-36 text-pink-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        {{-- Decorative floating badges --}}
                        <span class="absolute -top-3 -right-3 bg-white text-pink-500 text-xs font-bold px-3 py-1.5 rounded-full shadow-lg border border-pink-100">✨ Nueva colección</span>
                        <span class="absolute -bottom-3 -left-3 bg-pink-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">100% Exclusivo</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Feature Cards --}}
    <section class="py-20" style="background-color: #fdf4f7;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <a href="{{ route('catalogo.index') }}"
                   data-reveal data-reveal-delay="0"
                   class="group bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-pink-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-pink-500 group-hover:text-white transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Catálogo</h3>
                    <p class="text-gray-400 text-sm mt-1.5">Explora nuestra colección</p>
                </a>

                <a href="#contacto"
                   data-reveal data-reveal-delay="80"
                   class="group bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-pink-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-pink-500 group-hover:text-white transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Contacto</h3>
                    <p class="text-gray-400 text-sm mt-1.5">Comunícate con nosotros</p>
                </a>

                <a href="#ubicacion"
                   data-reveal data-reveal-delay="160"
                   class="group bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-pink-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-pink-500 group-hover:text-white transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Ubicación</h3>
                    <p class="text-gray-400 text-sm mt-1.5">Encuéntranos</p>
                </a>

                <a href="#redes"
                   data-reveal data-reveal-delay="240"
                   class="group bg-white rounded-2xl p-8 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-pink-500 transition-colors duration-300">
                        <svg class="w-8 h-8 text-pink-500 group-hover:text-white transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Redes Sociales</h3>
                    <p class="text-gray-400 text-sm mt-1.5">Síguenos</p>
                </a>

            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contacto" class="py-24 bg-white">
        <div class="max-w-2xl mx-auto px-6 text-center">
            <p class="text-xs font-bold uppercase tracking-widest text-pink-400 mb-3" data-reveal>Estamos para ti</p>
            <h2 class="text-4xl font-bold text-gray-900" data-reveal data-reveal-delay="80">Contáctanos</h2>
            <p class="mt-3 text-gray-400 leading-relaxed" data-reveal data-reveal-delay="150">
                ¿Tienes alguna pregunta? Estamos aquí para ayudarte y asesorarte
            </p>
            <div class="mt-10 flex justify-center gap-4 flex-wrap" data-reveal data-reveal-delay="220">
                <a href="https://wa.me/{{ config('services.whatsapp.number') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-white font-semibold px-8 py-3.5 rounded-full hover:shadow-lg transition-all active:scale-95"
                   style="background-color:#25D366;box-shadow:0 4px 14px rgba(37,211,102,.3);">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </a>
                <a href="tel:+1234567890"
                   class="inline-flex items-center gap-2 bg-pink-500 text-white font-semibold px-8 py-3.5 rounded-full hover:bg-pink-600 hover:shadow-lg hover:shadow-pink-200 transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    Llamar
                </a>
            </div>
        </div>
    </section>

    {{-- Location --}}
    <section id="ubicacion" class="py-24" style="background-color: #fdf4f7;">
        <div class="max-w-2xl mx-auto px-6 text-center">
            <p class="text-xs font-bold uppercase tracking-widest text-pink-400 mb-3" data-reveal>Visítanos</p>
            <h2 class="text-4xl font-bold text-gray-900" data-reveal data-reveal-delay="80">Nuestra Ubicación</h2>
            <div class="mt-10 bg-white rounded-3xl p-10 shadow-sm border border-pink-50" data-reveal data-reveal-delay="160">
                <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-pink-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <p class="text-gray-800 font-semibold text-lg">Calle Principal #123</p>
                <p class="text-gray-400 mt-1">Ciudad, País</p>
                <div class="mt-5 pt-5 border-t border-gray-100 flex items-center justify-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    <p class="text-gray-500 font-medium text-sm">Lunes a Sábado: 9:00 AM – 7:00 PM</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer component (includes Síguenos + footer bar) --}}
    <x-site-footer />

    </div>{{-- /page wrapper --}}

    @include('partials.scroll-animations')

</body>
</html>

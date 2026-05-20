<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('page-title', 'Catálogo') - {{ config('app.name', 'Bella Moda') }}</title>
    <link rel="icon" href="{{ asset('images/home.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('images/home.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    <meta name="whatsapp-number" content="{{ config('services.whatsapp.number') }}">
    <meta name="pedido-url" content="{{ route('pedido.show') }}">
    <style>
        [x-cloak]              { display: none !important; }
        .scroll-y-thin::-webkit-scrollbar       { width: 4px; }
        .scroll-y-thin::-webkit-scrollbar-track { background: transparent; }
        .scroll-y-thin::-webkit-scrollbar-thumb { background: #f9a8d4; border-radius: 9999px; }
        .scroll-x-thin::-webkit-scrollbar        { height: 4px; }
        .scroll-x-thin::-webkit-scrollbar-track  { background: transparent; }
        .scroll-x-thin::-webkit-scrollbar-thumb  { background: #f9a8d4; border-radius: 9999px; }

        /* Subtle dot-grid background */
        body {
            background-image: radial-gradient(circle, rgba(244,114,182,0.12) 1.5px, transparent 1.5px);
            background-size: 38px 38px;
        }

        /* Rich-text description rendered from admin RichEditor */
        .product-description p              { margin: 0 0 .75rem 0; }
        .product-description p:last-child   { margin-bottom: 0; }
        .product-description strong, .product-description b { font-weight: 600; color:#374151; }
        .product-description em, .product-description i     { font-style: italic; }
        .product-description u              { text-decoration: underline; }
        .product-description a              { color:#ec4899; text-decoration: underline; }
        .product-description a:hover        { color:#db2777; }
        .product-description ul             { list-style: disc; padding-left: 1.25rem; margin: 0 0 .75rem 0; }
        .product-description ol             { list-style: decimal; padding-left: 1.25rem; margin: 0 0 .75rem 0; }
        .product-description li             { margin-bottom: .25rem; }
        .product-description h1, .product-description h2, .product-description h3,
        .product-description h4, .product-description h5, .product-description h6 {
            font-weight: 700; color:#111827; margin: 1rem 0 .5rem 0; line-height: 1.25;
        }
        .product-description h1 { font-size: 1.25rem; }
        .product-description h2 { font-size: 1.15rem; }
        .product-description h3 { font-size: 1.05rem; }
        .product-description blockquote     { border-left: 3px solid #f9a8d4; padding-left: .75rem; color:#6b7280; margin: 0 0 .75rem 0; font-style: italic; }
        .product-description hr             { border:0; border-top:1px solid #f3f4f6; margin: 1rem 0; }
        .product-description code           { background:#f9fafb; padding: .1em .35em; border-radius:.25rem; font-size:.9em; }
        .product-description pre            { background:#f9fafb; padding:.75rem; border-radius:.5rem; overflow-x:auto; margin:0 0 .75rem 0; }
        .product-description img            { max-width:100%; height:auto; border-radius:.5rem; margin:.5rem 0; }
    </style>
</head>
<body class="antialiased min-h-screen" style="background-color:#fdf4f7;" x-data>
@include('partials.sparkles')

{{-- Alpine cart store — registered before Livewire boots Alpine --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        items: [],
        isOpen: false,

        init() {
            const s = localStorage.getItem('bella_moda_cart');
            this.items = s ? JSON.parse(s) : [];
        },

        add(item) {
            const i = this.items.findIndex(x => x.variantId === item.variantId);
            i >= 0 ? this.items[i].quantity += item.quantity : this.items.push({...item});
            this._save();
        },

        remove(vid) {
            this.items = this.items.filter(x => x.variantId !== vid);
            this._save();
        },

        updateQty(vid, delta) {
            const item = this.items.find(x => x.variantId === vid);
            if (!item) return;
            const n = item.quantity + delta;
            n < 1 ? this.remove(vid) : (item.quantity = n, this._save());
        },

        _save() { localStorage.setItem('bella_moda_cart', JSON.stringify(this.items)); },

        get count() { return this.items.reduce((s, x) => s + x.quantity, 0); },
        get total() { return this.items.reduce((s, x) => s + parseFloat(x.price) * x.quantity, 0); },

        get cartCode() {
            return [...this.items]
                .map(x => ({ id: parseInt(x.variantId, 10), qty: parseInt(x.quantity, 10) }))
                .filter(x => x.id > 0 && x.qty > 0)
                .sort((a, b) => a.id - b.id)
                .map(x => `${x.id}x${x.qty}`)
                .join('-');
        },

        pedidoUrl(baseUrl) {
            const code = this.cartCode;
            if (! code) return baseUrl;
            return `${baseUrl}?c=${code}`;
        },

        whatsappUrl(phone) {
            const lines = this.items.map(x =>
                `• ${x.productName}${x.variantName ? ' (' + x.variantName + ')' : ''} x${x.quantity}`
            );
            const meta = document.querySelector('meta[name="pedido-url"]');
            const baseUrl = meta ? meta.content : '';
            const link = baseUrl ? this.pedidoUrl(baseUrl) : '';
            const linkLine = link ? `\n\nResumen del pedido (precios y total): ${link}` : '';
            const msg = `Hola! Me gustaría comprar:\n\n${lines.join('\n')}${linkLine}`;
            return `https://wa.me/${phone}?text=${encodeURIComponent(msg)}`;
        },
    });
});
</script>

{{-- ── Navbar ──────────────────────────────────────────────────────────── --}}
<nav class="sticky top-0 z-40 bg-white/90 backdrop-blur-sm border-b border-pink-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center">

        <div class="w-40 flex-shrink-0">
            @yield('back-link')
        </div>

        <a href="{{ route('home') }}" class="flex-1 flex items-center justify-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Bella Moda" class="h-12 w-auto object-contain block">
        </a>

        <div class="w-40 flex-shrink-0 flex justify-end">
            <button @click="$store.cart.isOpen = true" class="relative text-gray-500 hover:text-pink-500 transition-colors p-1">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span x-show="$store.cart.count > 0" x-text="$store.cart.count" x-cloak
                      class="absolute -top-0.5 -right-0.5 bg-pink-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center leading-none">
                </span>
            </button>
        </div>
    </div>
</nav>

{{-- ── Content ─────────────────────────────────────────────────────────── --}}
<main style="position:relative;z-index:2">
    @yield('content')
</main>

{{-- ── Footer ───────────────────────────────────────────────────────────── --}}
<x-site-footer />

{{-- ── Cart Panel ──────────────────────────────────────────────────────── --}}
<div x-show="$store.cart.isOpen" x-cloak class="fixed inset-0 z-50 flex justify-end"
     @keydown.escape.window="$store.cart.isOpen = false">

    <div @click="$store.cart.isOpen = false"
         x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-black/40">
    </div>

    <div x-transition:enter="transition-transform duration-300 ease-out" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform duration-250 ease-in" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
         class="relative w-full max-w-sm bg-white shadow-2xl flex flex-col h-full"
         @click.stop>

        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Mi Carrito</h2>
                <p class="text-sm text-gray-400 mt-0.5" x-text="`${$store.cart.count} producto${$store.cart.count !== 1 ? 's' : ''}`"></p>
            </div>
            <button @click="$store.cart.isOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-3 scroll-y-thin">
            <div x-show="$store.cart.items.length === 0" class="flex flex-col items-center justify-center h-48 text-center">
                <svg class="w-16 h-16 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                </svg>
                <p class="text-gray-400 font-medium">Tu carrito está vacío</p>
                <p class="text-gray-300 text-sm mt-1">Agrega productos para comenzar</p>
            </div>

            <template x-for="item in $store.cart.items" :key="item.variantId">
                <div class="flex items-center gap-3 bg-pink-50/60 rounded-2xl p-3">
                    <div class="w-14 h-14 rounded-xl flex-shrink-0 overflow-hidden bg-pink-100">
                        <template x-if="item.imageUrl">
                            <img :src="item.imageUrl" :alt="item.productName" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!item.imageUrl && item.colorCode">
                            <div class="w-full h-full rounded-xl" :style="`background-color:${item.colorCode}`"></div>
                        </template>
                        <template x-if="!item.imageUrl && !item.colorCode">
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-pink-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                                </svg>
                            </div>
                        </template>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 text-sm leading-tight truncate" x-text="item.productName"></p>
                        <p x-show="item.variantName" class="text-gray-400 text-xs mt-0.5 truncate" x-text="item.variantName"></p>
                        <div class="flex items-center gap-2 mt-2">
                            <button @click="$store.cart.updateQty(item.variantId,-1)" class="w-6 h-6 rounded-full bg-white shadow-sm hover:bg-gray-50 flex items-center justify-center text-gray-500 text-sm font-bold">−</button>
                            <span class="text-sm font-medium text-gray-700 w-5 text-center" x-text="item.quantity"></span>
                            <button @click="$store.cart.updateQty(item.variantId,1)"  class="w-6 h-6 rounded-full bg-white shadow-sm hover:bg-gray-50 flex items-center justify-center text-gray-500 text-sm font-bold">+</button>
                        </div>
                    </div>

                    <button @click="$store.cart.remove(item.variantId)" class="text-gray-300 hover:text-red-400 transition-colors flex-shrink-0 p-1">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <div class="px-6 py-5 border-t border-gray-100 space-y-3">
            <div x-show="$store.cart.items.length > 0" class="flex justify-between items-center">
                <span class="text-gray-500 font-medium">Total estimado</span>
                <span class="font-bold text-gray-900 text-xl" x-text="`$${$store.cart.total.toFixed(2)}`"></span>
            </div>
            <a x-show="$store.cart.items.length > 0"
               :href="$store.cart.whatsappUrl('{{ config('services.whatsapp.number') }}')"
               target="_blank"
               class="flex items-center justify-center gap-2 w-full bg-green-500 text-white font-semibold py-3.5 rounded-full hover:bg-green-600 transition-colors shadow-md shadow-green-100">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Finalizar por WhatsApp
            </a>
            <button @click="$store.cart.isOpen = false"
                    class="w-full bg-gray-50 text-gray-600 font-medium py-3 rounded-full hover:bg-gray-100 transition-colors text-sm">
                Seguir Comprando
            </button>
        </div>
    </div>
</div>

@include('partials.scroll-animations')
@livewireScripts
</body>
</html>

@extends('catalogo.layout')

@section('page-title', $category->name)

@section('back-link')
    <a href="{{ route('catalogo.index') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-pink-500 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Volver al Catálogo
    </a>
@endsection

@section('content')
<div x-data="shopPage()" class="relative">

    {{-- ── Product Grid ──────────────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">

        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-widest text-pink-400 mb-2" data-reveal>Categoría</p>
            <h1 class="text-4xl font-bold text-gray-900" data-reveal data-reveal-delay="80">{{ $category->name }}</h1>
            <p class="mt-2 text-gray-400" data-reveal data-reveal-delay="150">
                {{ $products->count() }} producto{{ $products->count() !== 1 ? 's' : '' }} disponibles
            </p>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-20" data-reveal>
                <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                </svg>
                <p class="text-gray-400 text-lg font-medium">No hay productos en esta categoría</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $index => $product)
                    @php
                        $defaultVariant = $product->defaultVariant;
                        $primaryImage   = $product->primaryImage;
                        $colorVariants  = $product->variants->filter(fn ($v) => $v->color_code)->take(5);
                    @endphp

                    <div
                        @click="show('{{ $product->slug }}')"
                        data-reveal data-reveal-delay="{{ min($index * 80, 400) }}"
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">

                        {{-- Image --}}
                        <div class="aspect-[4/3] relative overflow-hidden bg-pink-50">
                            @if($primaryImage && $primaryImage->path)
                                <img
                                    src="{{ asset('storage/' . $primaryImage->path) }}"
                                    alt="{{ $primaryImage->alt_text ?? $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-rose-50">
                                    <svg class="w-16 h-16 text-pink-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                            @endif

                            @if($product->is_featured)
                                <span class="absolute top-2.5 left-2.5 bg-pink-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                                    Destacado
                                </span>
                            @endif

                            {{-- Quick-view hint --}}
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 flex items-center justify-center">
                                <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-semibold px-4 py-2 rounded-full shadow">
                                    Ver detalles
                                </span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2 min-h-[2.5rem]">
                                <h3 class="font-semibold text-gray-900 group-hover:text-pink-500 transition-colors leading-snug">
                                    {{ $product->name }}
                                </h3>
                                {{-- Color swatches --}}
                                @if($colorVariants->isNotEmpty())
                                    <div class="flex items-center gap-1 flex-shrink-0 mt-0.5">
                                        @foreach($colorVariants as $variant)
                                            <div
                                                class="w-4 h-4 rounded-full border-2 border-white ring-1 ring-gray-200 shadow-sm"
                                                style="background-color: {{ $variant->color_code }}"
                                                title="{{ $variant->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @if($defaultVariant)
                                <div class="flex items-center gap-2 mt-2">
                                    <p class="text-pink-500 font-bold text-lg">${{ number_format($defaultVariant->price, 2) }}</p>
                                    @if($defaultVariant->compare_at_price)
                                        <p class="text-gray-300 line-through text-sm">${{ number_format($defaultVariant->compare_at_price, 2) }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── Product Modal ─────────────────────────────────────────────────── --}}
    <div x-show="isOpen" x-cloak
         class="fixed inset-0 z-50 flex items-end justify-center sm:items-center sm:p-6"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="close()">

        {{-- Backdrop --}}
        <div @click="close()" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Card --}}
        <div class="relative w-full sm:max-w-4xl bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col sm:flex-row max-h-[92vh] sm:max-h-[88vh]"
             @click.stop>

            {{-- Pink accent bar --}}
            <div class="absolute top-0 left-0 right-0 h-1 sm:hidden"
                 style="background: linear-gradient(90deg,#f43f5e,#ec4899,#f43f5e);background-size:200% auto;">
            </div>
            <div class="absolute top-0 left-0 bottom-0 w-1 hidden sm:block"
                 style="background: linear-gradient(180deg,#f43f5e,#ec4899,#f43f5e);background-size:auto 200%;">
            </div>

            {{-- Close --}}
            <button @click="close()"
                    class="absolute top-3 right-3 z-20 w-9 h-9 bg-white/90 hover:bg-white rounded-full shadow-md flex items-center justify-center text-gray-400 hover:text-gray-700 transition-all hover:scale-110 active:scale-95">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Loading --}}
            <div x-show="loading" class="flex-1 flex items-center justify-center py-24 px-10">
                <div class="flex flex-col items-center gap-4">
                    <div class="relative w-12 h-12">
                        <div class="absolute inset-0 rounded-full border-4 border-pink-100"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-t-pink-500 animate-spin"></div>
                    </div>
                    <p class="text-sm text-gray-400 font-medium">Cargando producto...</p>
                </div>
            </div>

            {{-- Main content --}}
            <template x-if="!loading && product">
                <div class="flex flex-col sm:flex-row w-full overflow-hidden" style="max-height: inherit">

                    {{-- ── Gallery (left) ────────────────────────────────── --}}
                    <div class="sm:w-[44%] flex flex-col flex-shrink-0 bg-gray-50 sm:pl-1">

                        {{-- Main image --}}
                        <div class="relative overflow-hidden h-60 sm:h-auto sm:flex-1"
                             :class="zooming ? 'cursor-zoom-out' : (currentImage ? 'cursor-zoom-in' : '')"
                             @click="if(currentImage){ zooming = !zooming }"
                             @mousemove="if(zooming) handleZoom($event)">

                            <template x-if="currentImage">
                                <img
                                    :src="currentImage.url"
                                    :alt="currentImage.alt"
                                    :style="{
                                        transform: zooming ? 'scale(2.4)' : 'scale(1)',
                                        transformOrigin: `${zoomX}% ${zoomY}%`,
                                        transition: zooming ? 'transform 0.2s ease-out' : 'transform 0.3s ease-in',
                                        pointerEvents: 'none',
                                        userSelect: 'none'
                                    }"
                                    class="w-full h-full object-cover">
                            </template>

                            <template x-if="!currentImage">
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-rose-50">
                                    <svg class="w-20 h-20 text-pink-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                                    </svg>
                                </div>
                            </template>

                            {{-- Expand to lightbox (top-right) --}}
                            <button x-show="currentImage && !zooming"
                                    @click.stop="lightboxOpen = true"
                                    class="absolute top-2.5 left-2.5 w-8 h-8 bg-black/30 backdrop-blur-sm hover:bg-black/50 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 z-10">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                                </svg>
                            </button>

                            {{-- Zoom-off hint --}}
                            <div x-show="zooming"
                                 class="absolute top-2.5 right-10 bg-black/40 backdrop-blur-sm text-white text-xs px-2.5 py-1 rounded-full pointer-events-none">
                                Clic para salir del zoom
                            </div>

                            {{-- Image counter --}}
                            <div x-show="visibleImages.length > 1 && !zooming"
                                 class="absolute bottom-2.5 right-2.5 bg-black/40 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-full">
                                <span x-text="selectedImageIndex + 1"></span>/<span x-text="visibleImages.length"></span>
                            </div>

                            {{-- Zoom hint (desktop, not zoomed) --}}
                            <div x-show="currentImage && !zooming"
                                 class="absolute bottom-2.5 left-2.5 bg-black/30 backdrop-blur-sm text-white text-xs px-2 py-0.5 rounded-full hidden sm:flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                                </svg>
                                Clic para zoom
                            </div>

                            {{-- Arrows (hidden while zooming) --}}
                            <button x-show="visibleImages.length > 1 && !zooming"
                                    @click.stop="prevImage()"
                                    class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/85 hover:bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 transition-all hover:scale-110 active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button x-show="visibleImages.length > 1 && !zooming"
                                    @click.stop="nextImage()"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/85 hover:bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 transition-all hover:scale-110 active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>

                        {{-- Thumbnails --}}
                        <div x-show="visibleImages.length > 1"
                             class="flex gap-2 p-3 overflow-x-auto scroll-x-thin flex-shrink-0 bg-white border-t border-gray-100">
                            <template x-for="(img, idx) in visibleImages" :key="img.id">
                                <button
                                    @click="selectImage(idx); zooming = false"
                                    :class="selectedImageIndex === idx
                                        ? 'ring-2 ring-pink-500 ring-offset-1 opacity-100'
                                        : 'ring-1 ring-gray-200 opacity-55 hover:opacity-100 hover:ring-pink-300'"
                                    class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 transition-all duration-200">
                                    <img :src="img.url" :alt="img.alt" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- ── Details (right) ───────────────────────────────── --}}
                    <div class="flex-1 flex flex-col overflow-y-auto scroll-y-thin">
                        <div class="p-5 sm:p-7 flex flex-col">

                            {{-- Badges row --}}
                            <div class="flex items-center gap-2 flex-wrap mb-3">
                                <template x-if="product.is_featured">
                                    <span class="inline-flex items-center gap-1 bg-pink-50 text-pink-500 text-xs font-bold px-2.5 py-1 rounded-full border border-pink-100">
                                        ✦ Destacado
                                    </span>
                                </template>
                            </div>

                            {{-- Name --}}
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight pr-10"
                                x-text="product.name">
                            </h2>

                            {{-- Price row --}}
                            <div class="flex items-baseline gap-3 mt-3 flex-wrap">
                                <span class="text-3xl font-bold text-pink-500"
                                      x-text="activeVariant ? '$' + activeVariant.price.toFixed(2) : (variants[0] ? '$' + variants[0].price.toFixed(2) : '')">
                                </span>
                                <span x-show="activeVariant && activeVariant.compare_at_price"
                                      class="text-gray-300 line-through text-lg"
                                      x-text="activeVariant && activeVariant.compare_at_price ? '$' + activeVariant.compare_at_price.toFixed(2) : ''">
                                </span>
                                <span x-show="activeVariant && activeVariant.compare_at_price"
                                      class="bg-rose-50 text-rose-500 text-xs font-bold px-2.5 py-1 rounded-full border border-rose-100"
                                      x-text="activeVariant && activeVariant.compare_at_price
                                          ? Math.round((1 - activeVariant.price / activeVariant.compare_at_price) * 100) + '% OFF'
                                          : ''">
                                </span>
                            </div>

                            {{-- Short description --}}
                            <p x-show="product.short_description"
                               class="mt-3 text-gray-400 text-sm leading-relaxed"
                               x-text="product.short_description">
                            </p>

                            {{-- Divider --}}
                            <div class="mt-5 border-t border-gray-100"></div>

                            {{-- ── Variant selectors ──────────────────────── --}}

                            {{-- A) Attribute-based selection (color, talla, etc.) --}}
                            <template x-for="group in attributeGroups" :key="group.attribute_id">
                                <div class="mt-5">
                                    <div class="flex items-center gap-2 mb-3">
                                        <p class="text-sm font-semibold text-gray-700" x-text="group.name + ':'"></p>
                                        <p class="text-sm text-pink-500 font-medium"
                                           x-text="group.values.find(v => v.id === selectedValues[group.attribute_id])?.value || ''">
                                        </p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="val in group.values" :key="val.id">
                                            <button
                                                @click="selectValue(group.attribute_id, val.id)"
                                                :class="isValueSelected(group.attribute_id, val.id)
                                                    ? 'bg-pink-500 text-white border-transparent shadow-md shadow-pink-200 scale-105'
                                                    : 'bg-white text-gray-600 border-gray-200 hover:border-pink-400 hover:text-pink-500'"
                                                class="px-4 py-2 rounded-full border text-sm font-medium transition-all duration-200 select-none"
                                                x-text="val.value">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            {{-- B) Direct variant selector (when no attributes but multiple variants) --}}
                            <div x-show="attributeGroups.length === 0 && variants.length > 1" class="mt-5">
                                <div class="flex items-center gap-2 mb-3">
                                    <p class="text-sm font-semibold text-gray-700">Variante:</p>
                                    <p class="text-sm text-pink-500 font-medium"
                                       x-text="variants.find(v => v.id === selectedVariantId)?.name || (variants[0] ? variants[0].name : '')">
                                    </p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="variant in variants" :key="variant.id">
                                        <button
                                            @click="selectedVariantId = variant.id; selectedImageIndex = 0; zooming = false"
                                            :class="(selectedVariantId === variant.id || (!selectedVariantId && variants[0]?.id === variant.id))
                                                ? 'bg-pink-500 text-white border-transparent shadow-md shadow-pink-200 scale-105'
                                                : 'bg-white text-gray-600 border-gray-200 hover:border-pink-400 hover:text-pink-500'"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border text-sm font-medium transition-all duration-200 select-none">
                                            <template x-if="variant.color_code">
                                                <span class="w-3.5 h-3.5 rounded-full border border-white/50 shadow-sm flex-shrink-0"
                                                      :style="`background:${variant.color_code}`">
                                                </span>
                                            </template>
                                            <span x-text="variant.name"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            {{-- No combination available --}}
                            <div x-show="attributeGroups.length > 0 && !activeVariant"
                                 class="mt-4 flex items-center gap-2 text-sm text-amber-600 bg-amber-50 rounded-xl px-4 py-3 border border-amber-100">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                Esta combinación no está disponible
                            </div>

                            {{-- ── Quantity ───────────────────────────────── --}}
                            <div class="mt-6">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Cantidad</p>
                                <div class="inline-flex items-center gap-1 bg-gray-100 rounded-full p-1">
                                    <button @click="quantity = Math.max(1, quantity - 1)"
                                            class="w-9 h-9 rounded-full bg-white shadow-sm hover:bg-pink-50 flex items-center justify-center text-gray-500 hover:text-pink-500 transition-all active:scale-90 font-bold text-xl leading-none select-none">
                                        −
                                    </button>
                                    <span x-text="quantity" class="w-10 text-center font-bold text-gray-800 text-lg select-none"></span>
                                    <button @click="quantity++"
                                            class="w-9 h-9 rounded-full bg-white shadow-sm hover:bg-pink-50 flex items-center justify-center text-gray-500 hover:text-pink-500 transition-all active:scale-90 font-bold text-xl leading-none select-none">
                                        +
                                    </button>
                                </div>
                            </div>

                            {{-- ── Action buttons ─────────────────────────── --}}
                            <div class="mt-6 flex flex-col gap-3">

                                <button
                                    @click="addToCart()"
                                    :disabled="isUnavailable"
                                    :class="isUnavailable ? 'opacity-40 cursor-not-allowed' : 'hover:bg-pink-600 hover:shadow-lg hover:shadow-pink-200 active:scale-[0.98]'"
                                    class="w-full bg-pink-500 text-white font-semibold py-4 rounded-2xl transition-all duration-200 shadow-md shadow-pink-100 flex items-center justify-center gap-2 text-[15px]">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                                    </svg>
                                    Agregar al carrito
                                </button>

                                <a :href="whatsappUrl"
                                   target="_blank"
                                   class="flex items-center justify-center gap-2 w-full font-semibold py-4 rounded-2xl transition-all active:scale-[0.98] text-[15px] text-white"
                                   style="background-color:#25D366;box-shadow:0 4px 14px rgba(37,211,102,.25);"
                                   onmouseover="this.style.backgroundColor='#1fba59'"
                                   onmouseout="this.style.backgroundColor='#25D366'">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                                    </svg>
                                    Comprar por WhatsApp
                                </a>

                                <button @click="close()"
                                        class="text-gray-400 text-sm py-1.5 hover:text-pink-400 transition-colors text-center">
                                    ← Seguir comprando
                                </button>
                            </div>

                            {{-- SKU --}}
                            <p x-show="activeVariant && activeVariant.sku"
                               class="mt-5 text-xs text-gray-300 font-mono"
                               x-text="'SKU: ' + (activeVariant ? activeVariant.sku : '')">
                            </p>

                            {{-- Full description --}}
                            <div x-show="product.description"
                                 class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-gray-500 text-sm leading-relaxed" x-text="product.description"></p>
                            </div>

                        </div>
                    </div>

                </div>
            </template>
        </div>
    </div>

    {{-- ── Lightbox ──────────────────────────────────────────────────────── --}}
    <div x-show="lightboxOpen" x-cloak
         class="fixed inset-0 z-[60] bg-black/95 flex items-center justify-center"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="lightboxOpen = false"
         @keydown.escape.window="lightboxOpen = false">

        <button @click="lightboxOpen = false"
                class="absolute top-4 right-4 z-10 w-11 h-11 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <button x-show="visibleImages.length > 1"
                @click.stop="prevImage()"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </button>

        <button x-show="visibleImages.length > 1"
                @click.stop="nextImage()"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-all hover:scale-110">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </button>

        <template x-if="currentImage">
            <img :src="currentImage.url" :alt="currentImage.alt"
                 class="max-w-full max-h-full object-contain p-4 sm:p-10 select-none"
                 @click.stop
                 style="pointer-events:none">
        </template>

        <div x-show="visibleImages.length > 1"
             class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
            <template x-for="(img, idx) in visibleImages" :key="img.id">
                <button @click.stop="selectImage(idx)"
                        :class="selectedImageIndex === idx ? 'bg-white w-5' : 'bg-white/35 hover:bg-white/60 w-2'"
                        class="h-2 rounded-full transition-all duration-200">
                </button>
            </template>
        </div>
    </div>

</div>

<script>
function shopPage() {
    return {
        isOpen: false,
        loading: false,
        product: null,
        images: [],
        variants: [],
        attributeGroups: [],
        selectedImageIndex: 0,
        selectedValues: {},
        selectedVariantId: null,
        quantity: 1,
        zooming: false,
        zoomX: 50,
        zoomY: 50,
        lightboxOpen: false,

        get activeVariant() {
            if (!this.product || this.variants.length === 0) return null;
            // Direct variant selection (no attribute groups)
            if (this.attributeGroups.length === 0) {
                if (this.variants.length === 1) return this.variants[0];
                return this.variants.find(v => v.id === this.selectedVariantId) || this.variants[0];
            }
            // Attribute-based selection
            const selectedIds = Object.values(this.selectedValues).filter(Boolean);
            if (selectedIds.length === 0) return this.variants[0];
            return this.variants.find(v =>
                selectedIds.every(id => v.attribute_value_ids.includes(id))
            ) || null;
        },

        get isUnavailable() {
            // Only block when the combination of attributes has no matching variant
            return this.attributeGroups.length > 0 && !this.activeVariant;
        },

        get visibleImages() {
            if (!this.product) return [];
            const av = this.activeVariant;
            if (av && av.image_ids && av.image_ids.length > 0) {
                const subset = this.images.filter(img => av.image_ids.includes(img.id));
                if (subset.length > 0) return subset;
            }
            return this.images;
        },

        get currentImage() {
            if (this.visibleImages.length === 0) return null;
            return this.visibleImages[Math.min(this.selectedImageIndex, this.visibleImages.length - 1)];
        },

        get whatsappUrl() {
            const av = this.activeVariant || this.variants[0] || null;
            const phone = (document.querySelector('meta[name="whatsapp-number"]') || {}).content || '';
            const pedidoBase = (document.querySelector('meta[name="pedido-url"]') || {}).content || '';
            if (!this.product || !phone) return '#';
            const variantText = av && av.name ? ` (${av.name})` : '';
            const link = (av && pedidoBase) ? `${pedidoBase}?c=${av.id}x${this.quantity}` : '';
            const linkLine = link ? `\n\nResumen del pedido (precios y total): ${link}` : '';
            const msg = `Hola! Quisiera comprar:\n\n• ${this.product.name}${variantText} x${this.quantity}${linkLine}\n\nPor favor confirmarme disponibilidad. ¡Gracias!`;
            return `https://wa.me/${phone}?text=${encodeURIComponent(msg)}`;
        },

        async show(slug) {
            this.isOpen = true;
            this.loading = true;
            this.product = null;
            this.images = [];
            this.variants = [];
            this.attributeGroups = [];
            this.selectedImageIndex = 0;
            this.selectedValues = {};
            this.selectedVariantId = null;
            this.quantity = 1;
            this.zooming = false;
            this.lightboxOpen = false;
            document.body.style.overflow = 'hidden';

            try {
                const res = await fetch(`/api/catalogo/producto/${slug}`);
                if (!res.ok) throw new Error('Not found');
                const data = await res.json();
                this.product = data;
                this.images = data.images || [];
                this.variants = data.variants || [];
                this.attributeGroups = data.attribute_groups || [];
                // Pre-select first value per attribute group
                this.attributeGroups.forEach(group => {
                    if (group.values.length > 0) {
                        this.selectedValues = { ...this.selectedValues, [group.attribute_id]: group.values[0].id };
                    }
                });
                // Pre-select first variant for direct selection
                if (this.variants.length > 0) {
                    this.selectedVariantId = this.variants[0].id;
                }
            } catch (e) {
                this.isOpen = false;
                document.body.style.overflow = '';
                console.error('Error loading product:', e);
            } finally {
                this.loading = false;
            }
        },

        close() {
            this.isOpen = false;
            this.lightboxOpen = false;
            this.zooming = false;
            document.body.style.overflow = '';
        },

        selectImage(idx) {
            this.selectedImageIndex = idx;
            this.zooming = false;
        },

        prevImage() {
            const max = this.visibleImages.length - 1;
            this.selectedImageIndex = this.selectedImageIndex > 0 ? this.selectedImageIndex - 1 : max;
            this.zooming = false;
        },

        nextImage() {
            const max = this.visibleImages.length - 1;
            this.selectedImageIndex = this.selectedImageIndex < max ? this.selectedImageIndex + 1 : 0;
            this.zooming = false;
        },

        handleZoom(event) {
            const rect = event.currentTarget.getBoundingClientRect();
            this.zoomX = ((event.clientX - rect.left) / rect.width * 100).toFixed(1);
            this.zoomY = ((event.clientY - rect.top) / rect.height * 100).toFixed(1);
        },

        selectValue(attrId, valueId) {
            this.selectedValues = { ...this.selectedValues, [attrId]: valueId };
            this.selectedImageIndex = 0;
            this.zooming = false;
        },

        isValueSelected(attrId, valueId) {
            return this.selectedValues[attrId] === valueId;
        },

        addToCart() {
            if (this.isUnavailable) return;
            const av = this.activeVariant || this.variants[0];
            if (!av) return;
            const img = this.visibleImages[0] || null;
            window.Alpine.store('cart').add({
                variantId: av.id,
                productName: this.product.name,
                variantName: av.name || null,
                price: av.price,
                quantity: this.quantity,
                imageUrl: img ? img.url : null,
                colorCode: av.color_code || null,
            });
            this.close();
            window.Alpine.store('cart').isOpen = true;
        },
    };
}
</script>
@endsection

@extends('catalogo.layout')

@section('page-title', 'Catálogo')

@section('back-link')
    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-pink-500 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Volver
    </a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">

    <div class="text-center mb-12">
        <p class="text-xs font-bold uppercase tracking-widest text-pink-400 mb-3" data-reveal>Colección</p>
        <h1 class="text-4xl font-bold text-gray-900" data-reveal data-reveal-delay="80">Nuestro Catálogo</h1>
        <p class="mt-2 text-gray-400 text-lg" data-reveal data-reveal-delay="150">Explora nuestras categorías y encuentra tu estilo perfecto</p>
    </div>

    @if($categories->isEmpty())
        <div class="text-center py-20">
            <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
            </svg>
            <p class="text-gray-400 text-lg font-medium">No hay categorías disponibles</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $gradients = [
                    'from-pink-200 via-rose-100 to-pink-50',
                    'from-purple-200 via-violet-100 to-purple-50',
                    'from-blue-200 via-sky-100 to-blue-50',
                    'from-green-200 via-emerald-100 to-green-50',
                    'from-amber-200 via-yellow-100 to-amber-50',
                    'from-indigo-200 via-blue-100 to-indigo-50',
                ];
            @endphp

            @foreach($categories as $index => $category)
                @php $gradient = $gradients[$index % count($gradients)]; @endphp

                <a href="{{ route('catalogo.category', $category) }}"
                   data-reveal data-reveal-delay="{{ min($index * 90, 450) }}"
                   class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                    {{-- Image / Gradient --}}
                    <div class="aspect-[4/3] relative overflow-hidden bg-gradient-to-br {{ $gradient }}">
                        @if($category->image_url)
                            <img
                                src="{{ $category->image_url }}"
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Text --}}
                    <div class="p-5 text-center">
                        <h2 class="text-xl font-bold text-gray-900">{{ $category->name }}</h2>
                        @if($category->description)
                            <p class="mt-1.5 text-gray-400 text-sm leading-relaxed line-clamp-2">{{ $category->description }}</p>
                        @endif
                        <span class="inline-flex items-center gap-1 mt-4 text-pink-500 text-sm font-semibold group-hover:gap-2.5 transition-all duration-200">
                            Ver productos
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('catalogo.layout')

@section('page-title', 'Resumen de pedido')

@section('back-link')
    <a href="{{ route('catalogo.index') }}"
       class="inline-flex items-center gap-2 text-gray-500 hover:text-pink-500 transition-colors font-medium text-sm">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
        Volver al catálogo
    </a>
@endsection

@section('content')
    <section class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

        <div class="text-center mb-10">
            <p class="text-xs font-bold uppercase tracking-widest text-pink-400 mb-2">Pedido del cliente</p>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Resumen de pedido</h1>
            @if ($itemCount > 0)
                <p class="text-gray-500 mt-2">{{ $itemCount }} {{ $itemCount === 1 ? 'artículo' : 'artículos' }}</p>
            @endif
        </div>

        @if ($lines->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-pink-50">
                <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-pink-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Pedido vacío</h2>
                <p class="text-gray-500 mt-2">No se encontraron productos en este enlace.</p>
                <a href="{{ route('catalogo.index') }}"
                   class="mt-6 inline-flex items-center gap-2 bg-pink-500 text-white font-semibold px-6 py-3 rounded-full hover:bg-pink-600 transition-colors">
                    Ir al catálogo
                </a>
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm border border-pink-50 overflow-hidden">

                <ul class="divide-y divide-pink-50">
                    @foreach ($lines as $line)
                        <li class="p-5 sm:p-6 flex gap-4 items-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-2xl bg-pink-50 overflow-hidden flex items-center justify-center">
                                @if ($line['image'])
                                    <img src="{{ $line['image'] }}" alt="{{ $line['product_name'] }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-pink-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" />
                                    </svg>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 leading-tight">{{ $line['product_name'] }}</h3>

                                @if (! empty($line['attributes']))
                                    <div class="mt-1.5 flex flex-wrap gap-1.5">
                                        @foreach ($line['attributes'] as $attr)
                                            <span class="inline-flex items-center gap-1 text-[11px] bg-pink-50 text-pink-600 font-medium px-2 py-0.5 rounded-full">
                                                {{ $attr['attribute'] }}: {{ $attr['value'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                @elseif ($line['variant_name'])
                                    <p class="mt-1 text-sm text-gray-500">{{ $line['variant_name'] }}</p>
                                @endif

                                @if ($line['sku'])
                                    <p class="mt-1.5 text-[11px] text-gray-400 font-mono">SKU: {{ $line['sku'] }}</p>
                                @endif

                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <span class="text-sm text-gray-500">
                                        ${{ number_format($line['price'], 2) }} × {{ $line['quantity'] }}
                                    </span>
                                    <span class="font-bold text-gray-900">${{ number_format($line['subtotal'], 2) }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="bg-pink-50/60 px-5 sm:px-6 py-5 flex items-center justify-between">
                    <span class="text-gray-700 font-semibold">Total</span>
                    <span class="text-2xl font-bold text-pink-600">${{ number_format($total, 2) }}</span>
                </div>
            </div>

            <p class="text-center text-xs text-gray-400 mt-6">
                Precios reales tomados del catálogo. Confirme disponibilidad con el cliente antes de cerrar la venta.
            </p>
        @endif

    </section>
@endsection

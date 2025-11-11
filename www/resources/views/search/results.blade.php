
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ 'Resultados · ' . e($query) }}</title>

    
    @vite('resources/css/resultados.css')

</head>

<body>

   
    <header>
        <div class="header-inner">
            <a href="{{ url('/') }}" class="brand" aria-label="Inicio">
                <img src="{{ asset('imagenes/Logo1.JPG') }}" alt="ShockingSales" class="logo-img">
            </a>
        </div>
    </header>

    <main>
        <section class="results-scope search-results" style="max-width:1100px; width:90%; margin:16px auto;">
          
            @isset($error)
                <div class="alert alert-error" role="alert" aria-live="assertive">
                    <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                    <span>{{ $error }}</span>
                </div>
            @endisset

            {
            <div class="results-header">
                <h1 class="results-title">
                    Resultados para <mark class="query">{{ e($query) }}</mark>
                </h1>
                <p class="results-subtitle">
                    {{ $message ?? 'Buscando en nuestras tiendas…' }}
                </p>

                @php
                    // Contador total de productos
                    $total = 0;
                    if (isset($results) && is_iterable($results)) {
                        foreach ($results as $items) {
                            $total += is_countable($items) ? count($items) : 0;
                        }
                    }
                @endphp
                <p class="results-meta" aria-live="polite">
                    <i class="fas fa-box-open" aria-hidden="true"></i>
                    <strong>{{ number_format($total) }}</strong> producto(s) encontrado(s)
                </p>
            </div>

            {{-- Resultados por tienda --}}
            @if (isset($results) && count($results) > 0 && $total > 0)
                @foreach ($results as $storeName => $products)
                    @php $count = is_countable($products) ? count($products) : 0; @endphp

                    @if ($count > 0)
                        <section class="store-section"
                            aria-labelledby="store-{{ \Illuminate\Support\Str::slug($storeName) }}">
                            <div class="store-header">
                                <h2 id="store-{{ \Illuminate\Support\Str::slug($storeName) }}" class="store-title">
                                    @switch($storeName)
                                        @case('Tienda 1')
                                            <i class="fas fa-store" aria-hidden="true"></i>
                                        @break

                                        @case('Tienda 2')
                                            <i class="fas fa-store-alt" aria-hidden="true"></i>
                                        @break

                                        @case('Tienda 3')
                                            <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                                        @break

                                        @case('TIenda 4')
                                            <i class="fas fa-shopping-basket" aria-hidden="true"></i>
                                        @break

                                        @default
                                            <i class="fas fa-store" aria-hidden="true"></i>
                                    @endswitch
                                    <span class="store-name">{{ $storeName }}</span>
                                </h2>
                                <span class="product-count" aria-label="Cantidad de productos en {{ $storeName }}">
                                    {{ number_format($count) }} producto(s)
                                </span>
                            </div>

                            <ul class="products-grid" role="list">
                                @foreach ($products as $product)
                                    <li class="product-card" role="listitem">
                                        <article class="product">
                                            <a href="{{ $product['url'] }}" target="_blank" rel="noopener"
                                                class="product-link">
                                                <div class="product-image">
                                                    <img src="{{ $product['imagen'] }}" alt="{{ $product['nombre'] }}"
                                                        loading="lazy" decoding="async"
                                                        onerror="this.src='{{ asset('imagenes/fallback.png') }}'; this.alt='Imagen no disponible';">
                                                </div>
                                                <div class="product-info">
                                                    <h3 class="product-name">{{ $product['nombre'] }}</h3>

                                                    <div class="price-section">
                                                        @php $precio = (float)($product['precio'] ?? 0); @endphp
                                                        <span class="current-price">
                                                            ${{ number_format($precio, 2, '.', ',') }}
                                                        </span>
                                                    </div>

                                                    @php
                                                        $rate = data_get($product, 'rating.rate');
                                                        $countReviews = (int) data_get($product, 'rating.count', 0);
                                                        $filled = max(0, min(5, (float) $rate));
                                                        $empty = 5 - floor($filled);
                                                    @endphp

                                                    <div class="rating"
                                                        aria-label="Valoración {{ $rate ?? 'N/A' }} sobre 5">
                                                        <span class="stars" aria-hidden="true">
                                                            @for ($i = 0; $i < floor($filled); $i++)
                                                                ★
                                                            @endfor
                                                            @for ($i = 0; $i < $empty; $i++)
                                                                ☆
                                                            @endfor
                                                        </span>
                                                        <span class="rating-text">
                                                            {{ $rate ?? 'N/A' }}
                                                            <span
                                                                class="review-count">({{ number_format($countReviews) }}
                                                                reseñas)</span>
                                                        </span>
                                                    </div>

                                                    <span class="store-chip">
                                                        Ver en {{ $storeName }}
                                                        <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                                        <span class="visually-hidden">(abre en una pestaña nueva)</span>
                                                    </span>
                                                </div>
                                            </a>
                                        </article>
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    @endif
                @endforeach
            @else
                <section class="no-results" aria-live="polite">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <h3>No se encontraron productos</h3>
                    <p>Prueba con otros términos, por ejemplo: <code>phone</code>, <code>laptop</code>,
                        <code>jacket</code>.</p>
                </section>
            @endif
        </section>
    </main>

    <footer>
        <div class="results-scope"
            style="max-width:1100px; width:90%; margin:24px auto; color:#6b7399; text-align:center;">
            © {{ date('Y') }} ShockingSales
        </div>
    </footer>

</body>

</html>

@extends('layouts.plantilla')

@section('title', 'Resultados para "' . $query . '"')

@section('content')
<div class="search-results">
    <!-- Mensaje de error -->
    @if(isset($error))
        <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            {{ $error }}
        </div>
    @endif

    <!-- Header de resultados -->
    <div class="results-header">
        <h1>Resultados para "{{ $query }}"</h1>
        <p>{{ $message ?? 'Buscando en nuestras tiendas...' }}</p>
    </div>

    <!-- Resultados por tienda -->
    @if(isset($results) && count($results) > 0)
        @foreach($results as $storeName => $products)
            @if(count($products) > 0)
                <div class="store-section">
                    <div class="store-header">
                        <h2>{{ $storeName }}</h2>
                        <span class="product-count">{{ count($products) }} producto(s)</span>
                    </div>
                    
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card {{ $product['en_oferta'] ? 'on-sale' : '' }}">
                                <div class="product-image">
                                    <img src="{{ $product['imagen'] }}" alt="{{ $product['nombre'] }}" loading="lazy">
                                </div>
                                
                                @if($product['en_oferta'])
                                    <div class="sale-badge">OFERTA</div>
                                @endif
                                
                                <div class="product-info">
                                    <h3 class="product-name">{{ $product['nombre'] }}</h3>
                                    
                                    <div class="price-section">
                                        @if($product['en_oferta'])
                                            <span class="original-price">${{ number_format($product['precio_original'], 2) }}</span>
                                            <span class="current-price">${{ number_format($product['precio'], 2) }}</span>
                                            <span class="savings">Ahorras ${{ number_format($product['ahorro'], 2) }}</span>
                                        @else
                                            <span class="current-price">${{ number_format($product['precio'], 2) }}</span>
                                        @endif
                                    </div>

                                    <div class="rating">
                                        ⭐ {{ $product['rating'] ?? 'N/A' }} 
                                    </div>
                                    
                                    <div class="product-meta">
                                        <span class="category">{{ $product['categoria'] }}</span>
                                        @if($product['disponible'])
                                            <span class="stock in-stock">Disponible</span>
                                        @else
                                            <span class="stock out-of-stock">Agotado</span>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ $product['url'] }}" target="_blank" class="store-link">
                                        <i class="fas fa-external-link-alt"></i>
                                        Ver en {{ $storeName }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="no-results">
            <i class="fas fa-search"></i>
            <h3>No se encontraron productos</h3>
            <p>Intenta con otros términos de búsqueda</p>
        </div>
    @endif
</div>
@endsection
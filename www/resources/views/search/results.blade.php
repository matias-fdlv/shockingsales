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
                        <h2>
                            @switch($storeName)
                                @case('Tienda 1') @break
                                @case('Tienda 2') @break
                                @case('Tienda 3') @break
                                @case('TIenda 4') @break
                                @default
                            @endswitch
                            {{ $storeName }}
                        </h2>
                        <span class="product-count">{{ count($products) }} producto(s)</span>
                    </div>
                    
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="{{ $product['imagen'] }}" alt="{{ $product['nombre'] }}" loading="lazy">
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name">{{ $product['nombre'] }}</h3>
                                    
                                    <div class="price-section">
                                        <span class="current-price">${{ number_format($product['precio'], 2) }}</span>
                                    </div>

                                    <div class="rating">
                                        ⭐ {{ $product['rating']['rate'] ?? 'N/A' }} 
                                        <span class="review-count">({{ $product['rating']['count'] ?? 0 }} reviews)</span>
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
            <p>Intenta con otros términos de búsqueda como "phone", "laptop", "jacket"</p>
        </div>
    @endif
</div>
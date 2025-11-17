@extends('home')

@section('title', $baseProduct->nombre)

@section('content')
<div class="product-detail">
    {{-- Enlace para volver a la página anterior --}}
    <a href="{{ url()->previous() }}" class="back-link">&larr; Volver a los resultados</a>
    
    <header class="product-header">
        <h1>{{ $baseProduct->nombre }}</h1>
        <p class="store-origin">Visto originalmente en: <strong>{{ $storeName }}</strong></p>
    </header>

    <div class="product-content-grid">
        <div class="product-media">
            {{-- Imagen principal del producto --}}
            <img src="{{ $baseProduct->imagen_url }}" alt="{{ $baseProduct->nombre }}" class="main-image">
        </div>

        <div class="product-main-info">
            <h2>Precio Actual</h2>
            <p class="current-price-lg">${{ number_format($baseProduct->precio_actual, 2) }}</p>
            
            {{-- Mostrar información de oferta si aplica --}}
            @if($baseProduct->en_oferta)
                <p class="original-price-striked">Precio Original: ${{ number_format($baseProduct->precio_original, 2) }}</p>
                <span class="savings-info">¡Ahorras ${{ number_format($baseProduct->ahorro, 2) }}!</span>
            @endif

            <p class="product-description">{{ $baseProduct->descripcion ?? 'Sin descripción disponible.' }}</p>
            
            {{-- Botón de compra para la tienda actual --}}
            <a href="{{ $baseProduct->enlace_producto }}" target="_blank" rel="noopener" class="btn btn-primary btn-lg">
                Comprar en {{ $storeName }}
            </a>
            
            <div class="product-meta-chips">
                <span>Categoría: {{ $baseProduct->categoria ?? 'N/A' }}</span>
                <span class="{{ $baseProduct->disponible ? 'in-stock' : 'out-of-stock' }}">
                    {{ $baseProduct->disponible ? 'Disponible' : 'Agotado' }}
                </span>
            </div>
        </div>
    </div>
    
    ---
    
    {{-- Sección de Comparación de Precios --}}
    <section class="price-comparison mt-5">
        <h2>Comparación de Precios en Otras Tiendas</h2>

        @if(count($comparisons) > 0)
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Tienda</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Fila para la tienda original (el producto en el que hicieron clic) --}}
                    <tr>
                        <td><strong>{{ $storeName }} (Original)</strong></td>
                        <td data-label="Precio">${{ number_format($baseProduct->precio_actual, 2) }}</td>
                        <td data-label="Estado">Disponible</td>
                        <td data-label="Acción">
                             <a href="{{ $baseProduct->enlace_producto }}" target="_blank" rel="noopener" class="btn btn-sm btn-success">Ver</a>
                        </td>
                    </tr>
                    
                    {{-- Iterar sobre los productos encontrados en otras tiendas --}}
                    @foreach($comparisons as $store => $product)
                        <tr class="{{ $product->precio_actual < $baseProduct->precio_actual ? 'cheaper' : '' }}">
                            <td>{{ $store }}</td>
                            <td data-label="Precio">
                                ${{ number_format($product->precio_actual, 2) }}
                                {{-- Resaltar si esta opción es más barata que el producto base --}}
                                @if($product->precio_actual < $baseProduct->precio_actual)
                                    <span class="badge badge-cheapest">¡Más Barato!</span>
                                @endif
                            </td>
                            <td data-label="Estado" class="{{ $product->disponible ? 'text-success' : 'text-danger' }}">
                                {{ $product->disponible ? 'Disponible' : 'Agotado' }}
                            </td>
                            <td data-label="Acción">
                                {{-- El botón solo es funcional si está disponible --}}
                                <a href="{{ $product->enlace_producto }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary" 
                                   {{ $product->disponible ? '' : 'disabled' }}>Ver Oferta</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="alert alert-warning">No se encontraron precios similares en otras tiendas.</p>
        @endif
    </section>
</div>
@endsection
@extends('layouts.plantilla')

@section('title', 'Inicio')

@section('content')

    @guest('admin')
        <!-- Vista Preliminar de los productos en la pagina principal,  esto está sugetoa cambios -->


        <section>
            <h1>Sugerencias</h1>
            <article>
                <div class="suggestions">
                    <div class="products-grid">

                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://via.placeholder.com/200x150/4a90e2/ffffff?text=Producto+1" alt="Producto 1">
                            </div>
                            <div class="product-info">
                                <div class="product-name">Auriculares Inalámbricos</div>
                                <div class="product-price">$99.99</div>
                            </div>
                        </div>


                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://via.placeholder.com/200x150/e74c3c/ffffff?text=Producto+2" alt="Producto 2">
                            </div>
                            <div class="product-info">
                                <div class="product-name">Smartwatch Deportivo</div>
                                <div class="product-price">$149.99</div>
                            </div>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://via.placeholder.com/200x150/2ecc71/ffffff?text=Producto+3" alt="Producto 3">
                            </div>
                            <div class="product-info">
                                <div class="product-name">Tablet 10 Pulgadas</div>
                                <div class="product-price">$79.99</div>
                            </div>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://via.placeholder.com/200x150/f39c12/ffffff?text=Producto+4" alt="Producto 4">
                            </div>
                            <div class="product-info">
                                <div class="product-name">Cámara Digital</div>
                                <div class="product-price">$199.99</div>
                            </div>
                        </div>

                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://via.placeholder.com/200x150/9b59b6/ffffff?text=Producto+5" alt="Producto 5">
                            </div>
                            <div class="product-info">
                                <div class="product-name">Altavoz Bluetooth</div>
                                <div class="product-price">$129.99</div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </section>


        <section>
            <h1>Nuevas Ofertas</h1>
            <article>
                <div class="new-offers">
                    <div class="offers-grid">
                        <!-- Oferta 1 -->
                        <div class="offer-card">
                            <div class="offer-badge">Oferta</div>
                            <div class="offer-image">
                                <img src="https://via.placeholder.com/250x180/3498db/ffffff?text=Oferta+1" alt="Oferta 1">
                            </div>
                            <div class="offer-info">
                                <div class="offer-name">Smart TV 55" 4K</div>
                                <div class="offer-price">
                                    <span class="current-price">$79.99</span>
                                    <span class="original-price">$99.99</span>
                                    <span class="discount">-20%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Oferta 2 -->
                        <div class="offer-card">
                            <div class="offer-badge">Oferta</div>
                            <div class="offer-image">
                                <img src="https://via.placeholder.com/250x180/e74c3c/ffffff?text=Oferta+2" alt="Oferta 2">
                            </div>
                            <div class="offer-info">
                                <div class="offer-name">Laptop Gaming</div>
                                <div class="offer-price">
                                    <span class="current-price">$149.99</span>
                                    <span class="original-price">$199.99</span>
                                    <span class="discount">-25%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Oferta 3 -->
                        <div class="offer-card">
                            <div class="offer-badge">Oferta</div>
                            <div class="offer-image">
                                <img src="https://via.placeholder.com/250x180/2ecc71/ffffff?text=Oferta+3" alt="Oferta 3">
                            </div>
                            <div class="offer-info">
                                <div class="offer-name">Consola de Videojuegos</div>
                                <div class="offer-price">
                                    <span class="current-price">$59.99</span>
                                    <span class="original-price">$79.99</span>
                                    <span class="discount">-25%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            </article>
        </section>
    @endguest


@endsection

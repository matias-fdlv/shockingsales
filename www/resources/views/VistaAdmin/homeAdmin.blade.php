@extends('layouts.admin')

@section('content')

  <!-- HERO(sección protagonista): 1 grande + 2 laterales -->
  <section class="hero-grid">
    <article class="hero hero-main" style="--hero-bg:url('{{ asset('img/hero-electro.jpg') }}')">
      <a class="inner" href="{{ url('/buscar?q=ofertas') }}">
        <span class="badge">Ofertas</span>
        <h2>Comparador de Electrónica y Videojuegos</h2>
        <p class="meta">Busca y compara en Amazon, MercadoLibre y eBay</p>
      </a>
    </article>

    <article class="hero hero-side" style="--hero-bg:url('{{ asset('img/hero-gaming.jpg') }}')">
      <a class="inner" href="{{ url('/buscar?q=consolas') }}">
        <span class="badge">Gaming</span>
        <h3>Consolas y accesorios al mejor precio</h3>
        <p class="meta">PS5 · Xbox · Nintendo</p>
      </a>
    </article>

    <article class="hero hero-side" style="--hero-bg:url('{{ asset('img/hero-deals.jpg') }}')">
      <a class="inner" href="{{ url('/buscar?q=smartphones') }}">
        <span class="badge">Top</span>
        <h3>Smartphones y audio con descuento</h3>
        <p class="meta">Auriculares · Smartwatch</p>
      </a>
    </article>
  </section>

  </div>


@endsection

@extends('layouts.plantilla')

@section('title', 'Inicio')

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

    @guest
      <p class="mt-3 center">
            <a href="{{ route('registro.usuario') }}" class="btn btn-success">Registrate para obtener ofertas</a>
      </p>
    @endguest
  </div>

  <!--  GRID DE TARJETAS: destacados o últimos. -->
  <section class="post-grid mt-4">
    @php
      $items = $destacados ?? $posts ?? null;
    @endphp

    @if($items && count($items))
      @foreach($items as $item)
        <article class="card post">
          <a href="{{ $item->url ?? '#' }}">
            <img src="{{ $item->cover_url ?? asset('img/card1.jpg') }}" alt="">
            <div class="post-body">
              <h4>{{ $item->title }}</h4>
              <p class="muted">
                {{ $item->store ?? 'Tiendas' }}
                @if(!empty($item->created_at))
                  · {{ \Illuminate\Support\Carbon::parse($item->created_at)->translatedFormat('M d, Y') }}
                @endif
              </p>
            </div>
          </a>
        </article>
      @endforeach
    @else

      @for($i=1; $i<=8; $i++)
        <article class="card post">
          <a href="#">
            <img src="{{ asset('img/card'.(($i % 4) + 1).'.jpg') }}" alt="">
            <div class="post-body">
              <h4>Buen diseño es memorable y significativo.</h4>
              <p class="muted">Amazon · Dic 15, 2017</p>
            </div>
          </a>
        </article>
      @endfor
    @endif
  </section>

@endsection

<?php

namespace App\Services;

use App\Models\Tienda;
use Illuminate\Support\Facades\Http;

//esta clase es capaz de llamar a la API y recoger los datos que se le pidan.
class FakeStoreClient
{
    private string $baseUrl;

    //constructor de la clase!
    public function __construct()
    {
        //busca en Tienda (tabla) la tienda "Fake Store".
        $tienda = Tienda::where('Nombre', 'Fake Store')->first();

        $this->baseUrl = $tienda?->credenciales() //si tienda es null, no se hace nada de lo siguiente
            ->where('Tipo', 'base_url') //busca la credencial de tienda donde tipo = base_url, es un FILTRO WHERE, si este filtro no encuentra nada devuelve igual
            ->value('Valor') ?? 'https://fakestoreapi.com'; //devuelve el url, si no tiene nada porque no existe y el filtro no funciono, devuelve fakestoreapi.com
    }

    /** @return array<string> */
    public function categories(): array
    {
        $res = Http::retry(2, 200)->timeout(15)->get($this->baseUrl.'/products/categories');
        return $res->ok() ? ($res->json() ?? []) : [];
    }

    /** @return array<int, array<string,mixed>> */
    public function products(?int $limit = null, ?string $sort = null): array
    {
        $query = [];
        if ($limit) $query['limit'] = $limit;
        if ($sort)  $query['sort']  = $sort; // asc|desc

        $res = Http::retry(2, 200)->timeout(30)->get($this->baseUrl.'/products', $query);
        return $res->ok() ? ($res->json() ?? []) : [];
    }
}

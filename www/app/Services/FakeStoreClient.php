<?php

namespace App\Services;

use App\Models\Tienda;
use Illuminate\Support\Facades\Http;

//esta clase es capaz de llamar a la API y recoger los datos que se le pidan.
class FakeStoreClient
{
    private string $baseUrl;

    public function __construct()
    {
        $tienda = Tienda::where('Nombre', 'Fake Store')->first();
        $this->baseUrl = $tienda?->credenciales()
            ->where('Tipo', 'base_url')
            ->value('Valor') ?? 'https://fakestoreapi.com';
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

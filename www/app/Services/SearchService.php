<?php

namespace App\Services;

use App\Models\Tienda;
use App\Models\CredencialTienda;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SearchService
{

    //metodo o funcion utilizado en la busqueda.
    public function search(string $query): array
    {
         //se obtienen tiendas de la BD, con un if por si sale mal
        $tiendas = Tienda::where('Estado', true)
            ->where('API', 'fake_store')
            ->with('credenciales')
            ->get();

        if ($tiendas->isEmpty()) {
            return ['error' => 'No hay tiendas Fake Store configuradas'];
        }

        $results = [];

        //por cada tienda se hace una busqueda, esto haciendo un foreach
        foreach ($tiendas as $tienda) {
            try {
                $storeResults = $this->searchInFakeStoreAPI($tienda, $query);
                if (!empty($storeResults)) {
                    $results[$tienda->Nombre] = $storeResults;
                }
            } catch (\Exception $e) {
                Log::error("Error en tienda {$tienda->Nombre}: " . $e->getMessage());
            }
        }

        if (empty($results)) {
            return ['error' => 'No se encontraron resultados en tiendas Fake Store'];
        }

        return $results;
    }

    //buscar en una tienda especifica, metodo usado en search.
    private function searchInFakeStoreAPI(Tienda $tienda, string $query): array
    {
        //obtener datos en la BD fijos
        $baseUrl = $tienda->credenciales->where('Tipo', 'base_url')->first()->Valor;

        //peticion HTTP
        $products = Http::timeout(15)
            ->retry(3, 100)
            ->get("{$baseUrl}/products")
            ->json() ?? [];

        // filtrado de productos con la query o mejor dicho busqueda que hicimos.
        $filteredProducts = $this->filterProducts($products, $query);

        //return de todo lo que recibimos del array de la peticion HTTP.
        return array_map(function($product) use ($tienda) {
            return [
                'id' => $product['id'],
                'nombre' => $product['title'],
                'precio' => $product['price'],
                'url' => "https://fakestoreapi.com/products/{$product['id']}",
                'imagen' => $product['image'],
                'categoria' => $product['category'],
                'descripcion' => $product['description'] ?? '',
                'rating' => $product['rating'] ?? null,
                'tienda_id' => $tienda->Nombre
            ];
        }, $filteredProducts);
    }

    //filtro usando query, o sea, la busqueda que se hizo.
    private function filterProducts(array $products, string $query): array
    {
        if (empty($query)) {
            return $products;
        }

        return array_filter($products, function($product) use ($query) {
            $title = $product['title'] ?? '';
            return stripos($title, $query) !== false;
        });
    }

}
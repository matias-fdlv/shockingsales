<?php

namespace App\Services;

use App\Models\Tienda;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SearchService
{
    /**
     * Busca productos en TODAS las tiendas configuradas
     */
    public function search(string $query): array
    {
        //solo tiendas activas
        $tiendas = Tienda::where('Estado', true)
            ->whereIn('API', ['toys_store', 'tech_store'])
            ->with('credenciales')
            ->get();

        if ($tiendas->isEmpty()) {
            return ['error' => 'No hay tiendas configuradas'];
        }

        $results = [];

        foreach ($tiendas as $tienda) {
            try {
                // OBTENER URL DESDE EL MODELO (no desde credenciales)
                $baseUrl = $tienda->BaseURL;
                
                // PREPARAR HEADERS PARA FUTURAS APIS CON AUTH
                $headers = $this->prepareHeaders($tienda);
                
                // HACER LA PETICIÓN HTTP
                $response = Http::withHeaders($headers)
                    ->timeout(15)
                    ->retry(3, 100)
                    ->get("{$baseUrl}/products", [
                        'search' => $query,
                        'disponible' => true
                    ]);

                if ($response->successful()) {
                    $apiData = $response->json();
                    
                    // VALIDAR RESPUESTA DE LA API
                    if ($this->isValidApiResponse($apiData)) {
                        $products = $apiData['data'] ?? [];
                        
                        if (!empty($products)) {
                            $results[$tienda->Nombre] = $this->transformProducts($products, $tienda);
                        }
                    }
                } else {
                    Log::warning("API {$tienda->Nombre} respondió con error", [
                        'status' => $response->status(),
                        'response' => $response->body()
                    ]);
                }
                
            } catch (\Exception $e) {
                Log::error("Error en tienda {$tienda->Nombre}", [
                    'error' => $e->getMessage(),
                    'query' => $query,
                    'tienda_id' => $tienda->IDTienda
                ]);
            }
        }

        return empty($results) 
            ? ['error' => 'No se encontraron resultados en ninguna tienda']
            : $results;
    }

    /**
     * Prepara headers HTTP según las credenciales de la tienda
     */
    private function prepareHeaders(Tienda $tienda): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent' => 'MiComparadorPrecios/1.0'
        ];

        // SI LA TIENDA TIENE TOKEN, LO AGREGAMOS
        $token = $tienda->getToken();
        if ($token && $token !== 'no_requerido') {
            $headers['Authorization'] = "Bearer {$token}";
        }

        return $headers;
    }

    /**
     * Valida que la respuesta de la API sea correcta
     */
    private function isValidApiResponse(?array $apiData): bool
    {
        if (!$apiData) {
            return false;
        }

        // LA API DEBE TENER 'success' => true Y 'data'
        return isset($apiData['success']) && $apiData['success'] === true;
    }

    /**
     * Transforma productos de la API a formato estándar
     */
    private function transformProducts(array $products, Tienda $tienda): array
    {
        return array_map(function($product) use ($tienda) {
            return [
                'id' => $product['id'],
                'nombre' => $product['nombre'],
                'precio' => $product['precio_actual'],
                'precio_original' => $product['precio_original'] ?? null,
                'url' => $product['enlace_producto'] ?? '#',
                'imagen' => $product['imagen_url'] ?? '',
                'categoria' => $product['categoria'] ?? '',
                'descripcion' => $product['descripcion'] ?? '',
                'rating' => $product['valoracion'] ?? null,
                'tienda_id' => $tienda->Nombre,
                'disponible' => $product['disponible'] ?? true,
                // CAMPOS CALCULADOS
                'en_oferta' => isset($product['precio_original']) && 
                              $product['precio_actual'] < $product['precio_original'],
                'ahorro' => isset($product['precio_original']) ? 
                           $product['precio_original'] - $product['precio_actual'] : 0
            ];
        }, $products);
    }
}
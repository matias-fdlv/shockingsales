<?php

namespace App\Services;

use App\Models\Tienda;
use App\Models\Categoria;
use App\Models\ProductoInterno;
use App\Models\ProductoTienda;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class FakeStoreSync
{
    public function __construct(private FakeStoreClient $client) {}

    /**
     * Separa Marca y Modelo desde el título.
     * Nunca retorna NULL (usa SIN_MARCA / SIN_MODELO como fallback).
     */
    private function splitBrandModel(string $title): array
    {
        $t = trim($title);

        if (str_contains($t, ' - ')) {
            [$b, $m] = explode(' - ', $t, 2);
            $brand = trim($b);
            $model = trim($m);
        } else {
            $known = [
                'SanDisk','Samsung','Apple','WD','Seagate','Fjallraven',
                'John Hardy','Opna','DANVOUY','Acer','Asus','HP','Lenovo','Dell'
            ];
            $brand = null; $model = null;
            foreach ($known as $k) {
                if (stripos($t, $k) === 0) {
                    $brand = $k;
                    $model = trim(mb_substr($t, mb_strlen($k)));
                    break;
                }
            }

            if ($brand === null) {
                if (preg_match('/^(\S+)(?:\s+(.+))?$/u', $t, $m1)) {
                    $brand = $m1[1] ?? 'SIN_MARCA';
                    $model = trim($m1[2] ?? '') ?: 'SIN_MODELO';
                } else {
                    $brand = 'SIN_MARCA';
                    $model = 'SIN_MODELO';
                }
            }
        }

        return [
            mb_substr($brand ?: 'SIN_MARCA', 0, 255),
            mb_substr($model ?: 'SIN_MODELO', 0, 255),
        ];
    }

    /**
     * Sincroniza categorías y productos desde Fake Store.
     */
    public function run(?int $limit = null, ?string $sort = null): void
    {
        DB::transaction(function () use ($limit, $sort) {
            // 1) Tienda
            $tienda = Tienda::where('Nombre', 'Fake Store')->firstOrFail();

            // 2) Categorías
            $nameToCatId = [];
            foreach ($this->client->categories() as $name) {
                $cat = Categoria::firstOrCreate(['Nombre' => $name]);
                $nameToCatId[$name] = $cat->IDCategoria;
            }

            // 3) Productos
            $now = Carbon::now();

            foreach ($this->client->products($limit, $sort) as $p) {
                $extId   = $p['id']       ?? null;
                $title   = $p['title']    ?? null;
                $price   = $p['price']    ?? null;
                $catName = $p['category'] ?? null;

                if (!$extId || !$title) {
                    continue;
                }

                $url = 'https://fakestoreapi.com/products/' . $extId;

                // 3.1) productoInterno (sin NULL en Marca/Modelo)
                [$brand, $model] = $this->splitBrandModel($title);

                $interno = ProductoInterno::firstOrCreate(
                    ['Nombre' => $title],
                    ['Marca' => $brand, 'Modelo' => $model]
                );

                if (empty($interno->Marca) || empty($interno->Modelo)) {
                    $interno->Marca  = $interno->Marca  ?: $brand;
                    $interno->Modelo = $interno->Modelo ?: $model;
                    $interno->save();
                }

                // 3.2) pertenece (ProductoInterno ↔ Categoria)
                if ($catName && isset($nameToCatId[$catName])) {
                    $interno->categorias()->syncWithoutDetaching([$nameToCatId[$catName]]);
                }

                // 3.3) productoTienda (FIRST-OR-NEW → SET → SAVE)
                //     Afiliado es VARCHAR(255) NOT NULL => usar '' (nunca NULL).
                $productoTienda = ProductoTienda::firstOrNew(['URL' => $url]);

                // Si tu modelo tiene $fillable, asegúrate de incluir estos campos.
                $productoTienda->IDProductoI        = $interno->IDProductoI;
                $productoTienda->Nombre             = $title;
                $productoTienda->Precio             = $price;
                $productoTienda->Afiliado           = $productoTienda->Afiliado ?? '';
                $productoTienda->FechaActualizacion = $now;

                // Por si acaso, fuerza string vacío si vino null
                if (is_null($productoTienda->Afiliado)) {
                    $productoTienda->Afiliado = '';
                }

                $productoTienda->save(); // ← GUARDA SÍ O SÍ Y DEVUELVE ID

                // 3.4) tiene (Tienda ↔ ProductoTienda)
                $tienda->productosTienda()->syncWithoutDetaching([$productoTienda->getKey()]);
            }
        });
    }
}

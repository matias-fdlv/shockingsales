<?php

namespace Database\Seeders;

use App\Models\Tienda;
use App\Models\CredencialTienda;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiendaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('credencialesTiendas')->delete();
        DB::table('tiendas')->delete();

        // Seeder de tiendas, pensadas para futuras integraciones reales
        $tiendas = [
            [
                'nombre' => 'FakeElectro',
                'api' => 'fake_store',
                'credenciales' => [
                    'base_url' => 'https://fakestoreapi.com',
                    'api_key'  => '',
                ],
            ],
            [
                'nombre' => 'FakeTech',
                'api' => 'fake_store',
                'credenciales' => [
                    'base_url' => 'https://fakestoreapi.com',
                    'api_key'  => '',
                ],
            ],
            [
                'nombre' => 'FakeGadget',
                'api' => 'fake_store',
                'credenciales' => [
                    'base_url' => 'https://fakestoreapi.com',
                    'api_key'  => '',
                ],
            ],
            [
                'nombre' => 'FakeDigital',
                'api' => 'fake_store',
                'credenciales' => [
                    'base_url' => 'https://fakestoreapi.com',
                    'api_key'  => '',
                ],
            ],
        ];

        foreach ($tiendas as $tiendaData) {
            $tienda = Tienda::create([
                'NombreTienda'  => $tiendaData['nombre'],
                'URLTienda'     => $tiendaData['credenciales']['base_url'],
                'EstadoTienda'  => 'Activa',
            ]);

            foreach ($tiendaData['credenciales'] as $tipo => $valor) {
                CredencialTienda::create([
                    'IDTienda' => $tienda->IDTienda,
                    'Tipo'     => $tipo,
                    'Valor'    => $valor,
                ]);
            }
        }
    }
}

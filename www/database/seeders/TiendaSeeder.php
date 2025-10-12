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

        //seeder de tienda, el cual podemos usar en un futuro en tiendas reales
        $tiendas = [
            [
                //nombre de la tienda
                'nombre' => 'FakeElectro',
                //nombre de la api
                'api' => 'fake_store', 
                //datos internos de la api
                'credenciales' => [
                    //url de la api
                    'base_url' => 'https://fakestoreapi.com',
                    //key o token de la api
                    'api_key' => ''
                ]
            ],
            [
                'nombre' => 'FakeTech', 
                'api' => 'fake_store',
                'credenciales' => [
                    'base_url' => 'https://fakestoreapi.com',
                    'api_key' => ''
                ]
            ],
            [
                'nombre' => 'FakeGadget',
                'api' => 'fake_store', 
                'credenciales' => [
                    'base_url' => 'https://fakestoreapi.com',
                    'api_key' => ''
                ]
            ],
            [
                'nombre' => 'FakeDigital',
                'api' => 'fake_store',
                'credenciales' => [
                    'base_url' => 'https://fakestoreapi.com',
                    'api_key' => ''
                ]
            ]
        ];

        foreach ($tiendas as $tiendaData) {
            $tienda = Tienda::create([
                'Nombre' => $tiendaData['nombre'],
                'API' => $tiendaData['api'],
                'Estado' => true
            ]);

            foreach ($tiendaData['credenciales'] as $tipo => $valor) {
                CredencialTienda::create([
                    'IDTienda' => $tienda->IDTienda,
                    'Tipo' => $tipo,
                    'Valor' => $valor
                ]);
            }
        }
    }
}
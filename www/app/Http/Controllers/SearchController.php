<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController
{
    //LARAVEL inserta el servicio SearchService en el constructor de la clase, no hace falta especificarlo porque laravel lo hace con tan solo poner los datos tal cual escritos.
    //esto reemplaza el poner el constructor y definir la variable de la forma clasica

    /*
    private SearchService $searchService;
    
    public function __construct() 
    {
        $this->searchService = new SearchService();
    }*/
    public function __construct(private SearchService $searchService) 
    {
    }

    //este metodo devuelve la vista home.blade.php
    public function home(): View
    {
        return view('home');
    }

    //este metodo se encarga de la busqueda
    public function search(Request $request): View
    {
        //se valida la busqueda, una medida de seguridad simple y muy util
        $request->validate([
            //required: no permite busquedas vacías
            //tring: solo texto
            //max:50: previene ataques con textos muy largos, para evitar inyecciones sql por ejemplo
            'query' => 'required|string|max:50'
        ]);

        //limpia espacios en blanco de la request
        $query = trim($request->input('query'));
        
        //trycatch como los quue usabamos para las peticiones SQL anteriormente
        try {
            //metodo que inicia la busqueda
            $resultados = $this->searchService->search($query);
            
            //un if para devolver mensaje de error por si sale mal algo y lo devuelve.
            if (isset($resultados['error'])) {
                return view('search.results', [
                    //return error
                    'error' => $resultados['error'],
                    //return lo que se busco, ej shirt
                    'query' => $query
                ]);
            }

            //se guardan el total de productos encontrados y el total de tiendas con resultados.
            $total_products = $this->countTotalProducts($resultados);
            $total_stores = count($resultados);

            //Devolver vista con:
            //Lo que se busca (query)
            //Resultados (results)
            //Total de tiendas con resultados (total_stores)
            //Total de productos encontrados (total_products)
            //Mensaje de la descripcion devuelta por cada producto (message)
            return view('search.results', [
                'query' => $query,
                'results' => $resultados,
                'total_stores' => $total_stores,
                'total_products' => $total_products,
                'message' => $this->generateResultMessage($query, $resultados)
            ]);
             
        //catch del trycatch
        } catch (\Exception $e) {
            //manejo de errores, al dar un error devuelve un mensaje junto al error que es devuelto.
            return view('search.results', [
                'error' => 'Error en la búsqueda: ' . $e->getMessage(),
                'query' => $query
            ]);
        }
    }

    //metodo que calcula el total de productos de cada tienda con un foreach, recorre cada tienda y devuelve que productos devolvio y al contar uno lo agrega al $total.
    private function countTotalProducts(array $results): int
    {
        $total = 0;
        foreach ($results as $storeProducts) {
            $total += count($storeProducts);
        }
        return $total;
    }

    //este metodo devuelve un mensaje, en los comentarios se muestra que tipo de mensaje sería:
    private function generateResultMessage(string $query, array $results): string
    {
        $totalProducts = $this->countTotalProducts($results);
        $totalStores = count($results);

        //"No se encontraron resultados para --producto buscado--"
        if ($totalProducts === 0) {
            return "No se encontraron resultados para \"{$query}\"";
        }
        //Se encontraron --cantidad de productos total-- en --cantidad de tiendas total-- para --producto buscado--
        return "Se encontraron {$totalProducts} productos en {$totalStores} tiendas para \"{$query}\"";
    }
}
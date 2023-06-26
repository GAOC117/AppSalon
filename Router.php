<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn) //voy llenando el arreglo de rutas->funciones
    {   //que ruta tiene que funcion
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn) //voy llenando el arreglo de rutas->funciones
    {   //que ruta tiene que funcion
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        
        // Proteger Rutas...
        session_start();

        // Arreglo de rutas protegidas...
        // $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        // $auth = $_SESSION['login'] ?? null;

        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') { //obtengo la función que contiene la ruta actual, debe existir dicha llave en el arreglo rutasGet
            $fn = $this->getRoutes[$currentUrl] ?? null;//si no existe la llave, asiga null a $fn
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }


        if ( $fn ) { //la url existe y hay una función asociada
            //nombre de la funcion, y parametros que va a recibir, en este caso se envia este mismo objeto por asi decirlo, las variables
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos; //funciones en controllers, especifica los parametros a usar
            //call_user_func($fn, $this,"5"); si por ejemplo en index() como parametro coloco index($x,$y) toma 
            //como $x el $this y como $y el 5, 
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    public function renderView($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...Esta función activará el búfer de salida. Mientras el almacenamiento en búfer de salida está activo, no se envía ninguna salida desde el script (aparte de los encabezados), sino que la salida se almacena en un búfer interno.

        // entonces incluimos la vista en el layout
        // GUARDAR EN MEMORIA A QUE SE LE DA RENDER
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Obtener el contenido del búfer actual y eliminar el búfer de salida actual
        include_once __DIR__ . '/views/layout.php';
    }
}

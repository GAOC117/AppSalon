<?php

namespace Controllers;

use Model\ActiveRecord;
// use Model\Servicio;
use MVC\Router;

class CitaController extends ActiveRecord
{

    public static function index(Router $router)
    {


   // $valor = Servicio::all();
     
        session_start();
       $router->renderView('cita/index',[
        'nombre'=>$_SESSION['nombre']
        //'valor' =>$valor
        

       ]);
    }

}

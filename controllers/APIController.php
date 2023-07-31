<?php


namespace Controllers;

use Model\Servicio;

class APIController{

    public static function index(){
      
        // $id = $_GET['id'];
        
        // $servicios = Servicio::where('id',$id);
        $servicios = Servicio::all();
    
        echo json_encode($servicios);
    }
}
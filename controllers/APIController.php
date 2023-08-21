<?php


namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController
{

    public static function index()
    {
        //  $id = $_GET['id'];

        //  $servicios = Servicio::where('id',$id);
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }


    public static function guardar()
    {

        //almacena la cita y devuelve el id        
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];


        //almacena la cita y el servicio con el id de la cita
        $idServicios = explode(',', $_POST['servicios']); //explode es como split, para hacer un split a la cadena de texto

        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }


        echo json_encode(['resultado' => $resultado]);
    }





    public static function eliminar()
    {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location: '. $_SERVER['HTTP_REFERER']); //redireccionar a la pagina de la cual veniamos
        }
        
    }
}

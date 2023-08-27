<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{

  public static function index(Router $router)
  {
    session_start();

    isAdmin();
    $servicios = Servicio::all();
    $router->renderView('servicios/index', [
      'nombre' => $_SESSION['nombre'],
      'servicios' => $servicios
    ]);
  }

  public static function crear(Router $router)
  {

    session_start();

    isAdmin();
    $servicio = new Servicio;
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $servicio->sincronizar($_POST);
      $alertas = $servicio->validar();

      if (empty($alertas)) {
        $servicio->guardar();
       
        header('Location: /servicios');
      }
    }

    $router->renderView('servicios/crear', [
      'nombre' => $_SESSION['nombre'],
      'servicio' => $servicio,
      'alertas' => $alertas
    ]);
  }

  public static function actualizar(Router $router)
  {
    session_start();
    isAdmin();
    
    $id = $_GET['id']; //evitamos que en la url pongan algo como delete from, etc
    if(!is_numeric($id)) return;
    $servicio = Servicio::find($id);
   
    $alertas = [];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $servicio->sincronizar($_POST);
      $alertas = $servicio->validar();
      
      
      if (empty($alertas)) {
        $servicio->guardar();
        header('Location: /servicios');
      }
    }

    $router->renderView('servicios/actualizar', [
      'nombre' => $_SESSION['nombre'],
      'servicio' => $servicio,
      'alertas' => $alertas
    ]);
  }


  public static function eliminar()
  {

    session_start();
    isAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $servicio = Servicio::find($id);
      $servicio->eliminar();
      header('Location: /servicios');
    }
  }
}

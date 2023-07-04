<?php

namespace Controllers;

use Model\usuario;
use MVC\Router;

class LoginController
{

  public static function login(Router $router)
  {
    $router->renderView('auth/login', []);
  }

  public static function logout(Router $router)
  {
    echo 'logout';
  }

  public static function olvide(Router $router)
  {
    $router->renderView('auth/olvide-password', []);
  }

  public static function recuperar()
  {
    echo 'recuperar';
  }

  public static function crear(Router $router)
  {

    $usuario = new Usuario;

    //alertas vacias
    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      //creo un objeto nuevo y le envio los datos para inicializar las variables en la clase
      // $usuario = new Usuario($_POST);
      $usuario->sincronizar($_POST);   //sincronizo lo escrito con las variables en memoria, lo mismo que el codigo anterior
      $alertas = $usuario->validarNuevaCuenta();

      //revisar que alerta esté vacio
      if (empty($alertas))
        echo "si";
    }



    $router->renderView('auth/crear-cuenta', [
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }
}

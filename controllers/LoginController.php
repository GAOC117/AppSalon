<?php

namespace Controllers;

use Classes\Email;
use Model\usuario;
use Model\Usuario as ModelUsuario;
use MVC\Router;

class LoginController
{

  public static function login(Router $router)
  {
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new Usuario($_POST);
      $alertas = $auth->validarLogin();
      if (empty($alertas)) {
        //comprobar que exista el usuario
        $usuario = Usuario::where('email',$auth->email);
      }
    }

    $router->renderView('auth/login', [
      'alertas' => $alertas,
      'auth' => $auth
    ]);
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

      if (empty($alertas)) {
        $resultado = $usuario->existeUsuario();

        if ($resultado->num_rows) {
          $alertas = Usuario::getAlertas(); //si hay alertas "nuevas" despues de pasar los filtros, reiniciamos la variable tomando las alertas que se generan en existeUsuario() en modelo: usuario
        } else {
          //hashear el password
          $usuario->hashPassword();
          //generar token único
          $usuario->generarToken();
          //enviar email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarConfirmacion();

          $alertas = ModelUsuario::getAlertas();

          $resultado = $usuario->guardar();
          if ($resultado)
            header('Location: /mensaje');
        }
      }
    }



    $router->renderView('auth/crear-cuenta', [
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }


  public static function mensaje(Router $router)
  {
    $router->renderView('auth/mensaje');
  }

  public static function confirmar(Router $router)
  {
    $alertas = [];
    $token = s($_GET['token']);

    $usuario = Usuario::where('token', $token);

    if (empty($usuario) || $usuario->token === '') {
      //mostrar mensaje de error
      Usuario::setAlerta('error', 'Token no válido');
    } else {
      //modificar usuario confirmado

      $usuario->confirmado = 1;
      $usuario->token = '';
      $usuario->guardar();
      Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
    }

    $alertas = Usuario::getAlertas();
    $router->renderView('auth/confirmar-cuenta', [
      'alertas' => $alertas
    ]);
  }
}

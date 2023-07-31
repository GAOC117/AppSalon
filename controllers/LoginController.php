<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
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
        $usuario = Usuario::where('email', $auth->email);

        if ($usuario) {
          //verificar password
          if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
            //autenticar el usuario
            session_start();

            $_SESSION['id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['login'] = true;


            //redireccionamiento
            if ($usuario->admin === '1') {
              $_SESSION['admin'] = $usuario->admin ?? null;
              header('Location: /admin');
            } else
              header('Location: /cita');
          }
        } else {
          Usuario::setAlerta('error', 'Usuario no encontrado');
        }
      }
    }
    $alertas = Usuario::getAlertas();
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
    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new Usuario($_POST);
      //validar si el campo de email esta lleno
      $alertas = $auth->validarEmail();


      if (empty($alertas)) {
        $usuario = Usuario::where('email', $auth->email);
        if ($usuario && $usuario->confirmado === '1') {
          //si existe...
          //generar token
          $usuario->generarToken();
          //actualiza al usuario
          $usuario->guardar();

          //enviar email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarInstracciones();


          Usuario::setAlerta('exito', 'Revisa tu email');
        } else {
          //no existe o no esta confirmado
          Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
        }
      }
    }

    $alertas = Usuario::getAlertas();

    $router->renderView('auth/olvide-password', [
      'alertas' => $alertas
    ]);
  }

  public static function recuperar(Router $router)
  {
    $alertas = [];
    $error = false;
    $token = s($_GET['token']);

    //buscar usuario por token
    $usuario = Usuario::where('token', $token);

    if (empty($usuario)) {
      Usuario::setAlerta('error', 'Token no valido');
      $error = true;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //enviar y actualizar password
      $password = new Usuario($_POST);
      $alertas = $password->validarPassword();

      if (empty($alertas)) {
        $usuario->password = $password->password;
        $usuario->hashPassword();
        $usuario->token = '';
        $resultado = $usuario->guardar();

        if ($resultado) {
          header('Location: /');
        }
      }
    }

    $alertas = Usuario::getAlertas();
    $router->renderView('auth/recuperar-password', [
      'alertas' => $alertas,
      'error' => $error
    ]);
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

          $alertas = Usuario::getAlertas();

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

    if (empty($usuario) ||$usuario->token === '') {
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
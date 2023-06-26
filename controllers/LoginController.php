<?php 

namespace Controllers;

use MVC\Router;

class LoginController{

    public static function login(Router $router) {
      $router->renderView('auth/login',[]);
    }

    public static function logout(Router $router) {
        echo 'logout';
    }
    
    public static function olvide(Router $router) {
      $router->renderView('auth/olvide-password',[]);
    }
    
    public static function recuperar() {
        echo 'recuperar';
    }
    
    public static function crear(Router $router) {
        $router->renderView('auth/crear-cuenta',[]);
    }
}
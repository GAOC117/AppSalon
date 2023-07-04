<?php

namespace Model;

class usuario extends ActiveRecord
{


    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    //definimos el constructor para inicializar las variables de esta clase
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;    
        $this->nombre = $args['nombre'] ?? '';    
        $this->apellido = $args['apellido'] ?? '';    
        $this->email = $args['email'] ?? '';    
        $this->password = $args['password'] ?? '';    
        $this->telefono = $args['telefono'] ?? '';    
        $this->admin = $args['admin'] ?? null;    
        $this->confirmado = $args['confirmado'] ?? null;    
        $this->token = $args['token'] ?? '';    
    }

    //Mensajes de validación para la creación de una cuenta
    public function validarNuevaCuenta()
    {
            if(!$this->nombre)
                self::$alertas['error'][]='El nombre es obligatorio';
            
                if(!$this->apellido)
                self::$alertas['error'][]='El apellido es obligatorio';
            
                if(!$this->email)
                self::$alertas['error'][]='El E-mail es obligatorio';
            
                if(!$this->password)
                self::$alertas['error'][]='El password es obligatorio';
                
                else if(strlen($this->password)<6)
                self::$alertas['error'][]='El password debe contener al menos 6 caracteres';
            
                if(!$this->telefono)
                self::$alertas['error'][]='El telefono es obligatorio';
            
                



                return self::$alertas;
    }
        
    

}

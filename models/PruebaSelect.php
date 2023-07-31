<?php 

namespace Model;

class PruebaSelect extends ActiveRecord{

 //Base de datos
 protected static $tabla = 'servicios';
 protected static $columnasDB = ['id','nombre','precio'];


 public $id;
 public $nombre;
 public $precio;


 

} 
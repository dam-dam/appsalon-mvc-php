<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

Class AdminController{

    public static function index(Router $router){
        session_start();
        isAdmin();

        
        $fecha =$_GET["fecha"] ?? date("Y-m-d");

        $fechaBuscar = explode("-", $fecha);

        if(!checkdate($fechaBuscar[1], $fechaBuscar[2], $fechaBuscar[0])){
            header("Location: /404");
        }

        //consultar base de datos
        $consulta = "SELECT  ci.id, ci.hora, CONCAT(us.nombre , ' ', us.apellido) AS cliente, us.email, us.telefono, serv.nombre AS servicio, serv.precio FROM citas AS ci LEFT OUTER JOIN usuarios AS us  on ci.usuarioId = us.id LEFT OUTER JOIN citasServicio  AS cs ON  ci.id = cs.citaId LEFT OUTER JOIN servicios AS serv ON cs.servicioId = serv.id WHERE fecha = '$fecha' ;";

        $citas= AdminCita::SQL($consulta);
        
        
        
        $router ->render("admin/index",[
            "nombre" => $_SESSION["nombre"],
            "citas"=> $citas,
            "fecha"=> $fecha
        ]);
    }  

}
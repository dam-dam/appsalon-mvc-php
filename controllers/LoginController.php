<?php
namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

Class LoginController{
    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuario;



        if($_SERVER["REQUEST_METHOD"]=== "POST"){
            $auth = new Usuario($_POST);

            $alertas= $auth->validarLogin();
            if(empty($alertas)){
               //comprobar que exista el usuaro
               $usuario = Usuario::where("email", $auth->email);
                if($usuario){
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //autenticar el usuario
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION["email"]= $usuario->email;
                        $_SESSION["login"]= true;

                        //redireccionamiento
                        if($usuario->admin ==="1"){
                            $_SESSION["admin"] = $usuario->admin ?? null;
                            Header("Location: /admin");

                        }else{
                            Header("Location: /cita");
                        }

                    }
                }else{
                    Usuario::setAlerta("error", "Usuario no encontrado");
                }
            }
        }
        $alertas = Usuario::getAlertas();


        $router->render("auth/login",[
            "alertas" => $alertas,
            "auth" => $auth

        ]);
        
    }

    public static function logout(){
        session_start();

        $_SESSION=[];

        header("Location: /");
    }


    public static function olvide(Router $router){
        $alertas= [];


        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $auth = new Usuario($_POST);
            $alertas= $auth -> validarEmail();

            if(empty($alertas)){
                $usuario = Usuario:: where("email", $auth->email);

                if($usuario && $usuario->confirmado === "1"){
                    $usuario->creartoken();
                    $usuario->guardar();

                    //enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email ->envaiarInstrucciones();

                    //Alerta Exit
                    Usuario::setAlerta("exito", "el email se envio correctamente");
                    
                }else{
                    Usuario::setAlerta("error", "el usuario no existe o no esta confimado");
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render("/auth/olvide-password",[
            "alertas" => $alertas

        ]);
    }


    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;
        $token = s($_GET["token"]);

        //buscar usuario por token
        $usuario = Usuario::where("token",$token);

        if(empty($usuario)){
            Usuario::setAlerta("error", "Token no valido");
            $error = true;
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            //leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarpassword();

            if(empty($alertas)){
                $usuario-> password = null;
                $usuario-> password = $password->password;
                $usuario->hashPasssword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado){
                    header("Location: /");

                }
                

            }
            


        }
       
        


        $alertas = Usuario::getAlertas();

        $router->render("/auth/recuperar-password",[
            "alertas" => $alertas,
            "error" => $error

        ]);
    }


    public static function crear(Router $router){

    $usuario = new Usuario;
    //alertas vacioas
    $alertas =[];

    if($_SERVER["REQUEST_METHOD"]=== "POST"){
        $usuario -> sincronizar($_POST);
        $alertas = $usuario-> validarNuevaCuenta();

        //revisar si alertas esta vacio
        if(empty($alertas)){
            //verificar que el usuario no este registrado
            $resultado =$usuario->existeUsuario();

            if($resultado->num_rows){
                $alertas = Usuario::getAlertas();
            }else{
                //hashear el password
                $usuario->hashPasssword();
                //generar un token unico
                $usuario-> creartoken();
                //enviar el email
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                $email->enviarConfirmacion();

                $resultado = $usuario->guardar();

                if($resultado){
                    header("Location: /mensaje");
                }

                //debuguear($email);


            }

        }
    }
        $router->render("/auth/crear-cuenta",[
            "usuario" => $usuario,
            "alertas" => $alertas,
            
        ]);
    }
    
    public static function mensaje(Router $router){
        $router->render("auth/mensaje");


    }

    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET["token"]);
        
        $usuario = Usuario::where("token", $token);
        
        if(empty($usuario)){
            //mostrar mensaje de errore
            Usuario::setAlerta("error", "token no valido");
        }else{

        //modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = "null";
            $usuario->guardar();
            $usuario = Usuario::setAlerta("exito", "cuenta autenticada con exito");
        }
        $alertas = Usuario::getAlertas();
        //renderizar la vista
        $router->render("auth/confirmar-cuenta",[
            "alertas"=> $alertas
        ]);
        

    }
}
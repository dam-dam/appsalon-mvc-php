<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

Class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this ->email = $email;
        $this ->nombre = $nombre;
        $this ->token = $token;
    }
    public function enviarConfirmacion(){
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];

        $mail->setFrom("cuetas@appsalon.com");
        $mail->addAddress("cuentas@appsalon.com", "appsalon.com");
        $mail->Subject = "Confrma tu cuenta";

        //Set html
        $mail-> isHTML(TRUE);
        $mail-> CharSet= "UTF-8";


        $contenido = "<html>";
        $contenido.= "<p><strong>Hola " . $this->nombre . "</strong>   Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace </p>";
        $contenido.="<p> Presiona aqui: <a href='". $_ENV["APP_URL"] ."/confirmar-cuenta?token=" . $this->token . "'> Confirmar cuenta </a> </p>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido.= "</html>";

        $mail->Body= $contenido;

        // Enviar el mail y verificar errores
        $mail->send();
    }

    public function envaiarInstrucciones(){
         //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USER"];
        $mail->Password = $_ENV["EMAIL_PASS"];

        $mail->setFrom("cuetas@appsalon.com");
        $mail->addAddress("cuentas@appsalon.com", "appsalon.com");
        $mail->Subject = "Restablece tu password";

        //Set html
        $mail-> isHTML(TRUE);
        $mail-> CharSet= "UTF-8";


        $contenido = "<html>";
        $contenido.= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restablecer tu password, sigue el siguente enlace para hacerlo </p>";
        $contenido.="<p> Presiona aqui: <a href='". $_ENV["APP_URL"] ."/recuperar?token=" . $this->token . "'> Restablecer Password </a> </p>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido.= "</html>";

        $mail->Body= $contenido;

        // Enviar el mail y verificar errores
        $mail->send();

    }
}


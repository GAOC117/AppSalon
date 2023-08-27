<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use Model\Usuario;

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['EMAIL_PORT'];


        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . ". </strong> Has creado tu cuenta en App Salon, solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='".$_ENV['APP_URL'] ."/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //enviar email
        if ($mail->send())
            Usuario::setAlerta('exito', 'Mensaje enviado correctamente');
        else
            Usuario::setAlerta('error', 'El mensaje no se pudo enviar');
    }

    public function enviarInstracciones()
    {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        // $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gortiz@siteur.gob.mx';
        // $mail->Username = 'gaoc117@gmail.com';
        // $mail->Username = $_ENV['EMAIL_USER'];
        // $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->Password = 'cblwtelkpdhxsnfd';
        // $mail->Password = 'CTN0452-9';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Port = 465;


        $mail->setFrom('x@x.com','la version de dos correosversion nueva y mejorada');
        // $mail->addAddress('gaoc117@gmail.com', 'mesa de ayuda');
        $mail->addAddress('gaoc117@gmail.com', 'mesa de ayuda');
        $mail->addAddress('memocle@hotmail.com', 'mesa de ayuda');
        $mail->Subject = 'Reestablece tu password';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . ". </strong> Has solicitado resstablecer tu password, sigue el siguiente enlace para hacerlo</p>";
        $contenido .= "<p>Presiona aquí: <a href='".$_ENV['APP_URL'] ."/recuperar?token=" . $this->token . "'>Restablecer </a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //enviar email
    //    debuguear($mail->send());
        $mail->send();
       
          
    }
}

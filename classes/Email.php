<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

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
        //CREA EL OBJETO PHP Mamiler
        $mail = new PHPMailer();
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'd97c08c8b15755';
        $mail->Password = '7e5455587e7a8c';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = "Confirma tu cuenta";

        //USAMOS HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        //CONTENIDO EMAIL
        $contenido = "<html>";
        $contenido .= "<p>Hola<strong> " . $this->nombre . " </strong>Has creado tu cuenta en AppSalon, solo debes confirmarla prescionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí <a style='display: inline-block; padding: 1rem; margin: 1rem; background-color: #87CEEB; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); color: #FFFFFF; text-decoration: none;' 
        href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p style='font-size: 16px; line-height: 1.5;'>Si tu no solicitaste esta cuenta , omite el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //ENVIAMOS EMAIL
        $mail->send();
    }

    public function enviarInstrucciones(){
        //CREA EL OBJETO PHP Mamiler
        $mail = new PHPMailer();
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'd97c08c8b15755';
        $mail->Password = '7e5455587e7a8c';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = "Restablece tu password";

        //USAMOS HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        //CONTENIDO EMAIL
        $contenido = "<html>";
        $contenido .= "<p>Hola<strong> " . $this->nombre . " </strong>Has solicitaste el restablecimiento de tu PASSWORD.</p>";
        $contenido .= "<p>Presiona aquí <a style='display: inline-block; padding: 1rem; margin: 1rem; background-color: #87CEEB; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); color: #FFFFFF; text-decoration: none;' 
        href='http://localhost:3000/recuperar?token=" . $this->token . "'>Restablecer Contraseña</a></p>";
        $contenido .= "<p style='font-size: 16px; line-height: 1.5;'>Si tu no solicitaste esta cuenta , omite el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //ENVIAMOS EMAIL
        $mail->send();
    }
}

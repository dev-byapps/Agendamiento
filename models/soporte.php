<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

require_once '../config/conexion.php';
require_once '../models/Soporte.php';

class Soporte extends PHPMailer
{
    protected $gCorreo = 'crm@byapps.co';
    protected $gContrasena = 'ScU*Yp41dS';
    protected $gCorreodestino = "yuliethmontes26@gmail.com";
    protected $gHost = "c1891888.ferozo.com";
    protected $gPort = 587;

    public function enviar_soporte($asunto, $contacto, $mensaje, $usu)
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = $this->gHost;
        $mail->Port = $this->gPort;
        $mail->SMTPAuth = true;
        $mail->Username = $this->gCorreo;
        $mail->Password = $this->gContrasena;
        $mail->SMTPSecure = 'tls';
        $mail->From = $this->gCorreo;
        $mail->FromName = $usu;
        $mail->AddAddress($this->gCorreo, 'Soporte');
        $mail->AddAddress('yuliethmontes26@gmail.com');
        $mail->IsHTML(true);
        $mail->Subject = "Soporte para " . $usu;
        $mail->Body = '
        <body bgcolor="#EDEDED" style="background-color:#EDEDED; margin:0;">
        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFF;">
        <tr><td>
        <table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr><td>
        <table width="670" border="0" cellspacing="0" cellpadding="0">
        <tr><td height="20"></td></tr>
        </table>
        <table width="670" border="0" cellspacing="0" cellpadding="0">
        <tr><td height="15"></td></tr>
        </table>
        <table width="650" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
        <tr><td>
        <table width="628" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr><td height="20"></td></tr>
        </table>
        <table width="628" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr><td height="40" style="text-align:center; font-family: Arial, Verdana, sans-serif; font-size:22px; font-weight:bold; line-height: 18px; color: #000000; border-top: 1px dotted #999;">Solicitud de Soporte</td></tr>
        <tr><td style="text-align:justify; font-family: Arial,Verdana, sans-serif; font-size:12px; line-height: 18px; color: #000000; border-top: 1px dotted #999; border-bottom: 1px dotted #999;">
          <p>Buenas tardes.</P>
          <p><b>Usuario : </b>' . $usu . '</p>
          <p>Solicitamos su colaboracion con el siguiente inconveniente: </P>
          <p><b>Asunto : </b>' . $asunto . '</p>
          <p><b>Mensaje : </b>' . $mensaje . '</p>
          <p><b>Datos de contacto : </b>' . $contacto . '</p>
          <p>Gracias,</p>
          <p>Atentamente,</p>
          <p>' . $usu . '</p>
        </table>
        </td></tr>
        </table>
        <table width="628" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr><td height="20"></td></tr>
      </table>
      <table width="628" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr><td height="12"></td></tr>
      </table>
      </td></tr>
      </table>
      </td></tr>
      </table>
      </td></tr>
      </table>
      </body>';
        $mail->AltBody = 'Este es el cuerpo del mensaje para Clientes no-HTML';

        if (!$mail->Send()) {
            echo 'El Mensaje no pudo ser enviado.';
            echo 'Error del Mailer: ' . $mail->ErrorInfo;
            exit;
        }

        echo 'El Mensaje ha sido enviado';
    }
}

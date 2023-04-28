<?php
include ("../conexion_BD.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


if (!empty($_POST["btn_enviar_C"])) {  
    $User=$_POST['Usuario_Recupera'];
    $R_Fecha_actual = date('Y-m-j');
    $sql=$conexion->query("SELECT * FROM `tbl_ms_usuario` WHERE Usuario='$User'");
        if (mysqli_num_rows($sql) == 0) {
            echo'<script>alert("Usuario Invalido")</script>';
            header("refresh:0;url=../Pantallas/renovar-Contra.php");
        }else {
            //Si Existe el usuario Valide que este activo
            $sql1=$conexion->query("SELECT * FROM tbl_ms_usuario WHERE Usuario='$User' and Estado_Usuario='ACTIVO'");
            //Extrae el correo y el Id del usuario
            if (mysqli_num_rows($sql1) >=1) {
                while($row=mysqli_fetch_array($sql1)){
                    $Correo=$row['Correo_electronico'];
                    $idUser=$row['ID_Usuario'];
                    $NameUser=$row['Nombre_Usuario'];
                }
                $expiry_date = date('Y-m-d H:i:s', strtotime('+24 hours'));

                $sql2=$conexion->query("SELECT * FROM `tbl_ms_parametros` WHERE `ID_Parametro` in(3,4,6)");
                // Verificar si la consulta devolvió resultados
                if (mysqli_num_rows($sql2) >= 1) {
                    // Recorrer los resultados y mostrarlos en pantalla
                    while($row = mysqli_fetch_array($sql2)) {
                        if ($row['ID_Parametro'] == 3) {
                            $P_Correo=$row['Valor'];

                        }
                        if ($row['ID_Parametro'] == 4) {
                            $P_Puerto=$row['Valor'];
                        }

                        if ($row['ID_Parametro'] == 6) {
                            $P_Pass=$row['Valor'];
                        }       
                    }
                }



                        if ($sql1) {
                            //Crear Instancia
                            $mail = new PHPMailer();
                            $mail->CharSet = 'UTF-8';
                            try {
                            //Server settings
                            $mail->SMTPDebug =  0;                    //Enable verbose debug output
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'outlook.office365.com';                     //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = $P_Correo;                     //SMTP username
                            $mail->Password   = $P_Pass;                               //SMTP password
                            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                            $mail->Port       = $P_Puerto;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                            $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                            );
                            //quien envia
                            $mail->setFrom('mugitecno.123@outlook.com', 'Administrador Usuario (Asociacion Creo en ti)');
                            //a quien envia
                            $mail->addAddress($Correo);     //Add a recipient
                            
                            //Generar codigo o contraseña para recuperar la contraseña
                            $length = 10; // longitud de la contraseña deseada
                            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // caracteres permitidos
                            $token = '';
                            for ($i = 0; $i < $length; $i++) {
                                $token .= $chars[mt_rand(0, strlen($chars) - 1)];
                            }


                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Asociacion Creo en Ti: Solicitud de restablecimiento de contraseña';
                            //Estructura del Mensaje
                            $mail->Body    =                        
                            '<!DOCTYPE html>
                            <html lang="en">
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                                    <meta name="viewport" content="width=device-width, initial-scale=1"/>
                                    <title></title>
                                    <style type="text/css">
                                        h1{
                                            color: #057a05;
                                        }
                                        p{
                                            font-size: 14px;
                                        }
                                        img{
                                            width: 10rem;
                                            height: 10rem;
                                        }
                                    </style>
                                </head>
                                <body>
                                <h1>Hola ' .$NameUser.'</h1>
                                <p>Usted a solicitado un restablecimiento de contraseña, para el acceso al sistema de la Asociacion Creo en Ti.</p>

                                <p>Para confirmar esta peticion y establecer una nueva contraseña, por favor presione la siguiente direccion: 
                                <a href="http://localhost:90/Sistema-administrativo-de-fondos-y-proyectos/Pantallas/Nueva_Contra.php">Cambiar Contraseña</a></p>

                                <b><p>(Por favor realiza el cambio de contraseña, ya que el token proporcionada es valido durante 24 horas desde el momento en que hizo la solicitud.)</b></p></b> 

                                <p>Su token es:, <b>Token:'.$token;' </p>
                                
                            
                                </body>';


                            $mail->send();
                            echo'<script>alert("Correo Enviado Satisfactoriamente")</script>';
                            header("refresh:0;url=../Pantallas/Login.php");

                            //La contraseña se Autoingresa 
                            $sql3=$conexion->query("UPDATE tbl_ms_usuario SET Token='$token', Fecha_Vencimiento='$expiry_date', Modificado_Por='$User', Fecha_Modificacion='$R_Fecha_actual' WHERE ID_Usuario='$idUser'");
                           

                            } catch (Exception $e) {
                            echo'<script>alert("Error en el Envio de Correo")</script>';
                            header("refresh:0;url=../Pantallas/Login.php");
                            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }
                    } 

            }else {
                //Si Existe el usuario pero si esta bloqueado o es nuevo, no le permita recuperar la contraseña
                echo'<script>alert("Lo sentimos, por favor comuniquese con el Administrador")</script>';
                header("refresh:0;url=../Pantallas/Login.php");
            }
        }
}

?>


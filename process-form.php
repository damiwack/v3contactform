<?php

// Verificar si se ha enviado el formulario
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['email']) && isset($_POST['consulta']) && isset($_POST['g-recaptcha-response'])) {
  // Recibir los datos del formulario
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $telefono = $_POST['telefono'];
  $email = $_POST['email'];
  $consulta = $_POST['consulta'];
  $captcha = $_POST['g-recaptcha-response'];

  // Validar el captcha
  $secret = "YOURSERVERKEY";
  $remoteip = $_SERVER['REMOTE_ADDR'];
$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$remoteip";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$verify = json_decode($response);


  if ($verify->success) {
    // Si el captcha es válido, procesar el formulario

    // Crear el mensaje del correo electrónico
    $mensaje = "Nombre: $nombre\nApellido: $apellido\nTeléfono: $telefono\nCorreo electrónico: $email\nConsulta: $consulta\n";

    // Establecer cabeceras del correo electrónico
    $headers = 'From: SITEMAIL' . "\r\n" .
    'Reply-To: SITEMAIL' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    // Enviar el correo electrónico
    mail('MAILTO', 'Consulta desde el formulario de contacto', $mensaje, $headers);
  }
  else {
      echo "falla";
  }
  
}
?>
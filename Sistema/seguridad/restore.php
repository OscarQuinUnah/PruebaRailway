<?php
// Configuración de la base de datos
$host = "localhost";
$user = 'root';
$password = '';
$database = 'bd_asociacion_creo_en_ti';
// Ruta absoluta de la carpeta de backups
// Configuración de la base de datos

// Obtener la ruta absoluta del archivo de backup seleccionado
$backup_file = "C:/xampp/htdocs/Sistema-administrativo-de-fondos-y-proyectos/Sistema/seguridad/Backups/" . $_POST['backup_file'];

// Crear la conexión PDO
if (file_exists($backup_file) && pathinfo($backup_file, PATHINFO_EXTENSION) == 'sql') {
try {
  $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
  ];
  $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
  echo "Error al conectar a la base de datos: " . $e->getMessage();
  exit();
}

// Desactivar las restricciones de clave externa
$pdo->exec("SET foreign_key_checks = 0;");

// Leer el archivo de backup
try {
  $sql = file_get_contents($backup_file);
} catch (Exception $e) {
  echo "Error al leer el archivo de backup: " . $e->getMessage();
  exit();
}

// Activar las restricciones de clave externa

// Ejecutar el script SQL del backup
try {
  $pdo->exec($sql);
  $pdo->exec("SET foreign_key_checks = 1;");
  echo "<script language='JavaScript'>
                alert('La base de datos se ha restaurado exitosamente.');
            location.assign('Backups_BD.php');
            </script>";
            require_once "../../EVENT_BITACORA.php";
            $model = new EVENT_BITACORA;
            session_start();
            $model->backupres();
} catch (PDOException $e) {
  $pdo->exec("SET foreign_key_checks = 1;");
  echo "<script language='JavaScript'>
                alert('hubo un error inesperado, no se pudo restaurar la base de datos.');
            location.assign('Backups_BD.php');
            </script>";
}
}else{
  echo "<script language='JavaScript'>
                alert('El archivo de backup seleccionado no es valido, Eliga un archivo valido.');
            location.assign('Backups_BD.php');
            </script>";
}
?>
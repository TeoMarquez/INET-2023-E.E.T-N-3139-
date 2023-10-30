<?php
$servidorBD = "mysql:host=localhost;dbname=inet_aulas_moviles";
$usuario = "root";
$password = "12345678";

try {
    $pdo = new PDO($servidorBD, $usuario, $password);
    $pdo->exec("SET CHARACTER SET utf8");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    die("Error en la conexión al servidor: " . $e->getMessage());
}
?>

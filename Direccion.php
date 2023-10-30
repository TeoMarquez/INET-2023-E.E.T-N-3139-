<?php
if (isset($_GET["nombre_institucion"])) {
    try {
        include_once 'ConexionBD.php';

        // Obtener el nombre de la institución desde la URL
        $nombreInstitucion = '%' . $_GET["nombre_institucion"] . '%';

        // Consulta SQL para obtener las direcciones en base al nombre de la institución
        $consultaSQL = "SELECT direcciones.direccion
                        FROM direcciones
                        WHERE direcciones.instit_id = (SELECT instituciones.Instit_Id FROM instituciones WHERE instituciones.Nombre LIKE :nombreInstitucion)
                        LIMIT 0, 25";

        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":nombreInstitucion", $nombreInstitucion, PDO::PARAM_STR);
        $resultado->execute();

        // Inicializar una variable para almacenar la información de direcciones
        $direcciones = "";

        // Iterar a través de los resultados y construir una cadena con la información
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $direcciones .= "Dirección: " . $row['direccion'] . "<br>";
        }

        echo $direcciones;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

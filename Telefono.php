<?php
if (isset($_GET["nombre_institucion"])) {
    try {
        include_once 'ConexionBD.php';

        $nombreInstitucion = '%' . $_GET["nombre_institucion"] . '%';

        // Consulta SQL para obtener los teléfonos en base al nombre de la institución
        $consultaSQL = "SELECT telefono
                        FROM contactos
                        WHERE contactos.instit_id = (SELECT instituciones.Instit_Id FROM instituciones WHERE instituciones.Nombre LIKE :nombreInstitucion)
                        LIMIT 0, 25";

        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":nombreInstitucion", $nombreInstitucion, PDO::PARAM_STR);
        $resultado->execute();

        // Inicializar una variable para almacenar los números de teléfono
        $telefonos = "";

        // Iterar a través de los resultados y construir una cadena con los números de teléfono
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $telefonos .= "Teléfono: " . $row['telefono'] . "<br>";
        }

        echo $telefonos;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

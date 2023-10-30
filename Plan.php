<?php
if (isset($_GET["nombre_institucion"])) {
    try {
        include_once 'ConexionBD.php';

        // Obtener el nombre de la institución desde la URL
        $nombreInstitucion = '%' . $_GET["nombre_institucion"] . '%';

        // Consulta SQL para obtener los nombres de los planes de estudio en base al nombre de la institución
        $consultaSQL = "SELECT planes_estudio.nombre
                        FROM planes_estudio
                        WHERE planes_estudio.instit_Id = (SELECT instituciones.Instit_Id FROM instituciones WHERE instituciones.Nombre LIKE :nombreInstitucion)
                        LIMIT 0, 25";

        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":nombreInstitucion", $nombreInstitucion, PDO::PARAM_STR);
        $resultado->execute();

        // Inicializar una variable para almacenar los nombres de los planes de estudio
        $nombresPlanes = "";

        // Iterar a través de los resultados y construir una cadena con la información
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $nombresPlanes .= "Nombre del Plan de Estudio: " . $row['nombre'] . "<br>";
        }

        echo $nombresPlanes;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

<?php
if (isset($_GET["nombre_institucion"])) {
    try {
        include_once 'ConexionBD.php';

        $nombreInstitucion = '%' . $_GET["nombre_institucion"] . '%';

        // Consulta SQL para obtener los sectores en base al nombre de la institución
        $consultaSQL = "SELECT sectores.Descripcion
                        FROM sectores
                        JOIN planes_estudio ON sectores.Id = planes_estudio.sector_id
                        JOIN instituciones ON planes_estudio.instit_Id = instituciones.Instit_Id
                        WHERE instituciones.Nombre LIKE :nombreInstitucion
                        LIMIT 0, 25";

        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":nombreInstitucion", $nombreInstitucion, PDO::PARAM_STR);
        $resultado->execute();

        // Inicializar una variable para almacenar las descripciones de sectores
        $descripcionSectores = "";

        // Iterar a través de los resultados y construir una cadena con las descripciones de sectores
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $descripcionSectores .= "Sector: " . $row['Descripcion'] . "<br>";
        }

        echo $descripcionSectores;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

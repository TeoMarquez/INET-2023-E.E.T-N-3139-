<?php
if (isset($_GET["nombre_institucion"])) {
    try {
        include_once 'ConexionBD.php';

        $nombreInstitucion = '%' . $_GET["nombre_institucion"] . '%';

        // Consulta SQL para obtener los nombres de las ofertas en base al nombre de la institución
        $consultaSQL = "SELECT ofertas.Nombre
                        FROM ofertas
                        JOIN planes_estudio ON ofertas.Id = planes_estudio.oferta_id
                        JOIN instituciones ON planes_estudio.instit_Id = instituciones.Instit_Id
                        WHERE instituciones.Nombre LIKE :nombreInstitucion";

        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":nombreInstitucion", $nombreInstitucion, PDO::PARAM_STR);
        $resultado->execute();

        // Inicializar una variable para almacenar los nombres de las ofertas
        $nombresOfertas = "";

        // Iterar a través de los resultados y construir una cadena con los nombres de las ofertas
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $nombresOfertas .= $row['Nombre'] . "<br>";
        }

        echo $nombresOfertas;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

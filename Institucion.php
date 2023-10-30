<?php
if (isset($_GET["juridiccion"]) && isset($_GET["departamento"]) && isset($_GET["localidad"])) {
    try {
        include_once 'ConexionBD.php';

        // Obtener la jurisdicción, departamento y localidad seleccionados desde la URL
        $juridiccionSeleccionada = $_GET["juridiccion"];
        $departamentoSeleccionado = $_GET["departamento"];
        $localidadSeleccionada = $_GET["localidad"];

        // Consulta SQL para obtener el nombre de las instituciones en base a la jurisdicción, el departamento y la localidad
        $consultaSQL = "SELECT instituciones.Nombre
                        FROM instituciones
                        WHERE instit_id IN (
                            SELECT direcciones.instit_id
                            FROM direcciones
                            WHERE direcciones.jurisdiccion_id = :juridiccionSeleccionada
                            AND direcciones.departamento_id = :departamentoSeleccionado
                            AND direcciones.localidad_id = :localidadSeleccionada
                        )";

        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":juridiccionSeleccionada", $juridiccionSeleccionada, PDO::PARAM_INT);
        $resultado->bindParam(":departamentoSeleccionado", $departamentoSeleccionado, PDO::PARAM_INT);
        $resultado->bindParam(":localidadSeleccionada", $localidadSeleccionada, PDO::PARAM_INT);
        $resultado->execute();

        // Inicializar una variable para almacenar los nombres de las instituciones
        $nombresInstituciones = "";

        // Iterar a través de los resultados y construir una cadena con los nombres
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $nombresInstituciones .= "Nombre de la Institución: " . $row['Nombre'] . "<br>";
        }

        echo $nombresInstituciones;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

<?php
if (isset($_GET["provincia"]) && isset($_GET["departamento"])) {
    try {
        include_once 'ConexionBD.php';

        // Obtener la provincia y departamento seleccionados desde la URL
        $provinciaSeleccionada = $_GET["provincia"];
        $departamentoSeleccionado = $_GET["departamento"];

        // Consulta SQL para obtener las localidades en base a la provincia y el departamento
        $consultaSQL = "SELECT Id, Descripcion FROM localidades 
                        WHERE localidades.Jurisdiccion_Id = (SELECT Id FROM jurisdicciones WHERE Descripcion = :provinciaSeleccionada) 
                        AND localidades.Departamento_Id = (SELECT Id FROM departamentos WHERE Descripcion LIKE :departamentoSeleccionado)";

        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":provinciaSeleccionada", $provinciaSeleccionada, PDO::PARAM_STR);
        // Usamos LIKE en el departamento para permitir coincidencias parciales
        $departamentoSeleccionado = '%' . $departamentoSeleccionado . '%';
        $resultado->bindParam(":departamentoSeleccionado", $departamentoSeleccionado, PDO::PARAM_STR);
        $resultado->execute();

        // Construir el código HTML para las opciones del select-localidad
        $localidadesHTML = '<option value="-1">Seleccione una localidad:</option>';
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $localidadesHTML .= '<option value="' . $row['Id'] . '">' . $row['Descripcion'] . '</option>';
        }

        echo $localidadesHTML;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

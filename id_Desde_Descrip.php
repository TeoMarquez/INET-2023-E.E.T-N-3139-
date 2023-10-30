<?php
if (isset($_GET["provincia"])) {
    try {
        include_once 'ConexionBD.php';

        // Obtener la provincia seleccionada desde la URL
        $provinciaSeleccionada = $_GET["provincia"];

        // Consulta SQL para obtener los departamentos relacionados con la provincia seleccionada
        $consultaSQL = "SELECT Id, Descripcion FROM departamentos WHERE departamentos.Jurisdiccion_Id = (SELECT Id FROM jurisdicciones WHERE Descripcion = :provinciaSeleccionada)";
        $resultado = $pdo->prepare($consultaSQL);
        $resultado->bindParam(":provinciaSeleccionada", $provinciaSeleccionada, PDO::PARAM_STR);
        $resultado->execute();

        // Construye el código HTML para las opciones del select-departamento
        $departamentosHTML = '<option value="-1">Seleccione un departamento:</option>';
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $departamentosHTML .= '<option value="' . $row['Id'] . '">' . $row['Descripcion'] . '</option>';
        }

        echo $departamentosHTML;
    } catch (Exception $e) {
        die("ERROR al realizar la consulta: " . $e->getMessage());
    }
}
?>

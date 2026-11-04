<?php

include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "UPDATE tbmaquillaje SET
              codigo=?, nombre=?, marca=?, categoria=?, tipo_piel=?, tono_piel=?,
              subtono=?, precio=?, link_imagen=?, ingredientes=?
            WHERE id=?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssdssi",
        $_POST["codigo"], $_POST["nombre"], $_POST["marca"], $_POST["categoria"],
        $_POST["tipo_piel"], $_POST["tono_piel"], $_POST["subtono"],
        $_POST["precio"], $_POST["link_imagen"], $_POST["ingredientes"], $_POST["id"]);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msg=actualizado");
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
    exit;
}
header("Location: index.php");
?>

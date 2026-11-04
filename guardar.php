<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibimos y limpiamos
    $codigo      = trim($_POST["codigo"] ?? "");
    $nombre      = trim($_POST["nombre"] ?? "");
    $marca       = trim($_POST["marca"] ?? "");
    $categoria   = trim($_POST["categoria"] ?? "");
    $tipo_piel   = trim($_POST["tipo_piel"] ?? "");
    $tono_piel   = trim($_POST["tono_piel"] ?? "");
    $subtono     = trim($_POST["subtono"] ?? "");
    $precio      = floatval($_POST["precio"] ?? 0);
    $link_imagen = trim($_POST["link_imagen"] ?? "");
    $ingredientes= trim($_POST["ingredientes"] ?? "");

    // Si la imagen viene vacía, la mandamos como NULL
    if ($link_imagen === "") { $link_imagen = null; }

    // 🚨 AQUÍ ESTÁ LA CLAVE: Si el código viene vacío, no lo insertes
    if ($codigo === "") {
        die("Error: El campo 'codigo' está vacío. Revisa tu formulario.");
    }

    $sql = "INSERT INTO tbmaquillaje
            (codigo, nombre, marca, categoria, tipo_piel, tono_piel, subtono, precio, link_imagen, ingredientes)
            VALUES (?,?,?,?,?,?,?,?,?,?)";
            
    $stmt = mysqli_prepare($conexion, $sql);

    if (!$stmt) {
        die("Error en la preparación: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "sssssssdss",
        $codigo, $nombre, $marca, $categoria,
        $tipo_piel, $tono_piel, $subtono,
        $precio, $link_imagen, $ingredientes);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msg=guardado");
        exit;
    } else {
        echo "Error al guardar: " . mysqli_stmt_error($stmt);
    }
} else {
    header("Location: index.php");
    exit;
}
?>
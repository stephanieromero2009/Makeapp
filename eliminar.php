<?php
// =====================================================
// eliminar.php - Borra un producto. Se llama con: eliminar.php?id=3
// =====================================================
include "conexion.php";

$id = intval($_GET["id"] ?? 0);
$stmt = mysqli_prepare($conexion, "DELETE FROM tbmaquillaje WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: index.php?msg=eliminado");
?>

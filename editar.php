<?php
// =====================================================
// editar.php - Muestra el formulario con los datos del producto a modificar
// Se llega aquí desde index.php con: editar.php?id=3
// =====================================================
include "conexion.php";

$id = intval($_GET["id"] ?? 0); // intval convierte a número (seguridad)
$res = mysqli_query($conexion, "SELECT * FROM tbmaquillaje WHERE id = $id");
$p = mysqli_fetch_assoc($res);
if (!$p) { die("Producto no encontrado"); }

// Función pequeña para marcar la opción seleccionada en los <select>
function sel($a, $b) { return $a === $b ? "selected" : ""; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar producto · GlowMatch</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main class="contenedor">
    <section class="panel">
      <h2>✏️ Editar: <?= htmlspecialchars($p["nombre"]) ?></h2>

      <!-- El formulario envía los cambios a actualizar.php -->
      <form action="actualizar.php" method="POST" class="formulario">
        <input type="hidden" name="id" value="<?= $p["id"] ?>">
        <input name="codigo" value="<?= htmlspecialchars($p["codigo"]) ?>" required>
        <input name="nombre" value="<?= htmlspecialchars($p["nombre"]) ?>" required>
        <input name="marca" value="<?= htmlspecialchars($p["marca"]) ?>" required>
        <input name="categoria" value="<?= htmlspecialchars($p["categoria"]) ?>" required>
        <select name="tipo_piel">
          <?php foreach (["seca","grasa","mixta","sensible"] as $o): ?>
            <option <?= sel($o, $p["tipo_piel"]) ?>><?= $o ?></option>
          <?php endforeach; ?>
        </select>
        <select name="tono_piel">
          <?php foreach (["clara","media","morena","oscura"] as $o): ?>
            <option <?= sel($o, $p["tono_piel"]) ?>><?= $o ?></option>
          <?php endforeach; ?>
        </select>
        <select name="subtono">
          <?php foreach (["frio","calido","neutro"] as $o): ?>
            <option <?= sel($o, $p["subtono"]) ?>><?= $o ?></option>
          <?php endforeach; ?>
        </select>
        <input name="precio" type="number" step="0.01" value="<?= $p["precio"] ?>" required>
        <input name="link_imagen" value="<?= htmlspecialchars($p["link_imagen"]) ?>">
        <textarea name="ingredientes" rows="3"><?= htmlspecialchars($p["ingredientes"]) ?></textarea>
        <button class="btn">Guardar cambios</button>
        <a href="index.php" class="btn btn-sec">Cancelar</a>
      </form>
    </section>
  </main>
</body>
</html>

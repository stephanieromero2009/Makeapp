<?php
include "conexion.php";
$tono = $_GET["tono"] ?? "";
$piel = $_GET["piel"] ?? "";

$tonos = ["clara","media","morena","oscura"];
$pieles = ["seca","grasa","mixta","sensible"];
$sql = "SELECT * FROM tbmaquillaje WHERE 1=1";
if (in_array($tono, $tonos))  { $sql .= " AND tono_piel = '$tono'"; }
if (in_array($piel, $pieles)) { $sql .= " AND tipo_piel = '$piel'"; }
$sql .= " ORDER BY precio DESC";

$resultado = mysqli_query($conexion, $sql);
$comedogenicos = ["isopropyl myristate","isopropyl palmitate","lanolin","coconut oil","cera alba","talc"];
function alertaPoros($ingredientes, $lista) {
    $encontrados = [];
    foreach ($lista as $ing) {
        if (stripos($ingredientes, $ing) !== false) { $encontrados[] = $ing; }
    }
    return $encontrados;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Makeapp </title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,600&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header class="menu">
  <a href="#" class="logo">Make<span>App</span></a>
  <nav>
    <a href="#propuesta">Propuesta</a>
    <a href="#probador">Probador</a>
    <a href="#catalogo">Catálogo</a>
  </nav>
</header>
<section class="hero">
  <h1>Encuentra tu <em>make</em> perfecto</h1>
  <p class="frase-hero">“No seas bonita como ellas, sé bonita como tú”</p>
  <a href="#probador" class="btn btn-hero">✨ Probar ahora</a>
</section>

<main class="contenedor">
<section id="propuesta">
  <article class="panel">
    <h2> Idea</h2>
    <p>Makeapp es una tienda web donde te pruebas maquillaje con la cámara del navegador sin descargar nada. Te dice tu <b>subtono</b> (frío, cálido o neutro) y te avisa de <b>ingredientes dañinos</b> para tu piel.</p>
    <p><b>Objetivo:</b> resolver que al comprar maquillaje en línea no sabes si el tono te queda ni si te irrita la piel.</p>
  </article>
</section>
<section id="probador" class="panel">
  <h2> Probador virtual</h2>
  <p>Activa tu cámara, coloca tu rostro dentro de la guía y elige un tono.</p>

  <div class="probador">
    <div class="camara" id="camara">
      <video id="video" autoplay playsinline muted></video>
      <div class="capa-maquillaje" id="capaBase"></div>
      <div class="capa-maquillaje" id="capaPolvo"></div>
      <div class="capa-maquillaje" id="capaContorno"></div>
      <div class="capa-maquillaje" id="capaRubor"></div>
      <div class="capa-maquillaje" id="capaIluminador"></div>
      <div class="capa-maquillaje" id="capaLabios"></div>

      <div class="luz dia" id="luz"></div>

      <p class="aviso" id="aviso">La cámara está apagada</p>
    </div>

    <div class="controles">
      <button class="btn" id="btnCamara">📷 Encender cámara</button>
      
      <h3>Tono de labial</h3>
      <div class="colores" id="colores">
        <button data-color="#C2185B" style="background:#C2185B" title="Frío"></button>
        <button data-color="#D81B60" style="background:#D81B60" title="Neutro"></button>
        <button data-color="#E5675B" style="background:#E5675B" title="Cálido"></button>
        <button data-color="#7B1F4B" style="background:#7B1F4B" title="Frío"></button>
        <button data-color="#B5651D" style="background:#B5651D" title="Cálido"></button>
      </div>
      <label>Intensidad <input type="range" id="intensidad" min="0.2" max="0.9" step="0.05" value="0.55"></label>

      <h3>Tono de base</h3>
      <div class="colores" id="base">
        <button data-color="#FBE5D6" style="background:#FBE5D6" title="Marfil"></button>
        <button data-color="#E8C4A0" style="background:#E8C4A0" title="Beige claro"></button>
        <button data-color="#C9956B" style="background:#C9956B" title="Beige medio"></button>
        <button data-color="#A66B45" style="background:#A66B45" title="Canela"></button>
        <button data-color="#75452F" style="background:#75452F" title="Café profundo"></button>
      </div>
      <label>Intensidad <input type="range" id="intensidadBase" min="0.2" max="0.9" step="0.05" value="0.55"></label>

      <h3>Tono de iluminador</h3>
      <div class="colores" id="iluminador">
        <button data-color="#FFF1D6" style="background:#FFF1D6" title="Perlado"></button>
        <button data-color="#F7DDAA" style="background:#F7DDAA" title="Champán"></button>
        <button data-color="#EBC078" style="background:#EBC078" title="Dorado"></button>
        <button data-color="#DDA0A6" style="background:#DDA0A6" title="Rosa dorado"></button>
        <button data-color="#B97845" style="background:#B97845" title="Bronce"></button>
      </div>
      <label>Intensidad <input type="range" id="intensidadIluminador" min="0.2" max="0.9" step="0.05" value="0.55"></label>

      <h3>Tono de rubor</h3>
      <div class="colores" id="rubor">
        <button data-color="#F4A6B8" style="background:#F4A6B8" title="Rosa suave"></button>
        <button data-color="#EFA08A" style="background:#EFA08A" title="Durazno"></button>
        <button data-color="#E5675B" style="background:#E5675B" title="Coral"></button>
        <button data-color="#C65D78" style="background:#C65D78" title="Rosa intenso"></button>
        <button data-color="#96516B" style="background:#96516B" title="Ciruela"></button>
      </div>
      <label>Intensidad <input type="range" id="intensidadRubor" min="0.2" max="0.9" step="0.05" value="0.55"></label>

      <h3>Tono de contorno</h3>
      <div class="colores" id="contorno">
        <button data-color="#C7A58A" style="background:#C7A58A" title="Topo claro"></button>
        <button data-color="#A98265" style="background:#A98265" title="Café neutro"></button>
        <button data-color="#986746" style="background:#986746" title="Café cálido"></button>
        <button data-color="#754B35" style="background:#754B35" title="Café oscuro"></button>
        <button data-color="#503323" style="background:#503323" title="Café profundo"></button>
      </div>
      <label>Intensidad <input type="range" id="intensidadContorno" min="0.2" max="0.9" step="0.05" value="0.55"></label>

      <h3>Tono de polvo</h3>
      <div class="colores" id="polvo">
        <button data-color="#FFF8EC" style="background:#FFF8EC" title="Traslúcido"></button>
        <button data-color="#F5E3C7" style="background:#F5E3C7" title="Marfil"></button>
        <button data-color="#DFC09A" style="background:#DFC09A" title="Beige"></button>
        <button data-color="#C49A6C" style="background:#C49A6C" title="Miel"></button>
        <button data-color="#916342" style="background:#916342" title="Café"></button>
      </div>
      <label>Intensidad <input type="range" id="intensidadPolvo" min="0.2" max="0.9" step="0.05" value="0.55"></label>

      <h3>Simulador de luz</h3>
      <div class="luces">
        <button class="chip activo" data-luz="dia">☀️ Día</button>
        <button class="chip" data-luz="fiesta">🪩 Fiesta</button>
        <button class="chip" data-luz="oficina">🏢 Oficina</button>
      </div>

      <h3>¿Cuál es tu subtono?</h3>
      <p class="peq">Mira las venas de tu muñeca:</p>
      <div class="luces">
        <button class="chip" data-sub="frio">Azules / moradas</button>
        <button class="chip" data-sub="calido">Verdes</button>
        <button class="chip" data-sub="neutro">No sé / ambas</button>
      </div>
      <p id="resultadoSub" class="resultado"></p>
    </div>
  </div>
</section>

<!-- ================= CATÁLOGO ================= -->
<section id="catalogo">
  <h2 class="titulo">✨ Catálogo</h2>

  <form method="GET" action="index.php#catalogo" class="filtros">
    <select name="tono">
      <option value="">Todos los tonos</option>
      <?php foreach ($tonos as $t): ?>
        <option value="<?= $t ?>" <?= $tono === $t ? "selected" : "" ?>><?= ucfirst($t) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="piel">
      <option value="">Todo tipo de piel</option>
      <?php foreach ($pieles as $t): ?>
        <option value="<?= $t ?>" <?= $piel === $t ? "selected" : "" ?>><?= ucfirst($t) ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn">Filtrar</button>
    <a href="index.php#catalogo" class="btn btn-sec">Limpiar</a>
  </form>

  <div class="cards">
  <?php if (mysqli_num_rows($resultado) === 0): ?>
    <p>No hay productos con esos filtros.</p>
  <?php endif; ?>

  <?php while ($p = mysqli_fetch_assoc($resultado)):
        $alertas = alertaPoros($p["ingredientes"], $comedogenicos);

        // ✅ Detectar color HEX dentro del nombre
        $colorHex = null;
        if (preg_match('/#([A-Fa-f0-9]{6})/', $p["nombre"], $m)) {
            $colorHex = '#' . $m[1];
        }
  ?>
    <article class="card">
      <img src="<?= htmlspecialchars($p["link_imagen"]) ?>" alt="<?= htmlspecialchars($p["nombre"]) ?>">
      <div class="card-body">
        <small><?= htmlspecialchars($p["marca"]) ?> · <?= htmlspecialchars($p["codigo"]) ?></small>
        <h3><?= htmlspecialchars($p["nombre"]) ?></h3>

        <?php if ($colorHex): ?>
          <div style="display:flex; align-items:center; gap:.6rem; margin:.5rem 0;">
            <span style="display:inline-block; width:28px; height:28px; border-radius:50%;
                         background:<?= $colorHex ?>;
                         border:3px solid #fff;
                         box-shadow:0 2px 6px rgba(0,0,0,.25);"></span>
            <small style="color:var(--fucsia-osc); font-weight:600;"><?= $colorHex ?></small>
          </div>
        <?php endif; ?>

        <div class="etiquetas">
          <span><?= $p["categoria"] ?></span>
          <span><?= $p["tipo_piel"] ?></span>
          <span><?= $p["tono_piel"] ?></span>
          <span><?= $p["subtono"] ?></span>
        </div>
        <?php if ($alertas): ?>
          <p class="alerta">⚠️ Puede tapar poros</p>
        <?php endif; ?>
        <p class="precio">$<?= number_format($p["precio"], 2) ?></p>

        <button class="btn btn-sm ver-ing"
          data-nombre="<?= htmlspecialchars($p["nombre"]) ?>"
          data-ing="<?= htmlspecialchars($p["ingredientes"]) ?>"
          data-alertas="<?= htmlspecialchars(implode(", ", $alertas)) ?>">🔬 Ingredientes</button>

        <div class="acciones">
          <a href="editar.php?id=<?= $p["id"] ?>">✏️ Editar</a>
          <a href="eliminar.php?id=<?= $p["id"] ?>" onclick="return confirm('¿Eliminar este producto?')">🗑️ Eliminar</a>
        </div>
      </div>
    </article>
  <?php endwhile; ?>
  </div>
</section>
<section class="panel">
  <h2> Agregar producto</h2>
  <form action="guardar.php" method="POST" class="formulario">
    <input name="codigo" placeholder="Código (LAB-005)" required>
    <input name="nombre" placeholder="Nombre" required>
    <input name="marca" placeholder="Marca" required>
    <input name="categoria" placeholder="Categoría (labial, base...)" required>
    <select name="tipo_piel"><?php foreach ($pieles as $t) echo "<option>$t</option>"; ?></select>
    <select name="tono_piel"><?php foreach ($tonos as $t) echo "<option>$t</option>"; ?></select>
    <select name="subtono"><option>frio</option><option>calido</option><option>neutro</option></select>
    <input name="precio" type="number" step="0.01" placeholder="Precio" required>
    <input name="link_imagen" placeholder="URL de la imagen">
    <textarea name="ingredientes" rows="3" placeholder=""></textarea>
    <button class="btn">Guardar</button>
  </form>
</section>

</main>
<div class="modal" id="modal">
  <div class="modal-caja">
    <button class="cerrar" id="cerrarModal">×</button>
    <h3 id="modalTitulo"></h3>
    <ul id="modalLista"></ul>
    <p id="modalAlerta" class="alerta"></p>
  </div>
</div>

<footer> Makeapp </footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const video      = document.getElementById('video');
  const btnCamara  = document.getElementById('btnCamara');
  const aviso      = document.getElementById('aviso');
  const luz        = document.getElementById('luz');

  const capas = {
    labios:     document.getElementById('capaLabios'),
    base:       document.getElementById('capaBase'),
    polvo:      document.getElementById('capaPolvo'),
    contorno:   document.getElementById('capaContorno'),
    rubor:      document.getElementById('capaRubor'),
    iluminador: document.getElementById('capaIluminador')
  };

  const sliders = {
    labios:     document.getElementById('intensidad'),
    base:       document.getElementById('intensidadBase'),
    polvo:      document.getElementById('intensidadPolvo'),
    contorno:   document.getElementById('intensidadContorno'),
    rubor:      document.getElementById('intensidadRubor'),
    iluminador: document.getElementById('intensidadIluminador')
  };

  const resultadoSub = document.getElementById('resultadoSub');
  let stream = null;
  let camaraActiva = false;

  const coloresSeleccionados = {
    labios:     '#C2185B',
    base:       '#E8C4A0',
    polvo:      '#F5E3C7',
    contorno:   '#A98265',
    rubor:      '#F4A6B8',
    iluminador: '#FFF1D6'
  };

  
  function actualizarCapa(capa, color, intensidad) {
    if (!capa) return;
    capa.style.backgroundColor = color;
    capa.style.opacity = intensidad;
  }

  function configurarColores(contenedorId, tipo) {
    const contenedor = document.getElementById(contenedorId);
    if (!contenedor) return;
    const capa = capas[tipo];
    const slider = sliders[tipo];

    contenedor.addEventListener('click', (e) => {
      const btn = e.target.closest('button');
      if (!btn) return;
      contenedor.querySelectorAll('button').forEach(b => b.classList.remove('activo'));
      btn.classList.add('activo');
      coloresSeleccionados[tipo] = btn.dataset.color;
      actualizarCapa(capa, btn.dataset.color, parseFloat(slider.value));
    });

    const primerBtn = contenedor.querySelector('button');
    if (primerBtn) {
      primerBtn.classList.add('activo');
      coloresSeleccionados[tipo] = primerBtn.dataset.color;
      actualizarCapa(capa, primerBtn.dataset.color, parseFloat(slider.value));
    }

    slider.addEventListener('input', (e) => {
      actualizarCapa(capa, coloresSeleccionados[tipo], parseFloat(e.target.value));
    });
  }

  configurarColores('colores',    'labios');
  configurarColores('base',       'base');
  configurarColores('iluminador', 'iluminador');
  configurarColores('rubor',      'rubor');
  configurarColores('contorno',   'contorno');
  configurarColores('polvo',      'polvo');

  async function encenderCamara() {
    try {
      stream = await navigator.mediaDevices.getUserMedia({
        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
        audio: false
      });
      video.srcObject = stream;
      camaraActiva = true;
      aviso.style.opacity = '0';
      setTimeout(() => { aviso.style.display = 'none'; }, 300);
      btnCamara.textContent = '📷 Apagar cámara';
    } catch (error) {
      console.error('Error al acceder a la cámara:', error);
      aviso.textContent = 'No se pudo acceder a la cámara.';
    }
  }

  function apagarCamara() {
    if (stream) {
      stream.getTracks().forEach(track => track.stop());
      stream = null;
    }
    video.srcObject = null;
    camaraActiva = false;
    aviso.style.display = 'grid';
    aviso.style.opacity = '1';
    aviso.textContent = 'La cámara está apagada';
    btnCamara.textContent = '📷 Encender cámara';
  }

  btnCamara.addEventListener('click', () => {
    camaraActiva ? apagarCamara() : encenderCamara();
  });

  const botonesLuz = document.querySelectorAll('[data-luz]');
  botonesLuz.forEach(btn => {
    btn.addEventListener('click', () => {
      botonesLuz.forEach(b => b.classList.remove('activo'));
      btn.classList.add('activo');
      luz.classList.remove('dia', 'fiesta', 'oficina');
      luz.classList.add(btn.dataset.luz);
    });
  });

  const botonesSub = document.querySelectorAll('[data-sub]');
  const mensajesSub = {
    frio:   '✨ Subtono frío: te favorecen los tonos rosados, azulados y frambuesa.',
    calido: '✨ Subtono cálido: te favorecen los tonos dorados, durazno y coral.',
    neutro: '✨ Subtono neutro: te favorecen tanto tonos fríos como cálidos.'
  };

  botonesSub.forEach(btn => {
    btn.addEventListener('click', () => {
      botonesSub.forEach(b => b.classList.remove('activo'));
      btn.classList.add('activo');
      resultadoSub.textContent = mensajesSub[btn.dataset.sub] || '';
    });
  });

  window.addEventListener('beforeunload', () => {
    if (stream) stream.getTracks().forEach(t => t.stop());
  });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal');
  const cerrarModal = document.getElementById('cerrarModal');
  const modalTitulo = document.getElementById('modalTitulo');
  const modalLista  = document.getElementById('modalLista');
  const modalAlerta = document.getElementById('modalAlerta');

  document.querySelectorAll('.ver-ing').forEach(btn => {
    btn.addEventListener('click', () => {
      modalTitulo.textContent = btn.dataset.nombre || '';
      modalLista.innerHTML = '';
      (btn.dataset.ing || '').split(',').forEach(ing => {
        if (ing.trim()) {
          const li = document.createElement('li');
          li.textContent = ing.trim();
          modalLista.appendChild(li);
        }
      });
      const alertas = btn.dataset.alertas || '';
      modalAlerta.textContent = alertas ? '⚠️ Contiene: ' + alertas : '';
      modal.classList.add('abierto');
    });
  });

  cerrarModal?.addEventListener('click', () => modal.classList.remove('abierto'));
  modal?.addEventListener('click', (e) => {
    if (e.target === modal) modal.classList.remove('abierto');
  });
});
</script>

</body>
</html>

const video = document.getElementById("video");
const labios = document.getElementById("labios");
const aviso = document.getElementById("aviso");
const btnCamara = document.getElementById("btnCamara");
let flujo = null; // aquí guardamos la cámara encendida

btnCamara.addEventListener("click", async () => {
  // Si ya está encendida, la apagamos
  if (flujo) {
    flujo.getTracks().forEach(t => t.stop());
    flujo = null;
    video.srcObject = null;
    aviso.style.display = "block";
    btnCamara.textContent = "📷 Encender cámara";
    return;
  }
  try {
    // getUserMedia pide permiso para usar la cámara frontal
    flujo = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } });
    video.srcObject = flujo;
    aviso.style.display = "none";
    labios.style.display = "block";
    btnCamara.textContent = "⏹️ Apagar cámara";
  } catch (e) {
    alert("No se pudo abrir la cámara. Revisa los permisos del navegador.");
  }
});

// Elegir color del labial: cambiamos el fondo de la capa "labios"
document.querySelectorAll("#colores button").forEach(b => {
  b.addEventListener("click", () => {
    labios.style.background = b.dataset.color;
    document.querySelectorAll("#colores button").forEach(x => x.classList.remove("activo"));
    b.classList.add("activo");
  });
});

// Intensidad = opacidad de la capa de color
document.getElementById("intensidad").addEventListener("input", e => {
  labios.style.opacity = e.target.value;
});

// ---------- 2) SIMULADOR DE LUZ ----------
const luz = document.getElementById("luz");
document.querySelectorAll("[data-luz]").forEach(b => {
  b.addEventListener("click", () => {
    luz.className = "luz " + b.dataset.luz; // la clase CSS cambia el filtro
    document.querySelectorAll("[data-luz]").forEach(x => x.classList.remove("activo"));
    b.classList.add("activo");
  });
});

// ---------- 3) TEST DE SUBTONO ----------
const textos = {
  frio:   "❄️ Subtono FRÍO: te favorecen rosas, fucsias y vinos.",
  calido: "☀️ Subtono CÁLIDO: te favorecen corales, terracotas y nudes dorados.",
  neutro: "🌸 Subtono NEUTRO: ¡casi todo te queda! Prueba rosas suaves y malvas."
};
document.querySelectorAll("[data-sub]").forEach(b => {
  b.addEventListener("click", () => {
    document.getElementById("resultadoSub").textContent = textos[b.dataset.sub];
  });
});

// ---------- 4) MODAL DE INGREDIENTES ----------
const modal = document.getElementById("modal");
document.querySelectorAll(".ver-ing").forEach(b => {
  b.addEventListener("click", () => {
    document.getElementById("modalTitulo").textContent = b.dataset.nombre;
    const alertas = b.dataset.alertas.toLowerCase();
    // Convertimos el texto "a, b, c" en una lista <li>
    document.getElementById("modalLista").innerHTML = b.dataset.ing
      .split(",")
      .map(i => i.trim())
      .filter(i => i)
      .map(i => `<li class="${alertas.includes(i.toLowerCase()) ? "malo" : ""}">${i}</li>`)
      .join("");
    document.getElementById("modalAlerta").textContent = b.dataset.alertas
      ? "⚠️ Comedogénicos (pueden tapar poros): " + b.dataset.alertas
      : "✅ No detectamos ingredientes que tapen poros.";
    modal.classList.add("abierto");
  });
});
document.getElementById("cerrarModal").onclick = () => modal.classList.remove("abierto");
modal.addEventListener("click", e => { if (e.target === modal) modal.classList.remove("abierto"); });

<?php
/*********************************************************************
    udla-faq.inc.php
    Página FAQ con diseño UDLA: accesos de Soporte Nivel 1,
    buscador y preguntas desplegables.
**********************************************************************/
if (!defined('OSTCLIENTINC')) die('Access Denied!');

$wa = 'https://wa.me/14155238886';

// Accesos rápidos de Soporte Nivel 1
$soporte = array(
    array('fa-key',          'Restablecer contraseña eCampus', 'Recupera tu acceso institucional',        '#faq-1'),
    array('fa-network-wired','Conexión a VPN Institucional',   'Problemas de túnel seguro o credenciales', '#faq-2'),
    array('fa-video',        'Acceso a clases online / Teams', 'Error al unirse a sesiones virtuales',     '#faq-3'),
    array('fa-ticket-alt',   'Abrir Nuevo Ticket General',     'Para consultas técnicas o de seguridad',   ROOT_PATH.'open.php'),
);

// Preguntas frecuentes (pregunta, respuesta en HTML)
$faqs = array(
    array('¿Cómo puedo restablecer mi contraseña de eCampus UDLA?',
          'Dirígete a la pantalla de inicio de sesión de eCampus y haz clic en <strong>"¿Olvidaste tu contraseña?"</strong>. Ingresa tu correo institucional para recibir un enlace seguro de recuperación.'),
    array('¿Qué hago si tengo problemas para conectarme a la VPN institucional?',
          'Verifica que tu conexión a internet sea estable y que utilices la última versión del cliente VPN. Si persiste el error, abre un ticket adjuntando una captura de pantalla del mensaje.'),
    array('¿Cómo puedo unirme a mis clases online mediante Microsoft Teams?',
          'Inicia sesión en Teams con tu cuenta UDLA (<code>@udla.cl</code>) y revisa la sección <strong>Equipos</strong> o tu <strong>Calendario</strong>, el cual se sincroniza automáticamente.'),
    array('¿Cuál es el horario de atención de la Clínica de Ciberseguridad?',
          'La plataforma de tickets opera 24/7. La gestión activa y resolución por parte de los agentes de soporte nivel 1 se realiza de lunes a viernes de 09:00 a 18:00 hrs.'),
    array('¿Cómo reporto un correo sospechoso o intento de Phishing?',
          'No hagas clic en ningún enlace ni descargues archivos. Crea un ticket nuevo en esta plataforma seleccionando la categoría de Ciberseguridad para que nuestro equipo lo analice.'),
    array('¿Qué debo hacer si mi cuenta de usuario aparece bloqueada?',
          'El bloqueo ocurre por múltiples intentos fallidos de acceso. Espera 15 minutos para que se desbloquee automáticamente o abre un ticket de soporte nivel 1 para agilizar el proceso.'),
    array('¿Cómo puedo consultar el estado de un ticket que ya creé?',
          'Haz clic en la opción <strong>"Ver Estado de un Ticket"</strong> en la barra superior e ingresa tu correo y el número de seguimiento de tu solicitud.'),
    array('¿Puedo contactar a soporte directamente mediante WhatsApp?',
          'Sí, tenemos un canal de mensajería rápida. Utiliza el botón <strong>"Abrir Vía Whatsapp"</strong> ubicado en el menú principal para iniciar un chat directo con nuestros agentes.'),
    array('¿Qué requisitos técnicos mínimos necesito para mis cursos online?',
          'Se recomienda un equipo con navegador actualizado, conexión a internet de al menos 10 Mbps de descarga, cámara web y micrófono funcional.'),
    array('¿Cómo me conecto a la red Wi-Fi en las sedes de la universidad?',
          'Busca la red institucional en tu dispositivo e ingresa utilizando tus credenciales de portal (correo y contraseña). Si requieres configurar Eduroam, revisa los manuales.'),
);
?>
<div class="udla-faq">

  <!-- Encabezado -->
  <section class="faq-hero">
    <div class="faq-wrap text-center">
      <span class="faq-eyebrow"><i class="fas fa-headset me-1"></i> Soporte Nivel 1 · Clínica de Ciberseguridad UDLA</span>
      <h1 class="faq-title">Preguntas Frecuentes</h1>
      <p class="faq-sub">Encuentra respuestas rápidas o accede directamente a las soluciones más solicitadas.</p>

      <div class="faq-search">
        <i class="fas fa-search"></i>
        <input type="search" id="faqSearch" placeholder="Busca tu pregunta, ej: contraseña, VPN, Teams..." autocomplete="off" aria-label="Buscar en preguntas frecuentes">
      </div>
    </div>
  </section>

  <div class="faq-wrap">

    <!-- Soporte Nivel 1 -->
    <h2 class="faq-section-title"><i class="fas fa-life-ring"></i> Soporte Nivel 1</h2>
    <div class="faq-support">
      <?php foreach ($soporte as $s) { ?>
      <a class="support-card" href="<?php echo $s[3]; ?>">
        <span class="support-icon"><i class="fas <?php echo $s[0]; ?>"></i></span>
        <span class="support-text">
          <strong><?php echo $s[1]; ?></strong>
          <small><?php echo $s[2]; ?></small>
        </span>
        <i class="fas fa-chevron-right support-arrow"></i>
      </a>
      <?php } ?>
    </div>

    <!-- Preguntas -->
    <h2 class="faq-section-title"><i class="fas fa-question-circle"></i> Preguntas Frecuentes</h2>
    <div class="faq-list" id="faqList">
      <?php foreach ($faqs as $i => $f) { $n = $i + 1; ?>
      <details class="faq-item" id="faq-<?php echo $n; ?>">
        <summary>
          <span class="faq-num"><?php echo str_pad($n, 2, '0', STR_PAD_LEFT); ?></span>
          <span class="faq-q"><?php echo $f[0]; ?></span>
          <i class="fas fa-chevron-down faq-chevron"></i>
        </summary>
        <div class="faq-a"><?php echo $f[1]; ?></div>
      </details>
      <?php } ?>
    </div>

    <div class="faq-empty" id="faqEmpty" hidden>
      <i class="fas fa-search"></i>
      <p>No encontramos resultados para tu búsqueda.</p>
      <a href="<?php echo ROOT_PATH; ?>open.php" class="btn btn-udla fw-semibold px-4">
        <i class="fas fa-plus-circle me-1"></i> Abrir un Ticket
      </a>
    </div>

    <!-- CTA -->
    <div class="faq-cta">
      <div>
        <strong>¿No encontraste lo que buscabas?</strong>
        <span>Nuestro equipo de soporte te ayudará a resolverlo.</span>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="<?php echo ROOT_PATH; ?>open.php" class="btn btn-udla fw-semibold px-4"><i class="fas fa-plus-circle me-1"></i> Abrir un Ticket</a>
        <a href="<?php echo $wa; ?>" target="_blank" rel="noopener" class="btn btn-outline-light fw-semibold px-4"><i class="fab fa-whatsapp me-1"></i> WhatsApp</a>
      </div>
    </div>
  </div>
</div>

<style>
.udla-faq { --o:#E8630A; --o-soft:#FDEBDD; --dark:#1D1D1B; --muted:#6b6b69; --line:#ece8e3; padding-bottom:1rem; }
.udla-faq .faq-wrap { max-width:960px; margin:0 auto; padding:0 1rem; }

/* Hero */
.faq-hero { background:linear-gradient(135deg,#1D1D1B 0%,#2e2c2a 50%,#3a1800 100%); padding:3rem 0 3.6rem; margin-bottom:2.4rem; position:relative; overflow:hidden; }
.faq-hero::after { content:""; position:absolute; top:-80px; right:-80px; width:300px; height:300px; border-radius:50%; background:rgba(232,99,10,.08); }
.faq-eyebrow { display:inline-block; background:rgba(232,99,10,.18); border:1px solid rgba(232,99,10,.4); color:var(--o); font-size:.72rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; border-radius:20px; padding:4px 14px; margin-bottom:1rem; }
.faq-title { color:#fff; font-weight:800; font-size:clamp(1.8rem,4vw,2.6rem); margin:0 0 .5rem; }
.faq-sub { color:#b0aca6; margin:0 auto 1.6rem; max-width:560px; }
.udla-faq .faq-search { position:relative; max-width:620px; margin:0 auto; z-index:1; }
.udla-faq .faq-search > i { position:absolute; left:22px; top:50%; transform:translateY(-50%); color:var(--o); z-index:2; pointer-events:none; }
.udla-faq .faq-search input[type="search"] { width:100% !important; box-sizing:border-box !important; height:auto !important; border:2px solid transparent !important; border-radius:50px !important; padding:15px 22px 15px 56px !important; font-size:1rem !important; background:#fff !important; box-shadow:0 8px 24px rgba(0,0,0,.25); outline:none; -webkit-appearance:none; transition:border-color .2s; }
.udla-faq .faq-search input[type="search"]:focus { border-color:var(--o) !important; }

/* Títulos de sección */
.faq-section-title { font-size:1.15rem; font-weight:800; color:var(--dark); margin:0 0 1rem; display:flex; align-items:center; gap:10px; }
.faq-section-title i { color:var(--o); }

/* Soporte Nivel 1 */
.faq-support { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; margin-bottom:2.6rem; }
@media (max-width:767.98px) { .faq-support { grid-template-columns:1fr; } }
.support-card { display:flex; align-items:center; gap:16px; padding:18px 20px; background:#fff; border:1px solid var(--line); border-radius:14px; text-decoration:none; box-shadow:0 2px 8px rgba(0,0,0,.04); transition:transform .2s, box-shadow .2s, border-color .2s; }
.support-card:hover { transform:translateY(-3px); border-color:var(--o); box-shadow:0 10px 24px rgba(232,99,10,.15); }
.support-icon { flex-shrink:0; width:46px; height:46px; border-radius:10px; background:var(--o-soft); color:var(--o); display:flex; align-items:center; justify-content:center; font-size:1.1rem; }
.support-text { flex:1; display:flex; flex-direction:column; }
.support-text strong { color:var(--dark); font-size:1rem; }
.support-text small { color:var(--muted); font-size:.82rem; margin-top:2px; }
.support-arrow { color:#c9c4bd; transition:color .2s, transform .2s; }
.support-card:hover .support-arrow { color:var(--o); transform:translateX(3px); }

/* Preguntas desplegables */
.faq-list { display:flex; flex-direction:column; gap:12px; }
.faq-item { background:#fff; border:1px solid var(--line); border-radius:14px; box-shadow:0 2px 8px rgba(0,0,0,.04); transition:border-color .2s, box-shadow .2s; scroll-margin-top:90px; }
.faq-item[open] { border-color:var(--o); box-shadow:0 8px 22px rgba(232,99,10,.12); }
.faq-item summary { list-style:none; display:flex; align-items:center; gap:16px; padding:18px 22px; cursor:pointer; }
.faq-item summary::-webkit-details-marker { display:none; }
.faq-num { flex-shrink:0; min-width:38px; height:32px; padding:0 8px; border-radius:8px; background:var(--o-soft); color:var(--o); font-weight:800; font-size:.9rem; display:flex; align-items:center; justify-content:center; }
.faq-q { flex:1; font-weight:700; color:var(--dark); font-size:1rem; }
.faq-chevron { color:#a8a29b; transition:transform .25s, color .25s; }
.faq-item[open] .faq-chevron { transform:rotate(180deg); color:var(--o); }
.faq-item summary:hover .faq-q { color:var(--o); }
.faq-a { padding:0 22px 20px 76px; color:#3a3835; line-height:1.7; font-size:.95rem; animation:faqIn .25s ease; }
.faq-a code { color:var(--o); background:var(--o-soft); padding:1px 6px; border-radius:4px; }
@keyframes faqIn { from { opacity:0; transform:translateY(-4px); } to { opacity:1; transform:none; } }
.faq-item mark { background:#ffe2c9; color:inherit; padding:0 2px; border-radius:3px; }

/* Sin resultados */
.faq-empty { text-align:center; padding:2.4rem 1rem; color:var(--muted); }
.faq-empty i { font-size:2rem; color:var(--o); margin-bottom:.6rem; }

/* CTA */
.faq-cta { margin-top:2.6rem; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem; padding:1.6rem 2rem; border-radius:16px; background:linear-gradient(135deg,#1D1D1B 0%,#3a1800 100%); }
.faq-cta strong { display:block; color:#fff; font-size:1.05rem; }
.faq-cta span { color:#b0aca6; font-size:.9rem; }

@media (max-width:575.98px) {
  .faq-a { padding-left:22px; }
  .faq-cta { padding:1.4rem; }
}
</style>

<script>
(function () {
    var input = document.getElementById('faqSearch');
    var items = Array.prototype.slice.call(document.querySelectorAll('#faqList .faq-item'));
    var empty = document.getElementById('faqEmpty');
    if (!input) return;

    // Guardar el texto original de cada pregunta para resaltar coincidencias
    items.forEach(function (it) {
        var q = it.querySelector('.faq-q');
        q.setAttribute('data-text', q.textContent);
    });

    function norm(s) { return s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ''); }
    function esc(s) { return s.replace(/[&<>"]/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); }

    function highlight(text, term) {
        if (!term) return esc(text);
        var n = norm(text), i = n.indexOf(term);
        if (i < 0) return esc(text);
        return esc(text.slice(0, i)) + '<mark>' + esc(text.slice(i, i + term.length)) + '</mark>' + esc(text.slice(i + term.length));
    }

    input.addEventListener('input', function () {
        var term = norm(input.value.trim()), visible = 0;
        items.forEach(function (it) {
            var q = it.querySelector('.faq-q');
            var original = q.getAttribute('data-text');
            var hay = norm(original + ' ' + it.querySelector('.faq-a').textContent);
            var match = !term || hay.indexOf(term) > -1;
            it.hidden = !match;
            q.innerHTML = highlight(original, term);
            if (match) visible++;
            // Abrir automáticamente si la coincidencia está solo en la respuesta
            it.open = !!term && match && norm(original).indexOf(term) < 0;
        });
        empty.hidden = visible > 0;
    });

    // Abrir la pregunta enlazada desde las tarjetas de Soporte Nivel 1
    function openHash() {
        var el = location.hash && document.querySelector(location.hash + '.faq-item');
        if (el) { el.open = true; el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    }
    window.addEventListener('hashchange', openHash);
    openHash();
})();
</script>

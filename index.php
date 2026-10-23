<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>

<!-- ====================================================
     CARRUSEL HERO
     ==================================================== -->
<div id="heroCarousel" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-slide-to="0" class="active" aria-current="true" aria-label="Clínica de Ciberseguridad"></button>
    <button type="button" data-slide-to="1" aria-label="Estudia con nosotros"></button>
  </div>
  <div class="carousel-inner">

<!-- Slide 1 — SEMANA DE CIBERSEGURIDAD -->
<section class="carousel-item active hero-slide">
    <!-- Decorative circles -->
    <div style="position:absolute;top:-60px;right:-60px;width:320px;height:320px;border-radius:50%;background:rgba(232,99,10,.08);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-80px;left:-40px;width:260px;height:260px;border-radius:50%;background:rgba(232,99,10,.06);pointer-events:none;"></div>

    <div class="container-xl px-3 position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <!-- Evento badge -->
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(232,99,10,.18);border:1px solid rgba(232,99,10,.4);color:#E8630A;font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;border-radius:20px;padding:4px 14px;margin-bottom:1rem;">
                    <span style="width:7px;height:7px;border-radius:50%;background:#E8630A;animation:pulse 1.5s infinite;"></span>
                    Evento Institucional &nbsp;·&nbsp; Semana de Ciberseguridad 2026
                </div>
                <h1 style="font-size:clamp(1.7rem,4vw,2.6rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:.8rem;">
                    Clínica de Ciberseguridad<br>
                    <span style="color:#E8630A;">UDLA</span>
                </h1>
                <p style="color:#b0aca6;font-size:1rem;max-width:560px;margin-bottom:1.4rem;line-height:1.6;">
                    Un espacio académico dedicado a brindar asistencia técnica especializada a pequeñas y medianas empresas, mitigando riesgos digitales bajo estándares internacionales.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <?php if ($cfg->getClientRegistrationMode() != 'disabled' || !$cfg->isClientLoginRequired()) { ?>
                    <a href="<?php echo ROOT_PATH; ?>open.php"
                       class="btn btn-udla btn-lg fw-semibold px-4"
                       style="border-radius:8px;">
                        <i class="fas fa-plus-circle me-2"></i>Abrir un Ticket
                    </a>
                    <?php } ?>
                    <a href="<?php echo ROOT_PATH; ?>view.php"
                       class="btn btn-outline-light btn-lg px-4"
                       style="border-radius:8px;border-color:rgba(255,255,255,.3);color:#fff;">
                        <i class="fas fa-search me-2"></i>Ver Estado del Ticket
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div style="position:relative;display:inline-block;">
                    <i class="fas fa-shield-alt" style="font-size:7rem;color:rgba(232,99,10,.25);"></i>
                    <i class="fas fa-lock" style="font-size:3rem;color:#E8630A;position:absolute;top:50%;left:50%;transform:translate(-50%,-58%);"></i>
                </div>
                <div style="color:#888;font-size:.8rem;margin-top:.5rem;">Protección · Prevención · Respuesta</div>
            </div>
        </div>
    </div>
</section>

<!-- Slide 2 — ESTUDIA CON NOSOTROS -->
<section class="carousel-item hero-slide">
    <div style="position:absolute;top:-60px;left:-60px;width:320px;height:320px;border-radius:50%;background:rgba(232,99,10,.08);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-80px;right:-40px;width:260px;height:260px;border-radius:50%;background:rgba(232,99,10,.06);pointer-events:none;"></div>

    <div class="container-xl px-3 position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(232,99,10,.18);border:1px solid rgba(232,99,10,.4);color:#E8630A;font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;border-radius:20px;padding:4px 14px;margin-bottom:1rem;">
                    <i class="fas fa-graduation-cap"></i> Executive Online
                </div>
                <h2 style="font-size:clamp(1.7rem,4vw,2.6rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:.8rem;">
                    Estudia con <span style="color:#E8630A;">nosotros</span>
                </h2>
                <p style="color:#b0aca6;font-size:1rem;max-width:460px;margin-bottom:1.4rem;line-height:1.6;">
                    Programas 100% online pensados para quienes trabajan. Especialízate en tecnología y gestión con UDLA.
                </p>
                <a href="https://admision.udla.cl/programa-executive?modalidad=online"
                   target="_blank" rel="noopener"
                   class="btn btn-udla btn-lg fw-semibold px-4" style="border-radius:8px;">
                    <i class="fas fa-arrow-right me-2"></i>Ver programas Executive
                </a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <a class="program-card" target="_blank" rel="noopener"
                           href="https://admision.udla.cl/carreras/executive-online/ingenieria-en-ciberseguridad-online/">
                            <i class="fas fa-shield-alt"></i>
                            <span>Ingeniería en Ciberseguridad<small>Online</small></span>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="program-card" target="_blank" rel="noopener"
                           href="https://admision.udla.cl/carreras/executive-online/ingenieria-en-informatica-online/">
                            <i class="fas fa-laptop-code"></i>
                            <span>Ingeniería en Informática<small>Online</small></span>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="program-card" target="_blank" rel="noopener"
                           href="https://admision.udla.cl/carreras/executive-online/ingenieria-en-informatica-continuidad-de-estudios/">
                            <i class="fas fa-server"></i>
                            <span>Ingeniería en Informática<small>Continuidad de estudios</small></span>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="program-card" target="_blank" rel="noopener"
                           href="https://admision.udla.cl/carreras/executive-online/ingenieria-en-informacion-y-control-de-gestion-continuidad-de-estudios/">
                            <i class="fas fa-chart-line"></i>
                            <span>Ing. en Información y Control de Gestión<small>Continuidad de estudios</small></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  </div><!-- /carousel-inner -->
  <button class="carousel-control-prev" type="button" data-dir="-1">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-dir="1">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>
<script>
(function () {
    var root = document.getElementById('heroCarousel');
    if (!root) return;
    var slides = root.querySelectorAll('.carousel-item');
    var dots = root.querySelectorAll('[data-slide-to]');
    var current = 0, timer = null, DELAY = 7000;

    function show(i) {
        current = (i + slides.length) % slides.length;
        slides.forEach(function (s, k) { s.classList.toggle('active', k === current); });
        dots.forEach(function (d, k) {
            d.classList.toggle('active', k === current);
            if (k === current) d.setAttribute('aria-current', 'true'); else d.removeAttribute('aria-current');
        });
    }
    function restart() { clearInterval(timer); timer = setInterval(function () { show(current + 1); }, DELAY); }

    root.querySelectorAll('[data-dir]').forEach(function (b) {
        b.addEventListener('click', function () { show(current + parseInt(b.getAttribute('data-dir'), 10)); restart(); });
    });
    dots.forEach(function (d) {
        d.addEventListener('click', function () { show(parseInt(d.getAttribute('data-slide-to'), 10)); restart(); });
    });
    root.addEventListener('mouseenter', function () { clearInterval(timer); });
    root.addEventListener('mouseleave', restart);
    restart();
})();
</script>

<!-- ====================================================
     SECCIÓN: ¿SABÍAS QUE? — 4 TARJETAS
     ==================================================== -->
<section id="sabias-que" style="background:var(--udla-gray);padding:2.4rem 0 1.6rem;">
    <div class="container-xl px-3">
        <div class="section-title">
            <i class="fas fa-lightbulb" style="color:var(--udla-orange);"></i>
            ¿Sabías que…?
        </div>
        <div class="row g-3">

            <!-- Card 1 -->
            <div class="col-md-6 col-xl-3">
                <div class="sabia-card p-4 h-100">
                    <div class="sabia-badge"><i class="fas fa-bolt"></i> Dato clave</div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="sabia-icon"><i class="fas fa-user-secret"></i></div>
                        <div>
                            <p style="font-size:.88rem;font-weight:600;color:#1D1D1B;margin-bottom:.3rem;">
                                El 95% de los ciberataques se deben a errores humanos
                            </p>
                            <p style="font-size:.78rem;color:#6b6b69;margin:0;line-height:1.5;">
                                La ingeniería social y el phishing siguen siendo los vectores de ataque más frecuentes a nivel global.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-xl-3">
                <div class="sabia-card p-4 h-100">
                    <div class="sabia-badge"><i class="fas fa-chart-bar"></i> Estadística</div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="sabia-icon"><i class="fas fa-dollar-sign"></i></div>
                        <div>
                            <p style="font-size:.88rem;font-weight:600;color:#1D1D1B;margin-bottom:.3rem;">
                                El costo promedio de una brecha de datos supera los USD 4,45 millones
                            </p>
                            <p style="font-size:.78rem;color:#6b6b69;margin:0;line-height:1.5;">
                                Según IBM Security, este es el costo promedio global reportado en 2023, incluyendo pérdidas operacionales y reputacionales.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-xl-3">
                <div class="sabia-card p-4 h-100">
                    <div class="sabia-badge"><i class="fas fa-clock"></i> Tiempo real</div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="sabia-icon"><i class="fas fa-virus"></i></div>
                        <div>
                            <p style="font-size:.88rem;font-weight:600;color:#1D1D1B;margin-bottom:.3rem;">
                                Ocurre un ataque de ransomware cada 11 segundos en el mundo
                            </p>
                            <p style="font-size:.78rem;color:#6b6b69;margin:0;line-height:1.5;">
                                Las PyMEs son el blanco más frecuente por carecer de equipos de seguridad dedicados o presupuesto adecuado.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-6 col-xl-3">
                <div class="sabia-card p-4 h-100">
                    <div class="sabia-badge"><i class="fas fa-graduation-cap"></i> UDLA</div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="sabia-icon"><i class="fas fa-clinic-medical"></i></div>
                        <div>
                            <p style="font-size:.88rem;font-weight:600;color:#1D1D1B;margin-bottom:.3rem;">
                                La Clínica UDLA atiende incidentes de ciberseguridad de forma gratuita para PyMEs
                            </p>
                            <p style="font-size:.78rem;color:#6b6b69;margin:0;line-height:1.5;">
                                Nuestro equipo de estudiantes y docentes certificados brinda diagnóstico, respuesta y orientación bajo estándares NIST e ISO 27001.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /row -->
    </div>
</section>

<!-- Acciones rápidas eliminada<!-- ====================================================
     CONTENIDO PRINCIPAL (página aterrizaje + KB) — ancho máximo
     ==================================================== -->
<div class="container-xl px-3 py-5">
    <?php if($cfg && ($page = $cfg->getLandingPage())) { ?>
    <!-- Landing page content — diseño mejorado ancho completo -->
    <div class="mb-5" style="border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);">
        <!-- Header de la tarjeta -->
        <div style="background:linear-gradient(135deg,#1D1D1B 0%,#3a1800 100%);padding:1.6rem 2rem;display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:50%;background:rgba(232,99,10,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-shield-alt" style="color:#E8630A;font-size:1.3rem;"></i>
            </div>
            <div>
                <div style="color:#E8630A;font-size:.68rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;">Clínica de Ciberseguridad UDLA</div>
                <div style="color:#fff;font-size:1.05rem;font-weight:700;margin-top:2px;">Fortaleciendo el ecosistema digital</div>
            </div>
        </div>
        <!-- Body de la tarjeta -->
        <div style="background:#fff;padding:2.4rem 2.8rem;">
            <div style="font-size:.98rem;line-height:1.8;color:#3a3835;">
                <?php echo $page->getBodyWithImages(); ?>
            </div>
            <!-- Íconos de valores -->
            <div style="display:flex;flex-wrap:wrap;gap:1.2rem;margin-top:1.8rem;padding-top:1.4rem;border-top:1px solid #f0ede9;">
                <div style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:#6b6b69;font-weight:500;">
                    <i class="fas fa-check-circle" style="color:#E8630A;"></i> Diagnóstico especializado
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:#6b6b69;font-weight:500;">
                    <i class="fas fa-check-circle" style="color:#E8630A;"></i> Respuesta a incidentes
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:#6b6b69;font-weight:500;">
                    <i class="fas fa-check-circle" style="color:#E8630A;"></i> Estándares ISO 27001 &amp; NIST
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:#6b6b69;font-weight:500;">
                    <i class="fas fa-check-circle" style="color:#E8630A;"></i> Atención gratuita para PyMEs
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Knowledge Base articles (ancho completo) -->
    <?php
    if($cfg && $cfg->isKnowledgebaseEnabled()){
        $cats = Category::getFeatured();
        if ($cats->all()) { ?>
    <div class="section-title mt-2">
        <i class="fas fa-book-open" style="color:var(--udla-orange);"></i>
        <?php echo __('Featured Knowledge Base Articles'); ?>
    </div>
    <div class="row g-3">
        <?php foreach ($cats as $C) { ?>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-header bg-white border-bottom d-flex align-items-center gap-2 py-2" style="border-radius:12px 12px 0 0;">
                    <i class="fas fa-folder-open" style="color:#E8630A;"></i>
                    <span class="fw-semibold small"><?php echo $C->getName(); ?></span>
                </div>
                <div class="card-body p-3">
                    <?php foreach ($C->getTopArticles() as $F) { ?>
                    <div class="mb-2 pb-2 border-bottom">
                        <a href="<?php echo ROOT_PATH; ?>kb/faq.php?id=<?php echo $F->getId(); ?>"
                           class="text-decoration-none fw-semibold small" style="color:#1D1D1B;">
                            <i class="fas fa-angle-right me-1" style="color:#E8630A;"></i><?php echo $F->getQuestion(); ?>
                        </a>
                        <p class="text-muted small mb-0 mt-1 ps-3"><?php echo $F->getTeaser(); ?></p>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php
        } // end $cats->all()
    } // end kb enabled
    ?>
</div>

<!-- Pulse animation -->
<style>
@keyframes pulse {
    0%, 100% { opacity:1; transform:scale(1); }
    50%       { opacity:.5; transform:scale(1.4); }
}
#heroCarousel { background: linear-gradient(135deg, #1D1D1B 0%, #2e2c2a 50%, #3a1800 100%); }
.hero-slide {
    padding: 3rem 3.5rem 3.4rem;
    position: relative;
    overflow: hidden;
    min-height: 360px;
}
#heroCarousel .carousel-inner { display: grid; }
#heroCarousel .hero-slide {
    grid-area: 1 / 1;
    display: flex; align-items: center;
    float: none; margin-right: 0;
    opacity: 0; visibility: hidden;
    transition: opacity .6s ease, visibility .6s ease;
}
#heroCarousel .hero-slide.active { opacity: 1; visibility: visible; }
#heroCarousel .carousel-control-prev, #heroCarousel .carousel-control-next { width: 3rem; }
#heroCarousel .carousel-indicators [data-slide-to] {
    box-sizing: content-box; flex: 0 1 auto; padding: 0; margin: 0 4px; cursor: pointer;
    background-color: #E8630A; width: 24px; height: 4px; border: 0; border-radius: 2px;
    opacity: .4; transition: opacity .3s ease;
}
#heroCarousel .carousel-indicators .active { opacity: 1; }
.program-card {
    display: flex; align-items: center; gap: 14px; height: 100%;
    padding: 1rem 1.1rem; border-radius: 12px;
    background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.12);
    color: #fff; text-decoration: none; font-weight: 600; font-size: .92rem; line-height: 1.3;
    transition: transform .2s ease, background .2s ease, border-color .2s ease;
}
.program-card i {
    flex-shrink: 0; width: 44px; height: 44px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    background: rgba(232,99,10,.2); color: #E8630A; font-size: 1.1rem;
}
.program-card small { display: block; font-weight: 400; font-size: .74rem; color: #b0aca6; margin-top: 2px; }
.program-card:hover { color: #fff; transform: translateY(-3px); background: rgba(232,99,10,.15); border-color: rgba(232,99,10,.5); }
@media (max-width: 575.98px) { .hero-slide { padding: 2.4rem 1rem 3rem; } }
</style>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>

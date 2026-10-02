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
     BANNER HERO — SEMANA DE CIBERSEGURIDAD
     ==================================================== -->
<section style="
    background: linear-gradient(135deg, #1D1D1B 0%, #2e2c2a 50%, #3a1800 100%);
    padding: 3rem 0 2.6rem;
    position: relative;
    overflow: hidden;
">
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
</style>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>

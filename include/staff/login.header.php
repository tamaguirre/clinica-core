<?php
defined('OSTSCPINC') or die('Invalid path');
header("Content-Security-Policy: frame-ancestors ".$cfg->getAllowIframes()."; script-src 'self' 'unsafe-inline'; object-src 'none'");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="refresh" content="7200" />
    <title>Acceso Agentes &mdash; Clínica de Ciberseguridad UDLA</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/login.css" type="text/css" />
    <meta name="robots" content="noindex" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-3.7.0.min.js?2570d69"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("input:not(.dp):visible:enabled:first").focus();
         });
    </script>
</head>
<body id="loginBody">

<!-- TOP IDENTITY BAR -->
<div class="udla-topbar">
    <div class="container-xl px-3 d-flex justify-content-between align-items-center">
        <span><i class="fas fa-university me-1"></i> Universidad de Las Américas &mdash; Clínica de Ciberseguridad</span>
    </div>
</div>

<!-- NAVBAR INSTITUCIONAL -->
<nav class="navbar navbar-expand-lg udla-navbar">
    <div class="container-xl px-3">
        <div class="d-flex align-items-center">
            <a class="navbar-brand me-0" href="<?php echo ROOT_PATH; ?>index.php" title="<?php echo __('Support Center'); ?>">
                <img class="brand-logo-udla" src="<?php echo ROOT_PATH; ?>logo.php" alt="<?php echo Format::htmlchars($ost->getConfig()->getTitle()); ?>" style="max-height:44px;">
            </a>
            <span class="brand-sep mx-3" style="width:1px;height:32px;background:#E8630A;"></span>
            <img class="brand-logo-ecampus" src="<?php echo ROOT_PATH; ?>images/udla/logo-ecampus.png" alt="eCampus" style="height:34px;width:auto;">
            <style>
            @media (max-width:575.98px){
              .brand-logo-udla{max-height:34px!important}
              .brand-logo-ecampus{height:26px!important}
              .brand-sep{height:26px!important;margin-left:.6rem!important;margin-right:.6rem!important}
            }
            </style>
        </div>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#ostNav" aria-controls="ostNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="ostNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-5">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo ROOT_PATH; ?>index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo ROOT_PATH; ?>open.php">Abrir un Nuevo Ticket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo ROOT_PATH; ?>accesslink.php">Ver Estado de un Ticket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://wa.me/14155238886">
                        <i class="fab fa-whatsapp me-1 text-success"></i>Abrir Vía Whatsapp
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo ROOT_PATH; ?>index.php#sabias-que">
                        <i class="fas fa-lightbulb me-1"></i>¿Sabías que?
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo ROOT_PATH; ?>pages/faq">
                        <i class="fas fa-question-circle me-1"></i>FAQ
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <div class="nav-divider d-none d-lg-inline-block"></div>
                <a href="<?php echo ROOT_PATH; ?>scp/" class="btn btn-outline-udla btn-sm fw-semibold"><i class="fas fa-user-shield me-1"></i>Acceso Agentes</a>
            </div>
        </div>
    </div>
</nav>


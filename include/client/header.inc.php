<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();

header("Content-Type: text/html; charset=UTF-8");
header("Content-Security-Policy: frame-ancestors ".$cfg->getAllowIframes()."; script-src 'self' 'unsafe-inline'; object-src 'none'");

if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: ".implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html<?php
if ($lang
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . $lang . '"';
}

// Dropped IE Support Warning
if (osTicket::is_ie())
    $ost->setWarning(__('osTicket no longer supports Internet Explorer.'));
?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="Clínica de Ciberseguridad UDLA — Centro de soporte especializado en ciberseguridad para PyMEs">
    <meta name="keywords" content="Ciberseguridad, UDLA, Clínica, Soporte, osTicket, PyMEs">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?2570d69" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css?2570d69" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?2570d69" media="print"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/typeahead.css?2570d69"
         media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.13.2.custom.min.css?2570d69"
        rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/jquery-ui-timepicker-addon.css?2570d69" media="all"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?2570d69" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?2570d69" media="screen"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?2570d69"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?2570d69"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?2570d69"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?2570d69"/>
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-16x16.png" sizes="16x16" />
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-3.7.0.min.js?2570d69"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.13.2.custom.min.js?2570d69"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-timepicker-addon.js?2570d69"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js?2570d69"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?2570d69"></script>
    <script src="<?php echo ROOT_PATH; ?>js/bootstrap-typeahead.js?2570d69"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?2570d69"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?2570d69"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?2570d69"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?2570d69"></script>
    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }

    // Offer alternate links for search engines
    // @see https://support.google.com/webmasters/answer/189077?hl=en
    if (($all_langs = Internationalization::getConfiguredSystemLanguages())
        && (count($all_langs) > 1)
    ) {
        $langs = Internationalization::rfc1766(array_keys($all_langs));
        $qs = array();
        parse_str($_SERVER['QUERY_STRING'], $qs);
        foreach ($langs as $L) {
            $qs['lang'] = $L; ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . htmlspecialchars($_SERVER['REQUEST_URI']); ?>?<?php
            echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
<?php
        } ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . htmlspecialchars($_SERVER['REQUEST_URI']); ?>"
            hreflang="x-default" />
<?php
    }
    ?>
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    :root {
        --udla-orange:  #E8630A;
        --udla-orange2: #c95508;
        --udla-dark:    #1D1D1B;
        --udla-gray:    #f4f4f2;
        --udla-mid:     #6b6b69;
        --udla-light:   #fff9f5;
    }
    *, *::before, *::after { box-sizing: border-box; }
    body, #container, #content, #wrapper {
        font-family: 'Inter', sans-serif !important;
        background-color: #f8f9fa !important;
        background-image: none !important;
        color: var(--udla-dark);
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    #container { width:100% !important; max-width:100% !important; box-shadow:none !important; background:transparent !important; margin:0 !important; flex:1; display:flex; flex-direction:column; }
    #content  { margin:0 !important; padding:0 !important; min-height:0 !important; height:auto !important; flex:1; background:#f8f9fa !important; }
    #footer   { display:none; }

    /* ---- Utility ---- */
    .hover-card { transition: transform .18s ease, box-shadow .18s ease; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 .6rem 1.8rem rgba(232,99,10,.20) !important; }
    .btn-udla         { background-color: var(--udla-orange); color:#fff; border:none; transition: background .2s; }
    .btn-udla:hover   { background-color: var(--udla-orange2); color:#fff; }
    .btn-outline-udla { border: 2px solid var(--udla-orange); color: var(--udla-orange); background: transparent; transition: all .2s; }
    .btn-outline-udla:hover { background-color: var(--udla-orange); color:#fff; }
    .text-udla   { color: var(--udla-orange) !important; }
    .bg-udla     { background-color: var(--udla-orange) !important; }
    .border-udla { border-color: var(--udla-orange) !important; }

    /* ---- Top identity bar ---- */
    .udla-topbar {
        background: var(--udla-dark);
        color: #ccc;
        font-size: .72rem;
        letter-spacing: .05em;
        padding: 5px 0;
    }
    .udla-topbar a { color: var(--udla-orange); text-decoration: none; }
    .udla-topbar a:hover { text-decoration: underline; }

    /* ---- Global Form & Input Styling ---- */
    input, input[type="text"], input[type="password"], input[type="email"], select, textarea, .form-control, .form-select {
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
        padding: 0.6rem 0.9rem !important;
        font-size: 0.95rem !important;
        color: #1D1D1B !important;
        background-color: #fff !important;
        background-image: none !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
        box-shadow: none !important;
        margin: 0 !important;
    }

    #clientLogin input,
    #clientLogin input[type="text"],
    #clientLogin input[type="password"],
    #clientLogin input[type="email"] {
        margin: 0 !important;
        margin-bottom: 0 !important;
    }

    .input-group {
        display: flex !important;
        flex-direction: row !important;
        align-items: stretch !important;
        width: 100% !important;
        margin-bottom: 1.25rem !important;
    }
    .input-group > .input-group-text {
        border-top-left-radius: 8px !important;
        border-bottom-left-radius: 8px !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0.6rem 1rem !important;
        min-width: 48px !important;
        background-color: var(--udla-orange) !important;
        color: #ffffff !important;
        border: 1px solid var(--udla-orange) !important;
        font-size: 1rem !important;
        margin: 0 !important;
        height: auto !important;
    }
    .input-group > input, .input-group > .form-control {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        border: 1px solid #d1d5db !important;
        border-left: none !important;
        flex: 1 1 auto !important;
        width: 1% !important;
        height: auto !important;
        padding: 0.6rem 0.9rem !important;
        margin: 0 !important;
        background-color: #ffffff !important;
        background-image: none !important;
    }
    input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus, select:focus, textarea:focus, .form-control:focus, .form-select:focus {
        border-color: var(--udla-orange) !important;
        box-shadow: 0 0 0 0.25rem rgba(232, 99, 10, 0.2) !important;
        outline: none !important;
        background-image: none !important;
    }
    #clientLogin {
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        background: transparent !important;
        background-image: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    label {
        font-weight: 600 !important;
        color: var(--udla-dark) !important;
        margin-bottom: 0.35rem !important;
        font-size: 0.9rem !important;
    }
    .error, font.error {
        color: #dc3545 !important;
        font-size: 0.85rem !important;
        font-weight: 500;
    }

    /* ---- Cards & Containers ---- */
    .ticket-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 2.25rem 2.5rem;
        margin-top: 1.5rem;
        margin-bottom: 2.5rem;
    }
    .ticket-card-header {
        border-bottom: 1px solid #edf0f2;
        padding-bottom: 1.25rem;
        margin-bottom: 1.5rem;
    }

    /* ---- osTicket Table Refinements ---- */
    #ticketForm table {
        width: 100% !important;
    }
    #ticketForm table td {
        padding: 0.5rem 0 !important;
    }
    #ticketTable {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 4px !important;
    }
    #ticketTable th {
        background: #f8f9fa !important;
        color: var(--udla-dark) !important;
        font-weight: 700 !important;
        font-size: 0.85rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        padding: 12px 16px !important;
        border: none !important;
    }
    #ticketTable td {
        background: #ffffff !important;
        padding: 12px 16px !important;
        font-size: 0.9rem !important;
        border-top: 1px solid #f1f3f5 !important;
        border-bottom: 1px solid #f1f3f5 !important;
    }
    #ticketTable tr:hover td {
        background: #fff9f5 !important;
    }

    /* ---- Navbar ---- */
    .udla-navbar {
        background: #fff;
        border-bottom: 3px solid var(--udla-orange);
        box-shadow: 0 3px 18px rgba(0,0,0,.09);
        padding-top: .55rem;
        padding-bottom: .55rem;
    }
    .udla-navbar .nav-link {
        font-weight: 500;
        font-size: .85rem;
        color: var(--udla-dark) !important;
        padding: .45rem .85rem;
        border-radius: 6px;
        transition: color .15s, background .15s;
        letter-spacing: .01em;
    }
    .udla-navbar .nav-link:hover { color: var(--udla-orange) !important; background: rgba(232,99,10,.07); }
    .udla-navbar .nav-link.active {
        color: var(--udla-orange) !important;
        font-weight: 700;
        background: rgba(232,99,10,.08);
    }
    /* Separador vertical antes de los botones de acción */
    .nav-divider {
        width: 1px; height: 28px;
        background: #e0dbd6;
        margin: 0 .6rem;
        align-self: center;
        display: inline-block;
    }

    /* ---- Sabia cards ---- */
    .sabia-card {
        border-radius: 14px;
        border: none;
        background: #fff;
        box-shadow: 0 2px 14px rgba(0,0,0,.07);
        transition: transform .2s, box-shadow .2s;
        overflow: hidden;
    }
    .sabia-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(232,99,10,.18); }
    .sabia-card .sabia-icon {
        width: 44px; height: 44px; border-radius: 50%;
        background: rgba(232,99,10,.12);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sabia-card .sabia-icon i { color: var(--udla-orange); font-size: 1.1rem; }
    .sabia-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(232,99,10,.12); color: var(--udla-orange);
        font-size: .7rem; font-weight: 700; letter-spacing: .08em;
        text-transform: uppercase; border-radius: 20px;
        padding: 3px 10px; margin-bottom: 8px;
    }

    /* ---- Section titles ---- */
    .section-title {
        font-size: 1rem; font-weight: 700; color: var(--udla-dark);
        display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem;
    }
    .section-title::before {
        content: ''; display: inline-block;
        width: 4px; height: 20px; border-radius: 2px;
        background: var(--udla-orange);
    }
    </style>
</head>
<body>
<div id="container">
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
        </div>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#ostNav" aria-controls="ostNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="ostNav">
            <?php if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)) { ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-10">
                <?php foreach($navs as $name => $navItem) { ?>
                <li class="nav-item">
                    <a class="nav-link<?php echo $navItem['active'] ? ' active' : ''; ?>"
                       href="<?php echo ROOT_PATH.$navItem['href']; ?>"><?php echo $navItem['desc']; ?></a>
                </li>
                <?php } ?>
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
            <?php } ?>
            <div class="d-flex align-items-center gap-2">
                <div class="nav-divider d-none d-lg-inline-block"></div>
                <?php
                if (($all_langs = Internationalization::getConfiguredSystemLanguages()) && (count($all_langs) > 1)) {
                    $qs_nav = array();
                    parse_str($_SERVER['QUERY_STRING'], $qs_nav);
                    foreach ($all_langs as $lcode => $linfo) {
                        list($lc, $lloc) = explode('_', $lcode);
                        $qs_nav['lang'] = $lcode;
                        echo sprintf('<a class="flag flag-%s" href="?%s" title="%s">&nbsp;</a>',
                            htmlspecialchars(strtolower($linfo['flag'] ?: $lloc ?: $lc)),
                            htmlspecialchars(http_build_query($qs_nav)),
                            htmlspecialchars(Internationalization::getLanguageDescription($lcode)));
                    }
                }
                ?>
                <?php if ($thisclient && is_object($thisclient) && $thisclient->isValid() && !$thisclient->isGuest()) { ?>
                    <span class="small fw-medium d-none d-lg-inline" style="color:var(--udla-dark);"><?php echo Format::htmlchars($thisclient->getName()); ?></span>
                    <a href="<?php echo ROOT_PATH; ?>profile.php" class="btn btn-outline-udla btn-sm"><?php echo __('Profile'); ?></a>
                    <a href="<?php echo ROOT_PATH; ?>tickets.php" class="btn btn-outline-udla btn-sm"><?php echo sprintf(__('Tickets (%d)'), $thisclient->getNumTickets()); ?></a>
                    <a href="<?php echo $signout_url; ?>" class="btn btn-udla btn-sm fw-semibold"><?php echo __('Sign Out'); ?></a>
                <?php } elseif($nav) { ?>
                    <?php if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) { ?>
                        <a href="<?php echo $signout_url; ?>" class="btn btn-outline-udla btn-sm"><?php echo __('Sign Out'); ?></a>
                    <?php } ?>
                <?php } ?>
                <?php if (!$thisclient || !$thisclient->isValid() || $thisclient->isGuest()) { ?>
                <a href="<?php echo ROOT_PATH; ?>scp/" class="btn btn-outline-udla btn-sm fw-semibold"><i class="fas fa-user-shield me-1"></i>Acceso Agentes</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
<?php
if($ost->getError())
    echo sprintf('<div class="alert alert-danger rounded-0 mb-0">%s</div>', $ost->getError());
elseif($ost->getWarning())
    echo sprintf('<div class="alert alert-warning rounded-0 mb-0">%s</div>', $ost->getWarning());
elseif($ost->getNotice())
    echo sprintf('<div class="alert alert-info rounded-0 mb-0">%s</div>', $ost->getNotice());
?>
<div id="content">
<?php if($errors['err']) { ?>
    <div class="alert alert-danger rounded-0 mb-0"><?php echo $errors['err']; ?></div>
<?php }elseif($msg) { ?>
    <div class="alert alert-success rounded-0 mb-0"><?php echo $msg; ?></div>
<?php }elseif($warn) { ?>
    <div class="alert alert-warning rounded-0 mb-0"><?php echo $warn; ?></div>
<?php } ?>

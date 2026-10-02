<?php
include_once(INCLUDE_DIR.'staff/login.header.php');
$info = ($_POST && $errors)?Format::htmlchars($_POST):array();


if ($thisstaff && $thisstaff->is2FAPending())
    $msg = "2FA Pending";

?>
<div class="d-flex flex-column min-vh-100" style="background:#f8f9fa;">
  <!-- CENTER LOGIN CARD AREA -->
  <div class="container py-5 flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 w-100 bg-white" id="loginBox" style="max-width:480px;">
      
      <div class="text-center mb-4">
        <h3 class="fw-bold mb-1" style="color:#1D1D1B; font-size: 1.4rem;"><i class="fas fa-user-shield text-udla me-2"></i>Acceso Agentes UDLA</h3>
        <p class="text-muted small mb-0">Panel de administración para docentes y estudiantes asistentes.</p>
      </div>

      <div id="login-message" class="text-danger text-center small fw-semibold mb-3">
        <?php echo Format::htmlchars($msg); ?>
      </div>

      <?php if ($content) { ?>
        <div class="banner mb-3 text-center small text-muted">
          <small><?php echo Format::display($content->getLocalBody()); ?></small>
        </div>
      <?php } ?>

      <div id="loading" style="display:none;" class="text-center py-2 text-primary mb-3">
        <i class="fas fa-spinner fa-spin me-2 fs-5"></i>
        <span>Verificando credenciales...</span>
      </div>

      <form action="login.php" method="post" id="login" onsubmit="attemptLoginAjax(event)">
        <?php csrf_token();
        if ($thisstaff
                &&  $thisstaff->is2FAPending()
                && ($bk=$thisstaff->get2FABackend())
                && ($form=$bk->getInputForm($_POST))) {
            include STAFFINC_DIR . 'templates/dynamic-form-simple.tmpl.php';
            ?>
            <input type="hidden" name="do" value="2fa">
            <button class="btn btn-udla btn-lg w-100 fw-semibold fs-6 py-2.5 mt-3" type="submit" name="submit">
              <i class="fas fa-shield-alt me-2"></i>Verificar
            </button>
        <?php
        } else { ?>
            <input type="hidden" name="do" value="scplogin">
            
            <div class="mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="userid" id="name" value="<?php echo $info['userid'] ?? null; ?>"
                       placeholder="Correo electrónico o usuario" class="form-control" autofocus required autocorrect="off" autocapitalize="off">
              </div>
            </div>

            <div class="mb-4">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="passwd" id="pass" maxlength="128"
                       placeholder="Contraseña" class="form-control" required autocorrect="off" autocapitalize="off">
              </div>
            </div>

            <button class="btn btn-udla btn-lg w-100 fw-semibold fs-6 py-2.5 mb-3" type="submit" name="submit">
              <i class="fas fa-sign-in-alt me-2"></i>Inicia Sesión
            </button>

            <div class="text-center">
              <a id="reset-link" class="<?php if (!$show_reset || !$cfg->allowPasswordReset()) echo 'd-none'; ?> small text-muted text-decoration-none" href="pwreset.php">
                <i class="fas fa-question-circle me-1"></i>¿Olvidó su contraseña?
              </a>
            </div>
        <?php } ?>
      </form>

      <?php if (($bks=StaffAuthenticationBackend::getExternal())) { ?>
        <div class="my-3 text-center text-muted small"><hr/></div>
        <?php foreach ($bks as $bk) { ?>
          <div class="external-auth"><?php $bk->renderExternalLink(); ?></div>
        <?php } ?>
      <?php } ?>

    </div>
  </div>

<!-- FOOTER INSTITUCIONAL UDLA -->
<footer style="background:#1D1D1B; color:#ccc; margin-top:3rem;">
    <!-- Franja de logos institucionales UDLA -->
    <div style="background:#1D1D1B; border-top:4px solid #E8630A; padding:22px 0;">
        <div class="container-xl px-3">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between gap-4">
                <img src="<?php echo ROOT_PATH; ?>images/udla/logo-udla-blanco.png" alt="Logo UDLA" style="max-height:48px; object-fit:contain;">
                <img src="<?php echo ROOT_PATH; ?>images/udla/adscrita-gratuidad.png" alt="Adscrita a Gratuidad" style="max-height:48px; object-fit:contain;">
                <img src="<?php echo ROOT_PATH; ?>images/udla/logo-cna-acreditada.svg" alt="Universidad Acreditada CNA" style="max-height:60px; object-fit:contain;">
                <img src="<?php echo ROOT_PATH; ?>images/udla/dec-white.png" alt="Digital Education Council" style="max-height:48px; object-fit:contain;">
                <img src="<?php echo ROOT_PATH; ?>images/udla/sello-aenor.png" alt="Sello AENOR" style="max-height:56px; object-fit:contain;">
            </div>
        </div>
    </div>
    <!-- Info del footer -->
    <div style="padding:20px 0 16px;">
        <div class="container-xl px-3">
            <div class="row align-items-center text-center text-md-start gy-2">
                <div class="col-md-6 small">
                    Derechos de autor &copy; <?php echo date('Y'); ?>
                    <strong style="color:#fff;">UDLA</strong> &mdash; Todos los derechos reservados.
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="https://osticket.com" target="_blank" style="color:#E8630A;font-size:.8rem;text-decoration:none;">
                        <i class="fas fa-external-link-alt me-1"></i> Software de soporte impulsado por osTicket
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (undefined === window.getComputedStyle(document.documentElement).backgroundBlendMode) {
            document.getElementById('loginBox').style.backgroundColor = 'white';
        }
    });

    function attemptLoginAjax(e) {
        $('#loading').show();
        var objectifyForm = function(formArray) { //serialize data function
            var returnArray = {};
            for (var i = 0; i < formArray.length; i++) {
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;
        };
        if ($.fn.effect) {
            // For some reason, JQuery-UI shake does not considere an element's
            // padding when shaking. Looks like it might be fixed in 1.12.
            // Thanks, https://stackoverflow.com/a/22302374
            var oldEffect = $.fn.effect;
            $.fn.effect = function (effectName) {
                if (effectName === "shake") {
                    $('#loading').hide();
                    var old = $.effects.createWrapper;
                    $.effects.createWrapper = function (element) {
                        var result;
                        var oldCSS = $.fn.css;

                        $.fn.css = function (size) {
                            var _element = this;
                            var hasOwn = Object.prototype.hasOwnProperty;
                            return _element === element && hasOwn.call(size, "width") && hasOwn.call(size, "height") && _element || oldCSS.apply(this, arguments);
                        };

                        result = old.apply(this, arguments);

                        $.fn.css = oldCSS;
                        return result;
                    };
                }
                return oldEffect.apply(this, arguments);
            };
        }
        var form = $(e.target),
            data = objectifyForm(form.serializeArray())
        data.ajax = 1;
        $('button[type=submit]', form).attr('disabled', 'disabled');
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: data,
            cache: false,
            success: function(json) {
                 $('button[type=submit]', form).removeAttr('disabled');
                if (!typeof(json) === 'object' || !json.status)
                    return;
                switch (json.status) {
                case 401:
                    if (json && json.redirect)
                        document.location.href = json.redirect;
                    if (json && json.message)
                        $('#login-message').text(json.message)
                    if (json && json.show_reset)
                        $('#reset-link').show()
                    if ($.fn.effect) {
                        $('#loginBox').effect('shake')
                    }
                    // Clear the password field
                    $('#pass').val('').focus();
                    break
                case 302:
                    if (json && json.redirect)
                        document.location.href = json.redirect;
                    break
                }
            },
        });
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        return false;
    }
    </script>
    <!--[if IE]>
    <style>
        #loginBox:after { background-color: white !important; }
    </style>
    <![endif]-->
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.13.2.custom.min.js?2570d69"></script>
</body>
</html>

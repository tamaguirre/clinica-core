<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['luser']?:$_GET['e']);
$passwd=Format::input($_POST['lpasswd']?:$_GET['t']);

$title = "Iniciar sesión en Clínica Ciberseguridad UDLA";
$body = "Para brindar un mejor servicio, le invitamos a ingresar a su cuenta o consultar el estado de sus tickets.";
?>
<div class="container py-4" style="max-width:960px;">
  <!-- Header Title Box -->
  <div class="bg-light p-3 px-4 rounded-3 border-start border-4 border-udla mb-4 shadow-sm">
    <h2 class="fw-bold mb-1" style="color:#1D1D1B;"><?php echo Format::display($title); ?></h2>
    <p class="text-muted small mb-0"><?php echo Format::display($body); ?></p>
  </div>

  <div class="row g-4 align-items-stretch">
    <!-- Left Column: Login Form -->
    <div class="col-md-6 d-flex flex-column">
      <div class="card border-0 shadow-sm rounded-3 p-4 bg-white flex-fill d-flex flex-column justify-content-center">
        <form action="login.php" method="post" id="clientLogin">
          <?php csrf_token(); ?>

          <?php if ($errors['login']) { ?>
            <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 d-flex align-items-center gap-2">
              <i class="fas fa-exclamation-circle"></i>
              <span><?php echo Format::htmlchars($errors['login']); ?></span>
            </div>
          <?php } ?>

          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input id="username" placeholder="<?php echo __('Correo electrónico o nombre de usuario'); ?>" type="text" name="luser" value="<?php echo $email; ?>" class="form-control" required>
            </div>
          </div>

          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input id="passwd" placeholder="<?php echo __('Contraseña'); ?>" type="password" name="lpasswd" maxlength="128" value="<?php echo $passwd; ?>" class="form-control" required>
            </div>
          </div>

          <button type="submit" class="btn btn-udla btn-lg w-100 fw-semibold fs-6 py-2.5">
            <?php echo __('Inicia Sesión'); ?>
          </button>

          <?php if ($suggest_pwreset) { ?>
            <div class="text-center mt-3">
              <a href="pwreset.php" class="small text-muted"><?php echo __('¿Olvidó su contraseña?'); ?></a>
            </div>
          <?php } ?>
        </form>
      </div>
    </div>

    <!-- Right Column: Instructions Box with Checkmarks -->
    <div class="col-md-6 d-flex flex-column">
      <div class="card border-0 shadow-sm rounded-3 p-4 bg-white border flex-fill d-flex flex-column justify-content-center">
        <ul class="list-unstyled mb-0 d-flex flex-column gap-3 small">
          <?php if ($cfg && $cfg->isClientRegistrationEnabled()) { ?>
            <li class="d-flex align-items-start gap-2">
              <i class="fas fa-check text-success fs-6 mt-1"></i>
              <span>
                ¿Aún no está registrado? <a href="account.php?do=create" class="fw-semibold text-udla">Cree una cuenta</a>
              </span>
            </li>
          <?php } ?>
          <li class="d-flex align-items-start gap-2">
            <i class="fas fa-check text-success fs-6 mt-1"></i>
            <span>
              Si es la primera vez que se pone en contacto con nosotros o perdió el número de Ticket, por favor <a href="open.php" class="fw-semibold text-udla">abra un nuevo Ticket</a>.
            </span>
          </li>
          <li class="d-flex align-items-start gap-2">
            <i class="fas fa-check text-success fs-6 mt-1"></i>
            <span>
              <strong>Soy un agente</strong> &mdash; <a href="<?php echo ROOT_PATH; ?>scp/" class="fw-semibold text-udla">Acceda aquí</a>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div><!-- /.container -->

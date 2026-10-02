<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);

if ($cfg->isClientEmailVerificationRequired())
    $button = __("Email Access Link");
else
    $button = __("View Ticket");
?>
<div class="container py-4" style="max-width:960px;">
  <!-- Header Title Box -->
  <div class="bg-light p-3 px-4 rounded-3 border-start border-4 border-udla mb-4 shadow-sm">
    <h2 class="fw-bold mb-1" style="color:#1D1D1B;">Ver Estado de un Ticket</h2>
    <p class="text-muted small mb-0">Por favor proporcione su dirección de e-mail y el número de ticket. Un enlace de acceso le será enviado.</p>
  </div>

  <div class="row g-4 align-items-stretch">
    <!-- Left Column: Form Box -->
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
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              <input id="email" placeholder="<?php echo __('Correo Electrónico'); ?>" type="email"
                     name="lemail" value="<?php echo $email; ?>" class="form-control" required>
            </div>
          </div>

          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
              <input id="ticketno" type="text" name="lticket" placeholder="<?php echo __('Número de Ticket'); ?>"
                     value="<?php echo $ticketid; ?>" class="form-control" required>
            </div>
          </div>

          <button type="submit" class="btn btn-udla btn-lg w-100 fw-semibold fs-6 py-2.5">
            <?php echo $button; ?>
          </button>
        </form>
      </div>
    </div>

    <!-- Right Column: Instructions Box with Checkmarks -->
    <div class="col-md-6 d-flex flex-column">
      <div class="card border-0 shadow-sm rounded-3 p-4 bg-white border flex-fill d-flex flex-column justify-content-center">
        <ul class="list-unstyled mb-0 d-flex flex-column gap-3 small">
          <?php if ($cfg && $cfg->getClientRegistrationMode() !== 'disabled') { ?>
            <li class="d-flex align-items-start gap-2">
              <i class="fas fa-check text-success fs-6 mt-1"></i>
              <span>
                <?php echo __('Have an account with us?'); ?>
                <a href="login.php" class="fw-semibold text-udla"><?php echo __('Sign In'); ?></a>
                <?php if ($cfg->isClientRegistrationEnabled()) { ?>
                  o <a href="account.php?do=create" class="fw-semibold text-udla">regístrese para una cuenta</a>
                <?php } ?>
                para acceder a todos sus Tickets.
              </span>
            </li>
          <?php } ?>
          <li class="d-flex align-items-start gap-2">
            <i class="fas fa-check text-success fs-6 mt-1"></i>
            <span>
              Si es la primera vez que se pone en contacto con nosotros o perdió el número de Ticket, por favor
              <a href="open.php" class="fw-semibold text-udla">abra un nuevo Ticket</a>.
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div><!-- /.container -->

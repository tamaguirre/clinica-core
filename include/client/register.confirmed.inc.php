<?php if ($content) {
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getName(), $content->getBody()));
} else {
    $title = __('Account Registration');
    $body = '<strong>' . __('Thanks for registering for an account.') . '</strong><br><br>' .
            __("You've confirmed your email address and successfully activated your account. You may proceed to check on previously opened tickets or open a new ticket.");
}
?>
<div class="container py-5" style="max-width:680px;">
  <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5 text-center bg-white">
    <div class="mb-3">
      <i class="fas fa-check-circle text-success display-4"></i>
    </div>
    <h2 class="fw-bold mb-3" style="color:#1D1D1B;"><?php echo Format::display($title); ?></h2>
    <div class="text-muted fs-6 mb-4 leading-relaxed">
      <?php echo Format::display($body); ?>
    </div>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="tickets.php" class="btn btn-udla px-4 py-2 fw-semibold">
        <i class="fas fa-ticket-alt me-1"></i><?php echo __('Ver mis Tickets'); ?>
      </a>
      <a href="open.php" class="btn btn-outline-udla px-4 py-2 fw-semibold">
        <i class="fas fa-plus-circle me-1"></i><?php echo __('Abrir un Ticket'); ?>
      </a>
    </div>
  </div>
</div>


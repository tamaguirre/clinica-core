<?php if ($content) {
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getName(), $content->getBody()));
} else {
    $title = __('Account Registration');
    $body = '<strong>' . __('Thanks for registering for an account.') . '</strong><br><br>' .
            __("We've just sent you an email to the address you entered. Please follow the link in the email to confirm your account and gain access to your tickets.");
}
?>
<div class="container py-5" style="max-width:680px;">
  <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5 text-center bg-white">
    <div class="mb-3">
      <i class="fas fa-paper-plane text-udla display-4"></i>
    </div>
    <h2 class="fw-bold mb-3" style="color:#1D1D1B;"><?php echo Format::display($title); ?></h2>
    <div class="text-muted fs-6 mb-4 leading-relaxed">
      <?php echo Format::display($body); ?>
    </div>
    <div>
      <a href="index.php" class="btn btn-udla px-4 py-2 fw-semibold">
        <i class="fas fa-home me-1"></i><?php echo __('Volver al Inicio'); ?>
      </a>
    </div>
  </div>
</div>


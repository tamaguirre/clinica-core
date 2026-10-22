<?php

if(!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkUserAccess($thisclient)) die('Access Denied!');

?>
<div class="container py-4" style="width:100%;max-width:960px;margin-left:auto !important;margin-right:auto !important;float:none;">
  <!-- Header Title Box -->
  <div class="bg-light p-3 px-4 rounded-3 border-start border-4 border-udla mb-4 shadow-sm">
    <h2 class="fw-bold mb-1" style="color:#1D1D1B;">
      <?php echo sprintf(__('Editing Ticket #%s'), $ticket->getNumber()); ?>
    </h2>
  </div>

  <div class="ticket-card mt-0 shadow-sm p-4 p-md-5">
    <form action="tickets.php" method="post">
      <?php echo csrf_token(); ?>
      <input type="hidden" name="a" value="edit"/>
      <input type="hidden" name="id" value="<?php echo Format::htmlchars($_REQUEST['id']); ?>"/>

      <table width="100%" cellpadding="0" cellspacing="0" border="0" class="w-100">
        <tbody id="dynamic-form">
        <?php if ($forms)
            foreach ($forms as $form) {
                $form->render(['staff' => false]);
        } ?>
        </tbody>
      </table>

      <hr class="my-4">

      <div class="d-flex align-items-center justify-content-center gap-3">
        <button type="submit" class="btn btn-udla px-4 py-2 fw-semibold fs-6">
          <i class="fas fa-save me-1"></i><?php echo __('Update'); ?>
        </button>
        <button type="reset" class="btn btn-outline-secondary px-4 py-2 fw-semibold fs-6">
          <?php echo __('Reset'); ?>
        </button>
        <a href="index.php" class="btn btn-outline-secondary px-4 py-2 fw-semibold fs-6">
          <?php echo __('Cancel'); ?>
        </a>
      </div>
    </form>
  </div>
</div>

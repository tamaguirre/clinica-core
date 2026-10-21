<?php
$info = $_POST;
if (!isset($info['timezone']))
    $info += array(
        'backend' => null,
    );
if (isset($user) && $user instanceof ClientCreateRequest) {
    $bk = $user->getBackend();
    $info = array_merge($info, array(
        'backend' => $bk->getBkId(),
        'username' => $user->getUsername(),
    ));
}
$info = Format::htmlchars(($errors && $_POST)?$_POST:$info);

?>
<div class="container py-4" style="width:100%;max-width:960px;margin-left:auto !important;margin-right:auto !important;float:none;">
  <!-- Header Title Box -->
  <div class="bg-light p-3 px-4 rounded-3 border-start border-4 border-udla mb-4 shadow-sm">
    <h2 class="fw-bold mb-1" style="color:#1D1D1B;"><?php echo __('Account Registration'); ?></h2>
    <p class="text-muted small mb-0"><?php echo __('Use the forms below to create or update the information we have on file for your account'); ?></p>
  </div>

  <div class="ticket-card mt-0 shadow-sm p-4 p-md-5">
    <form action="account.php" method="post">
      <?php csrf_token(); ?>
      <input type="hidden" name="do" value="<?php echo Format::htmlchars($_REQUEST['do']
        ?: ($info['backend'] ? 'import' :'create')); ?>" />

      <table width="100%" cellpadding="0" cellspacing="0" border="0" class="w-100">
        <tbody>
        <?php
            $cf = $user_form ?: UserForm::getInstance();
            $cf->render(array('staff' => false, 'mode' => 'create'));
        ?>
        <tr>
            <td colspan="2" class="pt-4 pb-2">
                <div class="form-header border-bottom pb-2 mb-3">
                    <h4 class="h5 fw-bold m-0" style="color:var(--udla-dark);"><i class="fas fa-globe me-2 text-udla"></i><?php echo __('Preferences'); ?></h4>
                </div>
            </td>
        </tr>
        <tr>
            <td width="180" class="align-middle py-2 fw-semibold" style="color:var(--udla-dark);">
                <?php echo __('Time Zone');?>:
            </td>
            <td class="py-2">
                <?php
                $TZ_NAME = 'timezone';
                $TZ_TIMEZONE = $info['timezone'];
                include INCLUDE_DIR.'staff/templates/timezone.tmpl.php'; ?>
                <div class="error small text-danger mt-1"><?php echo $errors['timezone']; ?></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="pt-4 pb-2">
                <div class="form-header border-bottom pb-2 mb-3">
                    <h4 class="h5 fw-bold m-0" style="color:var(--udla-dark);"><i class="fas fa-key me-2 text-udla"></i><?php echo __('Access Credentials'); ?></h4>
                </div>
            </td>
        </tr>
        <?php if ($info['backend']) { ?>
        <tr>
            <td width="180" class="align-middle py-2 fw-semibold" style="color:var(--udla-dark);">
                <?php echo __('Login With'); ?>:
            </td>
            <td class="py-2">
                <input type="hidden" name="backend" value="<?php echo $info['backend']; ?>"/>
                <input type="hidden" name="username" value="<?php echo $info['username']; ?>"/>
        <?php foreach (UserAuthenticationBackend::allRegistered() as $bk) {
            if ($bk->getBkId() == $info['backend']) {
                echo '<span class="badge bg-light text-dark border px-3 py-2 fs-6">' . Format::htmlchars($bk->getName()) . '</span>';
                break;
            }
        } ?>
            </td>
        </tr>
        <?php } else { ?>
        <tr>
            <td width="180" class="align-middle py-2 fw-semibold" style="color:var(--udla-dark);">
                <?php echo __('Create a Password'); ?>:
            </td>
            <td class="py-2">
                <input type="password" size="18" name="passwd1" maxlength="128" value="<?php echo $info['passwd1']; ?>" class="form-control d-inline-block" style="max-width:300px;">
                &nbsp;<span class="error small text-danger">&nbsp;<?php echo $errors['passwd1']; ?></span>
            </td>
        </tr>
        <tr>
            <td width="180" class="align-middle py-2 fw-semibold" style="color:var(--udla-dark);">
                <?php echo __('Confirm New Password'); ?>:
            </td>
            <td class="py-2">
                <input type="password" size="18" name="passwd2" maxlength="128" value="<?php echo $info['passwd2']; ?>" class="form-control d-inline-block" style="max-width:300px;">
                &nbsp;<span class="error small text-danger">&nbsp;<?php echo $errors['passwd2']; ?></span>
            </td>
        </tr>
        <?php } ?>
        </tbody>
      </table>

      <hr class="my-4">

      <div class="d-flex align-items-center justify-content-center gap-3">
        <button type="submit" class="btn btn-udla px-4 py-2 fw-semibold fs-6">
          <i class="fas fa-user-plus me-1"></i><?php echo __('Register'); ?>
        </button>
        <a href="index.php" class="btn btn-outline-secondary px-4 py-2 fw-semibold fs-6">
          <?php echo __('Cancel'); ?>
        </a>
      </div>
    </form>
  </div>
</div>
<?php if (!isset($info['timezone'])) { ?>
<!-- Auto detect client's timezone where possible -->
<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jstz.min.js?2570d69"></script>
<script type="text/javascript">
$(function() {
    var zone = jstz.determine();
    $('#timezone-dropdown').val(zone.name()).trigger('change');
});
</script>
<?php } ?>

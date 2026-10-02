<div class="container py-4" style="max-width:960px;">
  <!-- Header Title Box -->
  <div class="bg-light p-3 px-4 rounded-3 border-start border-4 border-udla mb-4 shadow-sm">
    <h2 class="fw-bold mb-1" style="color:#1D1D1B;"><?php echo __('Manage Your Profile Information'); ?></h2>
    <p class="text-muted small mb-0"><?php echo __('Use the forms below to update the information we have on file for your account'); ?></p>
  </div>

  <div class="ticket-card mt-0 shadow-sm p-4 p-md-5">
    <form action="profile.php" method="post">
      <?php csrf_token(); ?>
      <table width="100%" cellpadding="0" cellspacing="0" border="0" class="w-100">
        <tbody>
<?php
foreach ($user->getForms() as $f) {
    $f->render(['staff' => false]);
}
if ($acct = $thisclient->getAccount()) {
    $info=$acct->getInfo();
    $info=Format::htmlchars(($errors && $_POST)?$_POST:$info);
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
<?php if ($cfg->getSecondaryLanguages()) { ?>
        <tr>
            <td width="180" class="align-middle py-2 fw-semibold" style="color:var(--udla-dark);">
                <?php echo __('Preferred Language'); ?>:
            </td>
            <td class="py-2">
    <?php
    $langs = Internationalization::getConfiguredSystemLanguages(); ?>
                <select name="lang" class="form-select d-inline-block" style="max-width:300px;">
                    <option value="">&mdash; <?php echo __('Use Browser Preference'); ?> &mdash;</option>
<?php foreach($langs as $l) {
$selected = ($info['lang'] == $l['code']) ? 'selected="selected"' : ''; ?>
                    <option value="<?php echo $l['code']; ?>" <?php echo $selected;
                        ?>><?php echo Internationalization::getLanguageDescription($l['code']); ?></option>
<?php } ?>
                </select>
                <span class="error small text-danger">&nbsp;<?php echo $errors['lang']; ?></span>
            </td>
        </tr>
<?php }
      if ($acct->isPasswdResetEnabled()) { ?>
        <tr>
            <td colspan="2" class="pt-4 pb-2">
                <div class="form-header border-bottom pb-2 mb-3">
                    <h4 class="h5 fw-bold m-0" style="color:var(--udla-dark);"><i class="fas fa-key me-2 text-udla"></i><?php echo __('Access Credentials'); ?></h4>
                </div>
            </td>
        </tr>
<?php if (!isset($_SESSION['_client']['reset-token'])) { ?>
        <tr>
            <td width="180" class="align-middle py-2 fw-semibold" style="color:var(--udla-dark);">
                <?php echo __('Current Password'); ?>:
            </td>
            <td class="py-2">
                <input type="password" size="18" name="cpasswd" maxlength="128" value="<?php echo $info['cpasswd']; ?>" class="form-control d-inline-block" style="max-width:300px;">
                &nbsp;<span class="error small text-danger">&nbsp;<?php echo $errors['cpasswd']; ?></span>
            </td>
        </tr>
<?php } ?>
        <tr>
            <td width="180" class="align-middle py-2 fw-semibold" style="color:var(--udla-dark);">
                <?php echo __('New Password'); ?>:
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
<?php } ?>
        </tbody>
      </table>

      <hr class="my-4">

      <div class="d-flex gap-2 justify-content-center align-items-center">
          <button type="submit" class="btn btn-udla fw-semibold px-4 fs-6"><?php echo __('Update'); ?></button>
          <button type="reset" class="btn btn-outline-secondary px-4 fs-6"><?php echo __('Reset'); ?></button>
          <a href="index.php" class="btn btn-outline-secondary px-4 fs-6"><?php echo __('Cancel'); ?></a>
      </div>
    </form>
  </div>
</div><!-- /.container -->


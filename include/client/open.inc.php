<?php
if(!defined('OSTCLIENTINC')) die('Access Denied!');
$info=array();
if($thisclient && $thisclient->isValid()) {
    $info=array('name'=>$thisclient->getName(),
                'email'=>$thisclient->getEmail(),
                'phone'=>$thisclient->getPhoneNumber());
}

$info=($_POST && $errors)?Format::htmlchars($_POST):$info;

$form = null;
if (!$info['topicId']) {
    if (array_key_exists('topicId',$_GET) && preg_match('/^\d+$/',$_GET['topicId']) && Topic::lookup($_GET['topicId']))
        $info['topicId'] = intval($_GET['topicId']);
    else
        $info['topicId'] = $cfg->getDefaultTopicId();
}

$forms = array();
if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {
    foreach ($topic->getForms() as $F) {
        if (!$F->hasAnyVisibleFields())
            continue;
        if ($_POST) {
            $F = $F->instanciate();
            $F->isValidForClient();
        }
        $forms[] = $F->getForm();
    }
}

?>
<div class="container py-4" style="max-width:960px;">
  <!-- Header Title Box -->
  <div class="bg-light p-3 px-4 rounded-3 border-start border-4 border-udla mb-4 shadow-sm">
    <h2 class="fw-bold mb-1" style="color:#1D1D1B;">Abrir un Nuevo Ticket</h2>
    <p class="text-muted small mb-0">Por favor complete el siguiente formulario para solicitar asistencia a la Clínica de Ciberseguridad UDLA.</p>
  </div>

  <div class="ticket-card mt-0 shadow-sm p-4 p-md-5">

    <form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data">
      <?php csrf_token(); ?>
      <input type="hidden" name="a" value="open">
      
      <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tbody>
    <?php
            if (!$thisclient) {
                $uform = UserForm::getUserForm()->getForm($_POST);
                if ($_POST) $uform->isValid();
                $uform->render(array('staff' => false, 'mode' => 'create'));
            }
            else { ?>
            <tr>
              <td colspan="2">
                <div class="p-3 bg-light rounded-3 mb-3 border">
                  <div class="row g-2 small">
                    <div class="col-sm-6">
                      <span class="text-muted d-block"><?php echo __('Email'); ?>:</span>
                      <strong class="text-dark"><?php echo $thisclient->getEmail(); ?></strong>
                    </div>
                    <div class="col-sm-6">
                      <span class="text-muted d-block"><?php echo __('Client'); ?>:</span>
                      <strong class="text-dark"><?php echo Format::htmlchars($thisclient->getName()); ?></strong>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <?php } ?>
        </tbody>
        <tbody>
        <tr>
          <td colspan="2" class="pt-3">
            <div class="form-header mb-2">
              <label for="topicId" class="form-label fw-bold" style="color:var(--udla-dark);"><i class="fas fa-list-ul me-2 text-udla"></i><?php echo __('Help Topic'); ?></label>
            </div>
            <select id="topicId" name="topicId" class="form-select form-select-lg fs-6 w-100" onchange="javascript:
                        var data = $(':input[name]', '#dynamic-form').serialize();
                        $.ajax(
                          'ajax.php/form/help-topic/' + this.value,
                          {
                            data: data,
                            dataType: 'json',
                            success: function(json) {
                              $('#dynamic-form').empty().append(json.html);
                              $(document.head).append(json.media);
                            }
                          });">
                    <option value="" selected="selected">&mdash; <?php echo __('Select a Help Topic');?> &mdash;</option>
                    <?php
                    if($topics=Topic::getPublicHelpTopics()) {
                        foreach($topics as $id =>$name) {
                            echo sprintf('<option value="%d" %s>%s</option>',
                                    $id, ($info['topicId']==$id)?'selected="selected"':'', $name);
                        }
                    } ?>
            </select>
            <?php if ($errors['topicId']) { ?>
              <div class="error mt-1"><i class="fas fa-exclamation-circle me-1"></i><?php echo $errors['topicId']; ?></div>
            <?php } ?>
          </td>
        </tr>
        </tbody>
        <tbody id="dynamic-form">
            <?php
            $options = array('mode' => 'create');
            foreach ($forms as $form) {
                include(CLIENTINC_DIR . 'templates/dynamic-form.tmpl.php');
            } ?>
        </tbody>
        <tbody>
        <?php
        if($cfg && $cfg->isCaptchaEnabled() && (!$thisclient || !$thisclient->isValid())) {
            if($_POST && $errors && !$errors['captcha'])
                $errors['captcha']=__('Please re-enter the text again');
            ?>
        <tr class="captchaRow">
            <td class="required pt-3"><?php echo __('CAPTCHA Text');?>:</td>
            <td class="pt-3">
                <span class="captcha"><img src="captcha.php" border="0" align="left"></span>
                &nbsp;&nbsp;
                <input id="captcha" type="text" name="captcha" size="6" autocomplete="off" class="form-control d-inline-block w-auto">
                <br/><em class="small text-muted"><?php echo __('Enter the text shown on the image.');?></em>
                <?php if ($errors['captcha']) { ?>
                  <div class="error mt-1"><?php echo $errors['captcha']; ?></div>
                <?php } ?>
            </td>
        </tr>
        <?php
        } ?>
        <tr><td colspan="2">&nbsp;</td></tr>
        </tbody>
      </table>

      <hr class="my-4" style="border-color:#edf0f2;"/>

      <div class="d-flex flex-wrap gap-2 justify-content-end">
            <button type="button" name="cancel" class="btn btn-outline-secondary px-4 py-2 fw-medium" onclick="javascript:
                $('.richtext').each(function() {
                    var redactor = $(this).data('redactor');
                    if (redactor && redactor.opts.draftDelete)
                        redactor.plugin.draft.deleteDraft();
                });
                window.location.href='index.php';">
              <i class="fas fa-times me-2"></i><?php echo __('Cancel'); ?>
            </button>
            <button type="reset" name="reset" class="btn btn-outline-secondary px-4 py-2 fw-medium">
              <i class="fas fa-undo me-2"></i><?php echo __('Reset');?>
            </button>
            <button type="submit" class="btn btn-udla fw-semibold px-4 py-2">
              <i class="fas fa-paper-plane me-2"></i><?php echo __('Create Ticket');?>
            </button>
      </div>
    </form>
  </div><!-- /.ticket-card -->
</div><!-- /.container -->

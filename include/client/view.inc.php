<?php
if(!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkUserAccess($thisclient)) die('Access Denied!');

$info=($_POST && $errors)?Format::htmlchars($_POST):array();

$type = array('type' => 'viewed');
Signal::send('object.view', $ticket, $type);

$dept = $ticket->getDept();

if ($ticket->isClosed() && !$ticket->isReopenable())
    $warn = sprintf(__('%s is marked as closed and cannot be reopened.'), __('This ticket'));

//Making sure we don't leak out internal dept names
if(!$dept || !$dept->isPublic())
    $dept = $cfg->getDefaultDept();

if ($thisclient && $thisclient->isGuest()
    && $cfg->isClientRegistrationEnabled()) { ?>

<div id="msg_info">
    <i class="icon-compass icon-2x pull-left"></i>
    <strong><?php echo __('Looking for your other tickets?'); ?></strong><br />
    <a href="<?php echo ROOT_PATH; ?>login.php?e=<?php
        echo urlencode($thisclient->getEmail());
    ?>" style="text-decoration:underline"><?php echo __('Sign In'); ?></a>
    <?php echo sprintf(__('or %s register for an account %s for the best experience on our help desk.'),
        '<a href="account.php?do=create" style="text-decoration:underline">','</a>'); ?>
    </div>

<?php } ?>

<div class="container py-4" style="max-width:960px;">
  <div class="ticket-card">
    
    <!-- Ticket Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <span class="badge bg-udla px-2.5 py-1 fs-6">#<?php echo $ticket->getNumber(); ?></span>
          <span class="badge bg-secondary px-2.5 py-1 fs-6"><?php echo ($S = $ticket->getStatus()) ? $S->getLocalName() : ''; ?></span>
        </div>
        <h2 class="fw-bold mb-0" style="color:#1D1D1B;">
          <?php $subject_field = TicketForm::getInstance()->getField('subject');
                echo $subject_field->display($ticket->getSubject()); ?>
        </h2>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a class="btn btn-outline-secondary btn-sm" href="tickets.php?id=<?php echo $ticket->getId(); ?>" title="<?php echo __('Reload'); ?>">
          <i class="fas fa-sync-alt me-1"></i><?php echo __('Reload'); ?>
        </a>
        <a class="btn btn-outline-secondary btn-sm" href="tickets.php?a=print&id=<?php echo $ticket->getId(); ?>">
          <i class="fas fa-print me-1"></i><?php echo __('Print'); ?>
        </a>
        <?php if ($ticket->hasClientEditableFields() && $thisclient->getId() == $ticket->getUserId()) { ?>
          <a class="btn btn-udla btn-sm fw-semibold" href="tickets.php?a=edit&id=<?php echo $ticket->getId(); ?>">
            <i class="fas fa-edit me-1"></i><?php echo __('Edit'); ?>
          </a>
        <?php } ?>
      </div>
    </div>

    <!-- Ticket Info Grid -->
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="p-3 bg-light rounded-3 h-100 border">
          <h6 class="fw-bold text-udla mb-3"><i class="fas fa-info-circle me-1"></i><?php echo __('Basic Ticket Information'); ?></h6>
          <table class="table table-borderless table-sm mb-0 small">
            <tr>
              <td class="text-muted" width="120"><?php echo __('Ticket Status');?>:</td>
              <td class="fw-semibold"><?php echo ($S = $ticket->getStatus()) ? $S->getLocalName() : ''; ?></td>
            </tr>
            <tr>
              <td class="text-muted"><?php echo __('Department');?>:</td>
              <td class="fw-semibold"><?php echo Format::htmlchars($dept instanceof Dept ? $dept->getName() : ''); ?></td>
            </tr>
            <tr>
              <td class="text-muted"><?php echo __('Create Date');?>:</td>
              <td class="fw-semibold"><?php echo Format::datetime($ticket->getCreateDate()); ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-md-6">
        <div class="p-3 bg-light rounded-3 h-100 border">
          <h6 class="fw-bold text-udla mb-3"><i class="fas fa-user me-1"></i><?php echo __('User Information'); ?></h6>
          <table class="table table-borderless table-sm mb-0 small">
            <tr>
              <td class="text-muted" width="120"><?php echo __('Name');?>:</td>
              <td class="fw-semibold"><?php echo mb_convert_case(Format::htmlchars($ticket->getName()), MB_CASE_TITLE); ?></td>
            </tr>
            <tr>
              <td class="text-muted"><?php echo __('Email');?>:</td>
              <td class="fw-semibold"><?php echo Format::htmlchars($ticket->getEmail()); ?></td>
            </tr>
            <tr>
              <td class="text-muted"><?php echo __('Phone');?>:</td>
              <td class="fw-semibold"><?php echo $ticket->getPhoneNumber(); ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <!-- Custom Form Data -->
    <?php
    $sections = $forms = array();
    foreach (DynamicFormEntry::forTicket($ticket->getId()) as $i=>$form) {
        $answers = $form->getAnswers()->exclude(Q::any(array(
            'field__flags__hasbit' => DynamicFormField::FLAG_EXT_STORED,
            'field__name__in' => array('subject', 'priority'),
            Q::not(array('field__flags__hasbit' => DynamicFormField::FLAG_CLIENT_VIEW)),
        )));
        foreach ($answers as $j=>$a) {
            if ($v = $a->display())
                $sections[$i][$j] = array($v, $a);
        }
        $forms[$i] = $form->getTitle();
    }
    foreach ($sections as $i=>$answers) {
    ?>
      <div class="p-3 bg-light rounded-3 mb-4 border">
        <h6 class="fw-bold text-dark mb-2"><?php echo $forms[$i]; ?></h6>
        <table class="table table-borderless table-sm mb-0 small">
          <?php foreach ($answers as $A) { list($v, $a) = $A; ?>
            <tr>
              <td class="text-muted" width="160"><?php echo $a->getField()->get('label'); ?>:</td>
              <td class="fw-medium"><?php echo $v; ?></td>
            </tr>
          <?php } ?>
        </table>
      </div>
    <?php } ?>

    <!-- Thread Container -->
    <div class="my-4">
      <?php
      $ticket->getThread()->render(array('M', 'R'), array(
                      'mode' => Thread::MODE_CLIENT,
                      'html-id' => 'ticketThread')
                  );
      if ($blockReply = $ticket->isChild() && $ticket->getMergeType() != 'visual')
          $warn = sprintf(__('This Ticket is Merged into another Ticket. Please go to the %s%d%s to reply.'),
              '<a href="tickets.php?id=', $ticket->getPid(), '" style="text-decoration:underline">Parent</a>');
      ?>
    </div>

    <!-- Messages / Alerts -->
    <?php if($errors['err']) { ?>
        <div class="alert alert-danger rounded-3 mb-3"><?php echo $errors['err']; ?></div>
    <?php }elseif($msg) { ?>
        <div class="alert alert-success rounded-3 mb-3"><?php echo $msg; ?></div>
    <?php }elseif($warn) { ?>
        <div class="alert alert-warning rounded-3 mb-3"><?php echo $warn; ?></div>
    <?php }

    if ((!$ticket->isClosed() || $ticket->isReopenable()) && !$blockReply) { ?>
      <!-- Reply Form -->
      <form id="reply" action="tickets.php?id=<?php echo $ticket->getId(); ?>#reply" name="reply" method="post" enctype="multipart/form-data" class="mt-4 pt-4 border-top">
          <?php csrf_token(); ?>
          <h4 class="fw-bold text-dark mb-2"><i class="fas fa-reply me-2 text-udla"></i><?php echo __('Post a Reply');?></h4>
          <input type="hidden" name="id" value="<?php echo $ticket->getId(); ?>">
          <input type="hidden" name="a" value="reply">
          
          <div class="mb-3">
              <p class="text-muted small mb-2">
                <em><?php echo __('To best assist you, we request that you be specific and detailed'); ?></em>
                <?php if ($errors['message']) { ?><span class="error ms-2"><?php echo $errors['message']; ?></span><?php } ?>
              </p>
              <textarea name="<?php echo $messageField->getFormName(); ?>" id="message" cols="50" rows="6" wrap="soft"
                  class="form-control <?php if ($cfg->isRichTextEnabled()) echo 'richtext'; ?> draft"
                  <?php list($draft, $attrs) = Draft::getDraftAndDataAttrs('ticket.client', $ticket->getId(), $info['message']); echo $attrs; ?>>
                  <?php echo $draft ?: $info['message']; ?>
              </textarea>
              <?php
              if ($messageField->isAttachmentsEnabled()) {
                  print $attachments->render(array('client'=>true));
              } ?>
          </div>

          <?php if ($ticket->isClosed() && $ticket->isReopenable()) { ?>
            <div class="alert alert-warning py-2 small mb-3">
              <i class="fas fa-exclamation-triangle me-1"></i><?php echo __('Ticket will be reopened on message post'); ?>
            </div>
          <?php } ?>

          <div class="d-flex gap-2 justify-content-end mt-3">
              <button type="button" class="btn btn-outline-secondary px-4 fw-medium" onClick="history.go(-1)">
                <i class="fas fa-arrow-left me-1"></i><?php echo __('Cancel');?>
              </button>
              <button type="reset" class="btn btn-outline-secondary px-4 fw-medium">
                <i class="fas fa-undo me-1"></i><?php echo __('Reset');?>
              </button>
              <button type="submit" class="btn btn-udla fw-semibold px-4">
                <i class="fas fa-paper-plane me-1"></i><?php echo __('Post Reply');?>
              </button>
          </div>
      </form>
    <?php } ?>

  </div><!-- /.ticket-card -->


<script type="text/javascript">
<?php
// Hover support for all inline images
$urls = array();
foreach (AttachmentFile::objects()->filter(array(
    'attachments__thread_entry__thread__id' => $ticket->getThreadId(),
    'attachments__inline' => true,
)) as $file) {
    $urls[strtolower($file->getKey())] = array(
        'download_url' => $file->getDownloadUrl(['type' => 'H']),
        'filename' => $file->name,
    );
} ?>
showImagesInline(<?php echo JsonDataEncoder::encode($urls); ?>);
</script>

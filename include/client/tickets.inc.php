<?php
if(!defined('OSTCLIENTINC') || !is_object($thisclient) || !$thisclient->isValid()) die('Access Denied');

$settings = &$_SESSION['client:Q'];

// Unpack search, filter, and sort requests
if (isset($_REQUEST['clear']))
    $settings = array();
if (isset($_REQUEST['keywords'])) {
    $settings['keywords'] = $_REQUEST['keywords'];
}
if (isset($_REQUEST['topic_id'])) {
    $settings['topic_id'] = $_REQUEST['topic_id'];
}
if (isset($_REQUEST['status'])) {
    $settings['status'] = $_REQUEST['status'];
}

$org_tickets = $thisclient->canSeeOrgTickets();
if ($settings['keywords']) {
    // Don't show stat counts for searches
    $openTickets = $closedTickets = -1;
}
elseif ($settings['topic_id']) {
    $openTickets = $thisclient->getNumTopicTicketsInState($settings['topic_id'],
        'open', $org_tickets);
    $closedTickets = $thisclient->getNumTopicTicketsInState($settings['topic_id'],
        'closed', $org_tickets);
}
else {
    $openTickets = $thisclient->getNumOpenTickets($org_tickets);
    $closedTickets = $thisclient->getNumClosedTickets($org_tickets);
}

$tickets = Ticket::objects();

$qs = array();
$status=null;

$sortOptions=array('id'=>'number', 'subject'=>'cdata__subject',
                    'status'=>'status__name', 'dept'=>'dept__name','date'=>'created');
$orderWays=array('DESC'=>'-','ASC'=>'');
//Sorting options...
$order_by=$order=null;
$sort=($_REQUEST['sort'] && $sortOptions[strtolower($_REQUEST['sort'])])?strtolower($_REQUEST['sort']):'date';
if($sort && $sortOptions[$sort])
    $order_by =$sortOptions[$sort];

$order_by=$order_by ?: $sortOptions['date'];
if ($_REQUEST['order'] && !is_null($orderWays[strtoupper($_REQUEST['order'])]))
    $order = $orderWays[strtoupper($_REQUEST['order'])];
else
    $order = $orderWays['DESC'];

$x=$sort.'_sort';
$$x=' class="'.strtolower($_REQUEST['order'] ?: 'desc').'" ';

$basic_filter = Ticket::objects();
if ($settings['topic_id']) {
    $basic_filter = $basic_filter->filter(array('topic_id' => $settings['topic_id']));
}

if ($settings['status'])
    $status = strtolower($settings['status']);
    switch ($status) {
    default:
        $status = 'open';
    case 'open':
    case 'closed':
		$results_type = ($status == 'closed') ? __('Closed Tickets') : __('Open Tickets');
        $basic_filter->filter(array('status__state' => $status));
        break;
}

// Add visibility constraints — use a union query to use multiple indexes,
// use UNION without "ALL" (false as second parameter to union()) to imply
// unique values
$visibility = $basic_filter->copy()
    ->values_flat('ticket_id')
    ->filter(array('user_id' => $thisclient->getId()));

// Add visibility of Tickets where the User is a Collaborator if enabled
if ($cfg->collaboratorTicketsVisibility())
    $visibility = $visibility
    ->union($basic_filter->copy()
        ->values_flat('ticket_id')
        ->filter(array('thread__collaborators__user_id' => $thisclient->getId()))
    , false);

if ($thisclient->canSeeOrgTickets()) {
    $visibility = $visibility->union(
        $basic_filter->copy()->values_flat('ticket_id')
            ->filter(array('user__org_id' => $thisclient->getOrgId()))
    , false);
}

// Perform basic search
if ($settings['keywords']) {
    $q = trim($settings['keywords']);
    if (is_numeric($q)) {
        $tickets->filter(array('number__startswith'=>$q));
    } elseif (strlen($q) > 2) { //Deep search!
        // Use the search engine to perform the search
        $tickets = $ost->searcher->find($q, $tickets);
    }
}

$tickets->distinct('ticket_id');

TicketForm::ensureDynamicDataView();

$total=$visibility->count();
$page=($_GET['p'] && is_numeric($_GET['p']))?$_GET['p']:1;
$pageNav=new Pagenate($total, $page, PAGE_LIMIT);
$qstr = '&amp;'. Http::build_query($qs);
$qs += array('sort' => $_REQUEST['sort'], 'order' => $_REQUEST['order']);
$pageNav->setURL('tickets.php', $qs);
$tickets->filter(array('ticket_id__in' => $visibility));
$pageNav->paginate($tickets);

$showing =$total ? $pageNav->showing() : "";
if(!$results_type)
{
	$results_type=ucfirst($status).' '.__('Tickets');
}
$showing.=($status)?(' '.$results_type):' '.__('All Tickets');
if($search)
    $showing=__('Search Results').": $showing";

$negorder=$order=='-'?'ASC':'DESC'; //Negate the sorting

$tickets->order_by($order.$order_by);
$tickets->values(
    'ticket_id', 'number', 'created', 'isanswered', 'source', 'status_id',
    'status__state', 'status__name', 'cdata__subject', 'dept_id',
    'dept__name', 'dept__ispublic', 'user__default_email__address', 'user_id'
);

?>
<div class="container py-4" style="max-width:960px;">
  <div class="ticket-card">
    
    <!-- Header with status tabs -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom">
      <div class="d-flex align-items-center gap-2">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-udla p-2" style="width:44px;height:44px;">
          <i class="fas fa-folder-open fs-5" style="color:var(--udla-orange);"></i>
        </div>
        <h2 class="fw-bold mb-0" style="color:#1D1D1B;"><?php echo __('Tickets'); ?></h2>
      </div>

      <div class="btn-group">
        <?php if ($openTickets) { ?>
          <a class="btn btn-sm <?php echo ($status == 'open') ? 'btn-udla fw-bold' : 'btn-outline-secondary'; ?>"
             href="?<?php echo Http::build_query(array('a' => 'search', 'status' => 'open')); ?>">
            <i class="fas fa-envelope-open me-1"></i><?php echo __('Open'); if ($openTickets > 0) echo sprintf(' (%d)', $openTickets); ?>
          </a>
        <?php }
        if ($closedTickets) { ?>
          <a class="btn btn-sm <?php echo ($status == 'closed') ? 'btn-udla fw-bold' : 'btn-outline-secondary'; ?>"
             href="?<?php echo Http::build_query(array('a' => 'search', 'status' => 'closed')); ?>">
            <i class="fas fa-check-circle me-1"></i><?php echo __('Closed'); if ($closedTickets > 0) echo sprintf(' (%d)', $closedTickets); ?>
          </a>
        <?php } ?>
      </div>
    </div>

    <!-- Search & Filter Bar -->
    <form action="tickets.php" method="get" id="ticketSearchForm" class="mb-4">
      <input type="hidden" name="a" value="search">
      <div class="row g-2 align-items-center">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
            <input type="text" name="keywords" class="form-control border-start-0" placeholder="<?php echo __('Search tickets...'); ?>" value="<?php echo Format::htmlchars($settings['keywords']); ?>">
            <button type="submit" class="btn btn-udla fw-semibold"><?php echo __('Search');?></button>
          </div>
        </div>
        <div class="col-md-6">
          <select name="topic_id" class="form-select" onchange="javascript: this.form.submit();">
            <option value="">&mdash; <?php echo __('All Help Topics');?> &mdash;</option>
            <?php
            foreach (Topic::getHelpTopics(true) as $id=>$name) {
                $count = $thisclient->getNumTopicTickets($id, $org_tickets);
                if ($count == 0) continue;
            ?>
              <option value="<?php echo $id; ?>" <?php if ($settings['topic_id'] == $id) echo 'selected="selected"'; ?>>
                <?php echo sprintf('%s (%d)', Format::htmlchars($name), $thisclient->getNumTopicTickets($id)); ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <?php if ($settings['keywords'] || $settings['topic_id'] || $_REQUEST['sort']) { ?>
        <div class="mt-2 text-end">
          <a href="?clear" class="small text-muted text-decoration-none"><i class="fas fa-times-circle me-1"></i><?php echo __('Clear all filters and sort'); ?></a>
        </div>
      <?php } ?>
    </form>

    <!-- Tickets Table -->
    <div class="table-responsive">
      <table id="ticketTable" class="table align-middle">
        <thead>
          <tr>
            <th nowrap>
              <a href="tickets.php?sort=ID&order=<?php echo $negorder; ?><?php echo $qstr; ?>" class="text-decoration-none text-dark">
                <?php echo __('Ticket #');?> <i class="fas fa-sort ms-1 small text-muted"></i>
              </a>
            </th>
            <th>
              <a href="tickets.php?sort=date&order=<?php echo $negorder; ?><?php echo $qstr; ?>" class="text-decoration-none text-dark">
                <?php echo __('Create Date');?> <i class="fas fa-sort ms-1 small text-muted"></i>
              </a>
            </th>
            <th>
              <a href="tickets.php?sort=status&order=<?php echo $negorder; ?><?php echo $qstr; ?>" class="text-decoration-none text-dark">
                <?php echo __('Status');?> <i class="fas fa-sort ms-1 small text-muted"></i>
              </a>
            </th>
            <th>
              <a href="tickets.php?sort=subject&order=<?php echo $negorder; ?><?php echo $qstr; ?>" class="text-decoration-none text-dark">
                <?php echo __('Subject');?> <i class="fas fa-sort ms-1 small text-muted"></i>
              </a>
            </th>
            <th>
              <a href="tickets.php?sort=dept&order=<?php echo $negorder; ?><?php echo $qstr; ?>" class="text-decoration-none text-dark">
                <?php echo __('Department');?> <i class="fas fa-sort ms-1 small text-muted"></i>
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
        <?php
        $subject_field = TicketForm::objects()->one()->getField('subject');
        $defaultDept=Dept::getDefaultDeptName();
        if ($tickets->exists(true)) {
            foreach ($tickets as $T) {
               $dept = $T['dept__ispublic']
                   ? Dept::getLocalById($T['dept_id'], 'name', $T['dept__name'])
                   : $defaultDept;
               $subject = $subject_field->display(
                   $subject_field->to_php($T['cdata__subject']) ?: $T['cdata__subject']
               );
               $statusName = TicketStatus::getLocalById($T['status_id'], 'value', $T['status__name']);
               $ticketNumber=$T['number'];
               if($T['isanswered'] && !strcasecmp($T['status__state'], 'open')) {
                   $subject="<b>$subject</b>";
                   $ticketNumber="<b>$ticketNumber</b>";
               }
               $thisclient->getId() != $T['user_id'] ? $isCollab = true : $isCollab = false;
               
               $badgeClass = (strtolower($T['status__state']) == 'open') ? 'bg-success' : 'bg-secondary';
               ?>
               <tr id="<?php echo $T['ticket_id']; ?>">
                   <td>
                     <a class="fw-bold text-udla text-decoration-none" title="<?php echo $T['user__default_email__address']; ?>"
                        href="tickets.php?id=<?php echo $T['ticket_id']; ?>">
                        #<?php echo $ticketNumber; ?>
                     </a>
                   </td>
                   <td class="text-muted small"><?php echo Format::date($T['created']); ?></td>
                   <td><span class="badge <?php echo $badgeClass; ?> px-2 py-1 fs-7"><?php echo $statusName; ?></span></td>
                   <td>
                     <a class="text-dark text-decoration-none fw-medium" href="tickets.php?id=<?php echo $T['ticket_id']; ?>">
                       <?php if ($isCollab) { ?><i class="fas fa-users text-muted me-1"></i><?php } ?>
                       <?php echo $subject; ?>
                     </a>
                   </td>
                   <td class="text-muted small"><?php echo $dept; ?></td>
               </tr>
           <?php
           }
        } else {
            echo '<tr><td colspan="5" class="text-center py-4 text-muted">'.__('Your query did not match any records').'</td></tr>';
        }
        ?>
        </tbody>
      </table>
    </div>

    <?php if ($total) { ?>
      <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center small text-muted">
        <div><?php echo $showing; ?></div>
        <div><?php echo __('Page').': '.$pageNav->getPageLinks(); ?></div>
      </div>
    <?php } ?>

  </div><!-- /.ticket-card -->
</div><!-- /.container -->

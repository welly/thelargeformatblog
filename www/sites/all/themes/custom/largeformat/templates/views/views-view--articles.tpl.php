<?php
/**
 * @file
 * Main view template.
 */
?>

<?php if ($attachment_before): ?>
  <div class="view__attachment-before">
    <?php print $attachment_before; ?>
  </div>
<?php endif; ?>

<?php if ($rows): ?>
  <div class="post-teasers">
  <?php print $rows; ?>
  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>
  </div>
<?php elseif ($empty): ?>
  <div class="post__empty">
    <div class="post__content">
      <?php print $empty; ?>
    </div>
  </div>
<?php endif; ?>


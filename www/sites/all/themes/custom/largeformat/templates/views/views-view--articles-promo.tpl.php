<?php
/**
 * @file
 * Main view template.
 */
?>
<?php if ($rows): ?>
  <?php print $rows; ?>
<?php elseif ($empty): ?>
  <div class="post__empty">
    <div class="post__content">
      <?php print $empty; ?>
    </div>
  </div>
<?php endif; ?>

<?php if ($pager): ?>
  <?php print $pager; ?>
<?php endif; ?>
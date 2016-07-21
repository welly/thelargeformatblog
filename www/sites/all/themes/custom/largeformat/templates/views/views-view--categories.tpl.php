<?php
/**
 * @file
 * Main view template.
 */
?>

<?php if ($rows): ?>
  <div class="post__list">
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


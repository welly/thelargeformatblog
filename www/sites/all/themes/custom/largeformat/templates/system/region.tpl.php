<?php
/**
 * @file
 * Theme implementation to display a region.
 */
?>
<?php if ($content): ?>
  <?php print $region_open; ?>
    <div class="content">
      <?php print $content; ?>
    </div>
  <?php print $region_close; ?>
<?php endif; ?>

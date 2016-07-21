<?php
/**
 * @file
 * Default template file for oembed data
 */
?>
<div<?php print $attributes; ?>>
  <span<?php print $content_attributes; ?>>
    <?php print render($content); ?>
  </span>
</div>

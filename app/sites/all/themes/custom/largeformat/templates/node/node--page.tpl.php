<?php

$wrapper = entity_metadata_wrapper('node', $node);
$title = $wrapper->title->value();
$body = $wrapper->body->value->value();

?>

<article class="page page--full">
  <header class="page__header">
    <h2 class="entity__title page__title"><?php echo $title; ?></h2>
  </header>
  <div class="page__content">
    <div class="page__body">
      <?php echo $body; ?>
    </div>
  </div>
</article>
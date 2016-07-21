<?php

$date = date('jS F, Y', $node->created);

$wrapper = entity_metadata_wrapper('node', $node);
$title = $wrapper->title->value();
$body = $wrapper->body->value();
$event_type = $wrapper->field_event_type->value();
$title = $event_type->name . ': ' . $title;
$event_date = $wrapper->field_date->value();

$dates = [];
foreach($event_date as $event_date_item) {
  $date = '<span class="event__date">' . date('D j M Y', strtotime($event_date_item['value']));
  if ($event_date_item['value2'] && ($event_date_item['value'] != $event_date_item['value2'])) {
    $date .= ' to ' . date('D j M Y', strtotime($event_date_item['value2']));
  }
  $dates[] = $date . '</span>';
}

$summary = $wrapper->body->value();
if ($summary['summary']) {
  $summary = trim(strip_tags($summary['summary']));
} else {
  $alter = array(
    'max_length' => 250,
    'word_boundary' => TRUE,
    'html' => TRUE,
    'ellipsis' => TRUE,
  );
  $summary = views_trim_text($alter, trim(strip_tags($summary['value'])));
}

$image = $wrapper->field_image->value();
if (isset($image)) {
  $options = array(
    'style_name' => 'teaser',
    'path' => $image['uri'],
    'alt' => $title,
    'attributes' => array('class' => 'post__image')
  );
  $image = l(theme('image_style', $options), drupal_get_path_alias('node/' . $node->nid), array('html' => true));
}

$link = l($title, drupal_get_path_alias('node/' . $node->nid), array('attributes' => array('class' => 'post__link')));

?>

<article class="post post__teaser">
  <div class="post__contents">
    <header class="post__header">
      <h2 class="post__title"><?php echo $link; ?></h2>
    </header>
    <?php echo $image; ?>
    <div class="post__summary">
      <p><?php echo $summary; ?></p>
    </div>
    <?php if ($event_date) { ?>
    <div class="post__byline">
        Event date: <?php echo implode(', ', $dates); ?>
    </div>
    <?php } ?>
  </div>
</article>

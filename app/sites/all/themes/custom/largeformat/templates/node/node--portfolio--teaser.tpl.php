<?php

$date = date('jS F, Y', $node->created);

$wrapper = entity_metadata_wrapper('node', $node);
$title = $wrapper->title->value();
$body = $wrapper->body->value->value();
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

$author = $wrapper->field_author->value();
$author_name = $wrapper->field_author->title->value();
$author_link = l($author_name, drupal_get_path_alias('node/' . $author->nid), array('attributes' => array('class' => 'author__link')));

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
    <div class="post__byline">By <?php echo $author_link; ?> on <time class="post__date"><?php echo $date; ?></time></div>
  </div>
</article>

<?php

$wrapper = entity_metadata_wrapper('node', $node);
$title = $wrapper->title->value();
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
$image = file_create_url($image['uri']);
$image_height = $wrapper->field_image_height->value();

$link = l($title, drupal_get_path_alias('node/' . $node->nid), array('attributes' => array('class' => 'post__link')));
?>

<div class="post post--promoted <?php echo $image_height; ?>" style="background-image:url(<?php echo $image; ?>); ?>" data-top-bottom="background-position: 50% 50px" data-center="background-position: 50% -200px">
  <article class="post__article">
    <div class="post__contents">
      <header class="post__header">
        <h2 class="post__title"><?php echo $link; ?></h2>
        <div class="post__byline">By <?php echo $author_link; ?> on <time class="post__date"><?php echo $date; ?></time></div>
      </header>
      <div class="post__summary">
        <p><?php echo $summary; ?></p>
      </div>
    </div>
    <div class="post__overlay"></div>
  </article>
</div>

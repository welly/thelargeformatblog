<?php
function tags_link($value) {
  return l($value->name, drupal_get_path_alias('taxonomy/term/' . $value->tid));
};

$wrapper = entity_metadata_wrapper('node', $node);
$title = $wrapper->title->value();
$body = $wrapper->body->value->value();
$tags = $wrapper->field_tags->value();
$full_size = $wrapper->field_image_full->value();
$image_height = $wrapper->field_image_height->value();
$image_hide = $wrapper->field_image_hide->value();

if (count($tags)) {
  $tags = implode(', ', array_map('tags_link', $tags));
}

$author = $wrapper->field_author->value();
$author_name = $wrapper->field_author->title->value();
$author_image = $wrapper->field_author->field_image->value();
if (isset($author_image)) {
  $options = array(
    'style_name' => 'author',
    'path' => $author_image['uri'],
    'alt' => $title,
    'attributes' => array('class' => 'author__image')
  );
  $author_image = theme('image_style', $options);
}
$author_link = l($author_name, drupal_get_path_alias('node/' . $author->nid), array('attributes' => array('class' => 'author__link')));

$image = $wrapper->field_image->value();
$image_large = image_style_url('xlarge', $image['uri']);
$options = array(
  'style_name' => 'medium',
  'path' => $image['uri'],
  'alt' => $title,
  'attributes' => array('class' => 'post__image--regular')
);
$image_regular = theme('image', $options);
$image_full = file_create_url($image['uri']);

$link = l($title, drupal_get_path_alias('node/' . $node->nid), array('attributes' => array('class' => 'post__link')));

?>

<article class="post post--full post--portfolio">
  <?php if ($full_size) { ?>
  <div class="post__cover <?php echo $image_height; ?>" style="background-image:url('<?php echo $image_full; ?>');" data-center="background-position: 50% -200px" data-top-bottom="background-position: 50% 0">
    <a class="post__fancybox fancybox colorbox-load" href="<?php echo $image_large; ?>"><span>View large</span></a>
  </div>
  <?php } ?>
  <header class="post-header">
    <div class="post-header__flag">
      <figure class="post-portrait">
        <?php echo $author_image; ?>
      </figure>
      <div class="post-header__body">
        <h2 class="post__title"><?php echo $title; ?></h2>
        <div class="post__meta">
        <p class="post__byline">By <?php echo $author_link; ?> on <time class="post__date"><?php echo $date; ?></time></p>
        <?php if (count($tags)) { ?><p class="post__tags">Tagged with <?php echo $tags; ?></p><?php } ?>
        </div>
      </div>
    </div>
  </header>
  <div class="post__content">
    <div class="post-body<?php if (!$full_size) { ?> regular<?php } ?>">
      <?php if (!$full_size) { ?>
        <?php if (!$image_hide) { ?>
      <div class="post__cover--regular">
        <a class="fancybox colorbox-load" href="<?php echo $image_large; ?>"><?php echo $image_regular; ?></a>
      </div>
      <?php } ?>
      <?php } ?>
      <?php echo $content['sharethis']['#value']; ?>
      <?php echo $body; ?>
      <?php
      $block = block_load('views', 'portfolio_carousel-block_1');
      $output = drupal_render(_block_get_renderable_array(_block_render_blocks(array($block))));
      echo $output;
      ?>
    </div>
  </div>
</article>

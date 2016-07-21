<?php
function tags_link($value) {
  return l($value->name, drupal_get_path_alias('taxonomy/term/' . $value->tid));
};

$wrapper = entity_metadata_wrapper('node', $node);
$title = $wrapper->title->value();
$event_type = $wrapper->field_event_type->value();
$body = $wrapper->body->value->value();
$address = $wrapper->field_address->value();
$event_date = $wrapper->field_date->value();
$location = $wrapper->field_venue->value();

$email = $location->field_email['und'][0];
$phone = $location->field_phone['und'][0];
$website = $location->field_link['und'][0];
$venue = $location->field_location_address['und'][0];


$dates = [];
foreach($event_date as $event_date_item) {
  $date = '<p class="event__date">' . date('l, j F Y', strtotime($event_date_item['value']));
  if ($event_date_item['value2'] && ($event_date_item['value'] != $event_date_item['value2'])) {
    $date .= ' to ' . date('l, j F Y', strtotime($event_date_item['value2']));
  }
  $dates[] = $date . '</p>';
}

$tags = $wrapper->field_tags->value();
$external_link = $wrapper->field_link->value();
$full_size = $wrapper->field_image_full->value();
$image_height = $wrapper->field_image_height->value();
$image_hide = $wrapper->field_image_hide->value();

if (count($tags)) {
  $tags = implode(', ', array_map('tags_link', $tags));
}

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

<article class="post post--full post--event">
  <?php if ($full_size) { ?>
  <div class="post__cover <?php echo $image_height; ?>" style="background-image:url('<?php echo $image_full; ?>');" data-center="background-position: 50% -200px" data-top-bottom="background-position: 50% 0">
    <a class="post__fancybox fancybox" href="<?php echo $image_large; ?>"><span>View large</span></a>
  </div>
  <?php } ?>
  <header class="post-header">
    <div class="post-header__flag">
      <figure class="post-portrait">
        <?php echo $author_image; ?>
      </figure>
      <div class="post-header__body">
        <h2 class="post__title"><?php echo $title; ?></h2>
        <p class="post__type"><?php echo $event_type->name; ?></p>
        <?php if (count($tags)) { ?><p class="post__tags">Tagged with <?php echo $tags; ?></p><?php } ?>
      </div>
    </div>
  </header>
  <div class="post__content">
    <div class="post-body<?php if (!$full_size) { ?> regular<?php } ?>">
      <?php if (!$full_size) { ?>
        <?php if (!$image_hide) { ?>
          <div class="post__cover--regular">
            <a class="fancybox" href="<?php echo $image_large; ?>"><?php echo $image_regular; ?></a>
          </div>
        <?php } ?>
      <?php } ?>
      <?php echo $content['sharethis']['#value']; ?>
      <?php echo $body; ?>
      <?php 
        if($dates) { 
          echo implode('', $dates);
        }
      ?>
      <?php if ($location) { ?>
      <?php if ($venue) { ?>
      <address>
        <p>
        <?php echo $venue['organisation_name']; ?><br>
        <?php echo $venue['thoroughfare']; ?><br>
        <?php echo $venue['locality']; ?><br>
        <?php echo $venue['administrative_area']; ?><br>
        <?php echo $venue['postal_code']; ?>
        </p>
      </address>
      <?php } ?>
      <p class="event-location__email"><?php echo l('Email', 'mailto:' . $email['email']); ?></p>
      <p class="event-location__phone"><?php echo l($phone['value'], 'tel:' . $phone['value']); ?></p>
      <p class="event-location__website"><?php echo l('Website', $website['url'], array('external' => TRUE)); ?></p>
      <?php } ?>
      <?php if ($external_link) { ?>
        <?php echo l('Further information', $external_link['display_url'], array('external' => true)); ?>
      <?php } ?>
    </div>
  </div>
</article>

<?php
/**
 * @file
 * Entity-related functions.
 */

/**
 * Implements hook_preprocess_entity().
 */
function largeformat_preprocess_entity(&$vars) {
  $only_use_smacss = theme_get_setting('only_use_smacss');
  $type_class = drupal_html_class($vars['elements']['#entity_type']);
  $bundle_class = drupal_html_class($vars['elements']['#bundle']);
  $view_mode_class = drupal_html_class($vars['elements']['#view_mode']);

  // Remove some default entity classes.
  if ($only_use_smacss) {
    $vars['classes_array'] = array_values(array_diff($vars['classes_array'], array(
      'entity',
      'entity-' . $type_class,
      $type_class . '-' . $bundle_class,
    )));
  }
  if ($vars['entity_type'] == 'bean') {
    $bean = $vars['bean'];
    $wrapper = entity_metadata_wrapper('bean', $bean);
    $css_classes = array_map('trim', explode(' ', $wrapper->field_css_class->value()));
    if (isset($bean->uuid)) {
      $uuid = str_replace('-', '', $bean->uuid);
      $vars['theme_hook_suggestions'][] = $vars['entity_type'] . '__' . substr($uuid, 0, 20);
    }
  }

  // Add default entity attributes.
  $vars['classes_array'][] = $type_class;
  $vars['classes_array'][] = $type_class . '--' . $bundle_class;
  $vars['classes_array'][] = $type_class . '--' . $view_mode_class;
  $vars['classes_array'][] = implode(' ', $css_classes);
  $vars['title_attributes_array']['class'][] = $type_class . '__title';
  $vars['content_attributes_array']['class'][] = $type_class . '__content';

}

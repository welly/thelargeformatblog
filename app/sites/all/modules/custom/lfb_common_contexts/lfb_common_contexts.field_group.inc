<?php
/**
 * @file
 * lfb_common_contexts.field_group.inc
 */

/**
 * Implements hook_field_group_info().
 */
function lfb_common_contexts_field_group_info() {
  $export = array();

  $field_group = new stdClass();
  $field_group->disabled = FALSE; /* Edit this to true to make a default field_group disabled initially */
  $field_group->api_version = 1;
  $field_group->identifier = 'group_facebook|node|article|form';
  $field_group->group_name = 'group_facebook';
  $field_group->entity_type = 'node';
  $field_group->bundle = 'article';
  $field_group->mode = 'form';
  $field_group->parent_name = '';
  $field_group->data = array(
    'label' => 'Facebook',
    'weight' => '11',
    'children' => array(
      0 => 'field_facebook_message',
      1 => 'field_facebook_published',
    ),
    'format_type' => 'tab',
    'format_settings' => array(
      'formatter' => 'closed',
      'instance_settings' => array(
        'description' => '',
        'classes' => 'group-facebook field-group-tab',
        'required_fields' => 1,
      ),
    ),
  );
  $export['group_facebook|node|article|form'] = $field_group;

  return $export;
}

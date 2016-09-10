<?php
/**
 * @file
 * lfb_common_contexts.features.field_base.inc
 */

/**
 * Implements hook_field_default_field_bases().
 */
function lfb_common_contexts_field_default_field_bases() {
  $field_bases = array();

  // Exported field_base: 'field_venue'
  $field_bases['field_venue'] = array(
    'active' => 1,
    'cardinality' => 1,
    'deleted' => 0,
    'entity_types' => array(),
    'field_name' => 'field_venue',
    'foreign keys' => array(
      'eck_location' => array(
        'columns' => array(
          'target_id' => 'id',
        ),
        'table' => 'eck_location',
      ),
    ),
    'indexes' => array(
      'target_id' => array(
        0 => 'target_id',
      ),
    ),
    'locked' => 0,
    'module' => 'entityreference',
    'settings' => array(
      'handler' => 'views',
      'handler_settings' => array(
        'behaviors' => array(
          'views-select-list' => array(
            'status' => 0,
          ),
        ),
        'view' => array(
          'args' => array(),
          'display_name' => 'entityreference_1',
          'view_name' => 'locations',
        ),
      ),
      'target_type' => 'location',
    ),
    'translatable' => 0,
    'type' => 'entityreference',
  );

  return $field_bases;
}

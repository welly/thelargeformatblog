<?php
/**
 * @file
 * Field collection-related functions.
 */

/**
 * Returns HTML for field collection items.
 */
function largeformat_field_collection_view($vars) {
  // Don't output wrapper markup.
  return $vars['element']['#children'];
}
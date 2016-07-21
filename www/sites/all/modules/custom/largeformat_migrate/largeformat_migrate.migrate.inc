<?php

/**
 * Impelements hook_migrate_api().
 */
function largeformat_migrate_migrate_api() {
  $api = array(
    'api' => 2,
    'groups' => array(
      'wordpress' => array(
        'title' => t('Wordpress Import'),
      ),
    ),
    'migrations' => array(
      'Article' => array(
        'class_name' => 'ArticleMigration',
        'group_name' => 'wordpress',
        'dependencies' => array(
          'Category',
          'Tag',
        ),
      ),
      'Category' => array(
        'class_name' => 'CategoryMigration',
        'group_name' => 'wordpress',
      ),
      'Tag' => array(
        'class_name' => 'TagMigration',
        'group_name' => 'wordpress',
      ),
      'User' => array(
        'class_name' => 'UserMigration',
        'group_name' => 'wordpress',
      ),
    ),
  );

  return $api;
}

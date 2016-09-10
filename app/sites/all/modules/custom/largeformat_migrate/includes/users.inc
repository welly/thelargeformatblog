<?php
/**
 * @file
 * Migration for player data.
 */

class UserMigration extends BaseMigration {

  public function __construct($arguments) {

    parent::__construct($arguments);

    $this->description = t('Import term data from legacy database.');

    $query = $this->getConnection()->select('wp_users', 'u');
    $query->fields('u', array('ID', 'user_login', 'user_nicename', 'user_email'));

    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationUser();

    $this->map = new MigrateSQLMap(
      $this->machineName,
      array(
        'ID' => array(
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'Member ID',
          'alias' => 'u',
        ),
      ),
      MigrateDestinationUser::getKeySchema()
    );

    $this->addFieldMapping('name', 'user_nicename');
    $this->addFieldMapping('mail', 'user_email');
    $this->addFieldMapping('roles')
      ->defaultValue(DRUPAL_AUTHENTICATED_RID);
  }
}

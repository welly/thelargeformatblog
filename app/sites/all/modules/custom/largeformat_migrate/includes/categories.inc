<?php
/**
 * @file
 * Migration for source (original language) data.
 */

class CategoryMigration extends BaseMigration {

  public function __construct($arguments) {

    parent::__construct($arguments);

    $this->description = t('Import category data from legacy database.');

    $query = $this->getConnection()->select('wp_terms', 't');
    $query->fields('t', array('term_id', 'name'));
    $query->join('wp_term_taxonomy', 'tt', 'tt.term_id = t.term_id');
    $query->condition('tt.taxonomy', 'category', '=');
    $query->orderBy('t.name', 'ASC');

    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationTerm('category');

    $this->map = new MigrateSQLMap(
      $this->machineName, array(
        'term_id' => array(
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'Term ID',
          'alias' => 't',
        ),
      ),
      MigrateDestinationTerm::getKeySchema()
    );

    $this->addFieldMapping('name', 'name');
    $this->addFieldMapping('format')
      ->defaultValue('full_html');

    $this->addUnmigratedDestinations(
      array(
        'description', 'parent', 'parent_name', 'weight', 'path'
      )
    );
  }

  // function prepareRow($row) {
  //   $row->post_date = strtotime($row->post_date);
  //   $row->post_modified = strtotime($row->post_modified);
  // }

  // function prepare(&$node, $row) {
  //   if (isset($node->tnid) && ($source = node_load($node->tnid))) {
  //     $node->translation_source = $source;
  //   }
  // }
}


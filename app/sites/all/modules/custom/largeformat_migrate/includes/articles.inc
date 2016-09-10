<?php
/**
 * @file
 * Migration for source (original language) data.
 */

class ArticleMigration extends BaseMigration {

  public function __construct($arguments) {

    parent::__construct($arguments);

    $this->description = t('Import blog data from legacy database.');

    $query = $this->getConnection()->select('wp_posts', 'p');
    $query->fields('p', array('ID', 'post_title', 'post_content', 'post_date', 'post_modified', 'post_name'));
    $query->fields('p2', array('guid'));

    $query->addExpression('GROUP_CONCAT(DISTINCT(t1.term_id))', 'cat_ids');
    $query->addExpression('GROUP_CONCAT(DISTINCT(t2.term_id))', 'tag_ids');

    $query->leftJoin('wp_term_relationships', 'tr1', 'tr1.object_id = p.ID');
    $query->leftJoin('wp_term_taxonomy', 'tt1', "tt1.term_taxonomy_id = tr1.term_taxonomy_id AND tt1.taxonomy = 'category'");
    $query->leftJoin('wp_terms', 't1', 't1.term_id = tt1.term_id');

    $query->leftJoin('wp_term_relationships', 'tr2', 'tr2.object_id = p.ID');
    $query->leftJoin('wp_term_taxonomy', 'tt2', "tt2.term_taxonomy_id = tr2.term_taxonomy_id AND tt2.taxonomy = 'post_tag'");
    $query->leftJoin('wp_terms', 't2', 't2.term_id = tt2.term_id');

    $query->leftJoin('wp_posts', 'p2', "p2.post_parent = p.ID AND p2.post_type = 'attachment'");
    // $query->leftJoin('wp_postmeta', 'pm', "pm.post_id = p2.ID AND pm.meta_key = '_wp_attached_file'");

    $query->condition('p.post_status', 'publish', '=');
    $query->condition('p.post_title', '', '<>');
    $query->condition('p.post_type', 'post', '=');
    $query->orderBy('p.ID', 'desc');
    $query->groupBy('p.ID');

    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('article');

    $this->map = new MigrateSQLMap(
      $this->machineName, array(
        'ID' => array(
          'type' => 'int',
          'not null' => TRUE,
          'description' => 'Post ID',
          'alias' => 'p',
        ),
      ),
      MigrateDestinationNode::getKeySchema()
    );

    $this->addFieldMapping('title', 'post_title');
    $this->addFieldMapping('body', 'post_content');
    $this->addFieldMapping('body:format')
      ->defaultValue('full_html');
    $this->addFieldMapping('created', 'post_date');
    $this->addFieldMapping('changed', 'post_modified');
    $this->addFieldMapping('status')
      ->defaultValue('1');
    $this->addFieldMapping('uid')
      ->defaultValue('1');

    $this->addFieldMapping('field_author')
      ->defaultValue('5');

    $this->addFieldMapping('field_image', 'guid');
    $this->addFieldMapping('field_image:file_class')
      ->defaultValue('MigrateFileUri');

    $this->addFieldMapping('field_categories', 'cat_ids')
      ->sourceMigration('Category')
      ->separator(',');
    $this->addFieldMapping('field_categories:source_type')
      ->defaultValue('tid');

    $this->addFieldMapping('field_tags', 'tag_ids')
      ->sourceMigration('Tag')
      ->separator(',');
    $this->addFieldMapping('field_tags:source_type')
      ->defaultValue('tid');

    $this->addFieldMapping('pathauto')->defaultValue(0);
    $this->addFieldMapping('path', 'url');

    $this->addUnmigratedDestinations(
      array(
        'promote', 'sticky', 'revision', 'log', 'language', 'tnid',
        'translate', 'revision_uid', 'is_new'
      )
    );

  }

  function prepareRow($row) {
    if (parent::prepareRow($row) === FALSE) {
      return FALSE;
    }
    $date = $row->post_date;
    $date = strtotime($date);
    $url = $row->post_name;
    $url = date('Y', $date) . '/' . date('m', $date) . '/' . date('d', $date) . '/' . $url;
    $row->url = $url;
  }

  function prepare(&$row) {
    $row->path['pathauto'] = 0;
  }

  // function prepare(&$node, $row) {
  //   if (isset($node->tnid) && ($source = node_load($node->tnid))) {
  //     $node->translation_source = $source;
  //   }
  // }
}


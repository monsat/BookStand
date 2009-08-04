<?php 
/* SVN FILE: $Id$ */
/* BookStand schema generated on: 2009-06-16 17:06:53 : 1245142613*/
class BookStandSchema extends CakeSchema {
	var $name = 'BookStand';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $book_stand_article_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false),
		'note' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'point' => array('type' => 'integer', 'null' => false, 'default' => '10', 'length' => 10),
		'book_stand_article_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_articles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'book_stand_book_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'title' => array('type' => 'string', 'null' => false),
		'slug' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'mbslug' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'posted' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'book_stand_author_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'book_stand_category_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'book_stand_comment_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'book_stand_revision_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'book_stand_revision_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'book_stand_tag_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'draft' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'reserved' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'begin_publishing' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'end_publishing' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_time' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_articles_book_stand_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'book_stand_article_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'book_stand_tag_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_authors = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false),
		'note' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'book_stand_article_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_time' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false),
		'book_stand_article_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'book_stand_article_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'title' => array('type' => 'string', 'null' => false),
		'author' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'author_url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'author_ip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'posted' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'spam' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'book_stand_comment_status_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_time' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_relations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'book_stand_article_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'book_stand_related_article_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_revisions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'book_stand_article_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $book_stand_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false),
		'note' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'book_stand_article_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
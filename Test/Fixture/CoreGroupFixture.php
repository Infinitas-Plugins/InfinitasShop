<?php
/**
 * CoreGroupFixture
 *
 */
class CoreGroupFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'lft' => array('type' => 'integer', 'null' => false, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'admin',
			'name' => 'admin',
			'description' => 'admin',
			'created' => '2012-10-08 19:40:16',
			'modified' => '2012-10-08 19:40:16',
			'parent_id' => null,
			'lft' => 1,
			'rght' => 2
		),
		array(
			'id' => 'user',
			'name' => 'user',
			'description' => 'user',
			'created' => '2012-10-08 19:40:16',
			'modified' => '2012-10-08 19:40:16',
			'parent_id' => null,
			'lft' => 3,
			'rght' => 4
		),
		array(
			'id' => 'reseller',
			'name' => 'reseller',
			'description' => 'reseller',
			'created' => '2012-10-08 19:40:16',
			'modified' => '2012-10-08 19:40:16',
			'parent_id' => null,
			'lft' => 5,
			'rght' => 6
		),
	);

}

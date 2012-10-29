<?php
/**
 * ContactBranchFixture
 *
 */
class ShopContactBranchFixture extends CakeTestFixture {
/**
 * @brief table to use
 *
 * @var string
 */
	public $table = 'contact_branches';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'map' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_count' => array('type' => 'integer', 'null' => false, 'default' => null),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'ordering' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'time_zone_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'model' => array('column' => array('model', 'ordering'), 'unique' => 0),
			'ordering' => array('column' => 'ordering', 'unique' => 0)
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
			'id' => 'contact-branch-1',
			'name' => 'contact-branch-1',
			'slug' => 'contact-branch-1',
			'map' => 'map',
			'image' => 'img.png',
			'email' => 'email@email.com',
			'phone' => '555-5555',
			'fax' => '555-5556',
			'address_id' => 'contact-address-id',
			'user_count' => 1,
			'active' => 1,
			'ordering' => 1,
			'time_zone_id' => 1,
			'model' => 'Shop.ShopBranch',
			'foreign_key' => 'branch-1',
			'created' => '2012-10-05 15:12:17',
			'modified' => '2012-10-05 15:12:17'
		),
		array(
			'id' => 'contact-branch-2',
			'name' => 'contact-branch-2',
			'slug' => 'contact-branch-2',
			'map' => 'map',
			'image' => 'img.png',
			'email' => 'email@email.com',
			'phone' => '555-5555',
			'fax' => '555-5556',
			'address_id' => 'contact-address-id',
			'user_count' => 1,
			'active' => 1,
			'ordering' => 1,
			'time_zone_id' => 1,
			'model' => 'Shop.ShopBranch',
			'foreign_key' => 'branch-2',
			'created' => '2012-10-05 15:12:17',
			'modified' => '2012-10-05 15:12:17'
		),
	);

}

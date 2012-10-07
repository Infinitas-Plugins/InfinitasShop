<?php
/**
 * ShopProductTypeFixture
 *
 */
class ShopProductTypeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'general',
			'name' => 'general',
			'slug' => 'general',
			'created' => '2012-10-06 23:30:18',
			'modified' => '2012-10-06 23:30:18'
		),
		array(
			'id' => 'shirts',
			'name' => 'shirts',
			'slug' => 'shirts',
			'created' => '2012-10-06 23:30:18',
			'modified' => '2012-10-06 23:30:18'
		),
		array(
			'id' => 'shoes',
			'name' => 'shoes',
			'slug' => 'shoes',
			'created' => '2012-10-06 23:30:18',
			'modified' => '2012-10-06 23:30:18'
		),
		array(
			'id' => 'complex-options',
			'name' => 'complex-options',
			'slug' => 'complex-options',
			'created' => '2012-10-06 23:30:18',
			'modified' => '2012-10-06 23:30:18'
		),
	);

}

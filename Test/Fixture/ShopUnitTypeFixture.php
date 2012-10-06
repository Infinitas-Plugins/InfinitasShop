<?php
/**
 * ShopUnitTypeFixture
 *
 */
class ShopUnitTypeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'symbol' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_unit_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'id' => 'dimentions',
			'name' => 'dimentions',
			'symbol' => 'mm',
			'shop_unit_count' => 1,
			'created' => '2012-10-06 01:01:47',
			'modified' => '2012-10-06 01:01:47'
		),
		array(
			'id' => 'mass',
			'name' => 'mass',
			'symbol' => 'g',
			'shop_unit_count' => 1,
			'created' => '2012-10-06 01:01:47',
			'modified' => '2012-10-06 01:01:47'
		),
	);

}

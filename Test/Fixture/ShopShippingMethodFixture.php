<?php
/**
 * ShopShippingMethodFixture
 *
 */
class ShopShippingMethodFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'insurance' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'rates' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'total_minimum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'total_maximum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'require_login' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'id' => 'royal-mail-1st',
			'name' => 'royal-mail-1st',
			'active' => 1,
			'insurance' => '',
			'rates' => '',
			'total_minimum' => 0,
			'total_maximum' => 150,
			'require_login' => 0,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
		array(
			'id' => 'royal-mail-2nd',
			'name' => 'royal-mail-2nd',
			'active' => 1,
			'insurance' => '',
			'rates' => '',
			'total_minimum' => 0,
			'total_maximum' => 150,
			'require_login' => 0,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
		array(
			'id' => 'inactive',
			'name' => 'inactive',
			'active' => 0,
			'insurance' => '',
			'rates' => '',
			'total_minimum' => 0,
			'total_maximum' => 150,
			'require_login' => 0,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
	);

}

<?php
/**
 * ShopPaymentMethodFixture
 *
 */
class ShopPaymentMethodFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 5),
		'debug' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'total_minimum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'total_maximum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'require_login' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'processing_fee' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
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
			'id' => 'paypal',
			'name' => 'paypal',
			'active' => 1,
			'ordering' => 1,
			'debug' => 0,
			'total_minimum' => 500,
			'total_maximum' => 600,
			'require_login' => 0,
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57',
			'processing_fee' => 1
		),
		array(
			'id' => 'cc',
			'name' => 'cc',
			'active' => 1,
			'ordering' => 1,
			'debug' => 0,
			'total_minimum' => null,
			'total_maximum' => null,
			'require_login' => 1,
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57',
			'processing_fee' => 25
		),
		array(
			'id' => 'inactive',
			'name' => 'inactive',
			'active' => 0,
			'ordering' => 2,
			'debug' => 0,
			'total_minimum' => null,
			'total_maximum' => null,
			'require_login' => 0,
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57',
			'processing_fee' => 1
		),
	);

}

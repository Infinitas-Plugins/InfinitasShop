<?php
/**
 * ShopPaymentMethodFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopPaymentMethodFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 5),
		'total_minimum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'total_maximum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'require_login' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'infinitas_payment_method_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'id' => 'paypal',
			'name' => 'paypal',
			'active' => 1,
			'ordering' => 1,
			'total_minimum' => 500,
			'total_maximum' => 600,
			'require_login' => 0,
			'infinitas_payment_method_id' => 'paypal',
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57'
		),
		array(
			'id' => 'cc',
			'name' => 'cc',
			'active' => 1,
			'ordering' => 2,
			'total_minimum' => null,
			'total_maximum' => null,
			'require_login' => 0,
			'infinitas_payment_method_id' => 'paypal',
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57'
		),
		array(
			'id' => 'inactive',
			'name' => 'inactive',
			'active' => 0,
			'ordering' => 3,
			'total_minimum' => null,
			'total_maximum' => null,
			'require_login' => 0,
			'infinitas_payment_method_id' => 'paypal',
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57'
		),
		array(
			'id' => 'login',
			'name' => 'login',
			'active' => 1,
			'ordering' => 4,
			'total_minimum' => null,
			'total_maximum' => 100,
			'require_login' => 1,
			'infinitas_payment_method_id' => 'paypal',
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57'
		),
		array(
			'id' => 'parent-disabled',
			'name' => 'parent-disabled',
			'active' => 1,
			'ordering' => 5,
			'total_minimum' => null,
			'total_maximum' => null,
			'require_login' => 0,
			'infinitas_payment_method_id' => 'inactive',
			'created' => '2012-10-08 21:08:57',
			'modified' => '2012-10-08 21:08:57'
		),
	);

}

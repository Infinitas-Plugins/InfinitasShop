<?php
/**
 * ShopOrderFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopOrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'invoice_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_billing_address_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_shipping_address_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_payment_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_shipping_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tracking_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_order_status_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_orders_order_statuses1_idx' => array('column' => 'shop_order_status_id', 'unique' => 0),
			'fk_shop_orders_shop_user_addresses1_idx' => array('column' => 'shop_billing_address_id', 'unique' => 0),
			'fk_shop_orders_shop_user_addresses2_idx' => array('column' => 'shop_shipping_address_id', 'unique' => 0),
			'fk_shop_orders_shop_payment_methods1_idx' => array('column' => 'shop_payment_method_id', 'unique' => 0),
			'fk_shop_orders_shop_shipping_methods1_idx' => array('column' => 'shop_shipping_method_id', 'unique' => 0)
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
			'id' => '50736c66-3c30-414b-87b6-242d6318cd70',
			'invoice_number' => 'Lorem ipsum dolor sit amet',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'shop_billing_address_id' => 'Lorem ipsum dolor sit amet',
			'shop_shipping_address_id' => 'Lorem ipsum dolor sit amet',
			'shop_payment_method_id' => 'Lorem ipsum dolor sit amet',
			'shop_shipping_method_id' => 'Lorem ipsum dolor sit amet',
			'tracking_number' => 'Lorem ipsum dolor sit amet',
			'shop_order_status_id' => 'Lorem ipsum dolor sit amet',
			'ip_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-09 01:14:30',
			'modified' => '2012-10-09 01:14:30'
		),
	);

}

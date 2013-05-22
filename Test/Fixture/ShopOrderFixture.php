<?php
/**
 * @brief fixture file for ShopOrder tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopOrderFixture extends CakeTestFixture {
	public $name = 'ShopOrder';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'invoice_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'unique'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'assigned_user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'total' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6'),
		'tax' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6'),
		'shipping' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6'),
		'insurance' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6'),
		'handling' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6'),
		'shop_billing_address_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_shipping_address_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_payment_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_shipping_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tracking_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'infinitas_payment_log_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_order_status_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip_address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_order_product_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'invoice_number' => array('column' => 'invoice_number', 'unique' => 1, 'auto_increment' => 1),
			'fk_shop_orders_order_statuses1_idx' => array('column' => 'shop_order_status_id', 'unique' => 0),
			'fk_shop_orders_shop_user_addresses1_idx' => array('column' => 'shop_billing_address_id', 'unique' => 0),
			'fk_shop_orders_shop_user_addresses2_idx' => array('column' => 'shop_shipping_address_id', 'unique' => 0),
			'fk_shop_orders_shop_payment_methods1_idx' => array('column' => 'shop_payment_method_id', 'unique' => 0),
			'fk_shop_orders_shop_shipping_methods1_idx' => array('column' => 'shop_shipping_method_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'order-1',
			'invoice_number' => 1,
			'user_id' => 'bob',
			'assigned_user_id' => 'admin',
			'total' => 72,
			'tax' => 0,
			'shipping' => 2.5,
			'insurance' => 1,
			'handling' => 10,
			'shop_billing_address_id' => null,
			'shop_shipping_address_id' => null,
			'shop_payment_method_id' => null,
			'shop_shipping_method_id' => null,
			'tracking_number' => null,
			'infinitas_payment_log_id' => 'payment-1',
			'shop_order_status_id' => 'pending',
			'ip_address' => '127.0.0.1',
			'shop_order_product_count' => 2,
			'created' => '2013-01-08 15:22:12',
			'modified' => '2013-01-08 15:22:12'
		),
		array(
			'id' => 'order-2',
			'invoice_number' => 2,
			'user_id' => 'sally',
			'assigned_user_id' => null,
			'total' => 72,
			'tax' => 0,
			'shipping' => 2.5,
			'insurance' => 1,
			'handling' => 10,
			'shop_billing_address_id' => null,
			'shop_shipping_address_id' => null,
			'shop_payment_method_id' => null,
			'shop_shipping_method_id' => null,
			'tracking_number' => null,
			'infinitas_payment_log_id' => 'payment-2',
			'shop_order_status_id' => 'pending',
			'ip_address' => '127.0.0.1',
			'shop_order_product_count' => 1,
			'created' => '2013-01-08 15:22:12',
			'modified' => '2013-01-08 15:22:12'
		),
	);
}
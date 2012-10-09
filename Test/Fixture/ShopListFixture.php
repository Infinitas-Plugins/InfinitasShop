<?php
/**
 * ShopListFixture
 *
 */
class ShopListFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_shipping_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_payment_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_lists_shop_payment_methods1_idx' => array('column' => 'shop_payment_method_id', 'unique' => 0),
			'fk_shop_lists_shop_shipping_methods1_idx' => array('column' => 'shop_shipping_method_id', 'unique' => 0)
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
			'id' => 'shop-list-bob-cart',
			'name' => 'shop-list-bob-cart',
			'user_id' => 'bob',
			'shop_shipping_method_id' => 'royal-mail-1st',
			'shop_payment_method_id' => 'paypal',
			'created' => '2012-11-08 20:53:06',
			'modified' => '2012-11-08 20:53:06'
		),
		array(
			'id' => 'shop-list-bob-wish',
			'name' => 'shop-list-bob-wish',
			'user_id' => 'bob',
			'shop_shipping_method_id' => 'inactive',
			'shop_payment_method_id' => 'inactive',
			'created' => '2012-10-08 20:53:06',
			'modified' => '2012-10-08 20:53:06'
		),
		array(
			'id' => 'shop-list-sally-cart',
			'name' => 'shop-list-sally-cart',
			'user_id' => 'sally',
			'shop_shipping_method_id' => 'royal-mail-2nd',
			'shop_payment_method_id' => 'cc',
			'created' => '2012-10-08 20:53:06',
			'modified' => '2012-10-08 20:53:06'
		),
		array(
			'id' => 'shop-list-guest-1-cart',
			'name' => 'shop-list-guest-1-cart',
			'user_id' => 'guest-1',
			'shop_shipping_method_id' => null,
			'shop_payment_method_id' => 'cc',
			'created' => '2012-10-08 20:53:06',
			'modified' => '2012-10-08 20:53:06'
		),
	);

}

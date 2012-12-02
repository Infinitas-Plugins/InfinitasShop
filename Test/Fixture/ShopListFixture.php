<?php
/**
 * ShopListFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopListFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_shipping_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_payment_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_lists_shop_payment_methods1_idx' => array('column' => 'shop_payment_method_id', 'unique' => 0),
			'fk_shop_lists_shop_shipping_methods1_idx' => array('column' => 'shop_shipping_method_id', 'unique' => 0)
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

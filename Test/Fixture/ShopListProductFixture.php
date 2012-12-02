<?php
/**
 * ShopListProductFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopListProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'shop_list_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quantity' => array('type' => 'float', 'null' => false, 'default' => '1.00000', 'length' => '15,5'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_wishlists_shop_products1_idx' => array('column' => 'shop_product_id', 'unique' => 0),
			'fk_shop_lists_shop_lists_users1_idx' => array('column' => 'shop_list_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'shop-list-bob-cart-active',
			'shop_list_id' => 'shop-list-bob-cart',
			'shop_product_id' => 'active',
			'quantity' => 1,
			'created' => '2012-10-09 01:32:27',
			'modified' => '2012-10-09 01:32:27'
		),
		array(
			'id' => 'shop-list-bob-cart-multi-option',
			'shop_list_id' => 'shop-list-bob-cart',
			'shop_product_id' => 'multi-option',
			'quantity' => 1,
			'created' => '2012-10-09 01:32:27',
			'modified' => '2012-10-09 01:32:27'
		),
		array(
			'id' => 'shop-list-sally',
			'shop_list_id' => 'shop-list-sally-cart',
			'shop_product_id' => 'multi-option',
			'quantity' => 10,
			'created' => '2012-10-09 01:32:27',
			'modified' => '2012-10-09 01:32:27'
		),
		array(
			'id' => 'shop-list-guest-1',
			'shop_list_id' => 'shop-list-guest-1-cart',
			'shop_product_id' => 'multi-category',
			'quantity' => 3,
			'created' => '2012-10-09 01:32:27',
			'modified' => '2012-10-09 01:32:27'
		),
	);

}
<?php
/**
 * ShopListProductOptionFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopListProductOptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_list_product_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_list_product_options_shop_lists1_idx' => array('column' => 'shop_list_product_id', 'unique' => 0),
			'fk_shop_list_product_options_shop_options1_idx' => array('column' => 'shop_option_id', 'unique' => 0),
			'fk_shop_list_product_options_shop_option_values1_idx' => array('column' => 'shop_option_value_id', 'unique' => 0)
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
			'id' => 'bob-cart-option-size-large',
			'shop_list_product_id' => 'shop-list-bob-cart-active',
			'shop_option_id' => 'option-size',
			'shop_option_value_id' => 'option-size-large',
			'created' => '2012-10-08 21:09:40'
		),
		array(
			'id' => 'sally-cart-option-size-medium',
			'shop_list_product_id' => 'shop-list-sally-cart',
			'shop_option_id' => 'option-size',
			'shop_option_value_id' => 'option-size-medium',
			'created' => '2012-10-08 21:09:40'
		),
		array(
			'id' => 'sally-cart-option-colour-red',
			'shop_list_product_id' => 'shop-list-sally-cart',
			'shop_option_id' => 'option-colour',
			'shop_option_value_id' => 'option-colour-red',
			'created' => '2012-10-08 21:09:40'
		),
	);

}

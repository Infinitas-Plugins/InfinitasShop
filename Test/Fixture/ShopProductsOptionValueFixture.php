<?php
/**
 * ShopProductsOptionValueFixture
 *
 */
class ShopProductsOptionValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_options_value_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_products_options_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_price_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_option_values_products_shop_option_values1' => array('column' => 'shop_options_value_id', 'unique' => 0),
			'fk_shop_option_values_products_shop_options_products1' => array('column' => 'shop_products_options_id', 'unique' => 0),
			'fk_shop_products_option_values_shop_prices1' => array('column' => 'shop_price_id', 'unique' => 0)
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
			'id' => '506ea1fb-e214-445c-9a01-15e76318cd70',
			'shop_options_value_id' => 'Lorem ipsum dolor sit amet',
			'shop_products_options_id' => 'Lorem ipsum dolor sit amet',
			'shop_price_id' => 'Lorem ipsum dolor sit amet'
		),
	);

}

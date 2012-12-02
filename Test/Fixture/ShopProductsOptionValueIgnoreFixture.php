<?php
/**
 * ShopProductsOptionValueIgnoreFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopProductsOptionValueIgnoreFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_products_option_value_ignores_shop_products1' => array('column' => 'foreign_key', 'unique' => 0),
			'fk_shop_products_option_value_ignores_shop_option_values1' => array('column' => 'shop_option_value_id', 'unique' => 0)
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
			'id' => 'option-value-no-stock-added',
			'shop_option_value_id' => 'option-size-medium',
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'no-stock-added',
			'created' => '2012-10-07 00:00:20'
		),
	);

}

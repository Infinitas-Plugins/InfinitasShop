<?php
/**
 * ShopProductsSpecialFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopProductsSpecialFixture extends CakeTestFixture {

/**
 * Fields
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_special_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_products_specials_shop_specials1_idx' => array('column' => 'shop_special_id', 'unique' => 0),
			'fk_shop_products_specials_shop_products1_idx' => array('column' => 'shop_product_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'special-1',
			'shop_product_id' => 'multi-option',
			'shop_special_id' => 'special-multi-option',
		),
		array(
			'id' => 'special-2',
			'shop_product_id' => 'active',
			'shop_special_id' => 'special-active',
		),
		array(
			'id' => 'special-3',
			'shop_product_id' => 'active',
			'shop_special_id' => 'special-active-pending',
		),
		array(
			'id' => 'special-4',
			'shop_product_id' => 'active',
			'shop_special_id' => 'special-active-expired',
		)
	);
}
<?php
/**
 * @brief fixture file for ShopOptionVariant tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopOptionVariantFixture extends CakeTestFixture {
	public $name = 'ShopOptionVariant';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_variant_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_option_variants_shop_product_variants1_idx' => array('column' => 'shop_product_variant_id', 'unique' => 0),
			'fk_shop_option_variants_shop_option_values1_idx' => array('column' => 'shop_option_value_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => '50c7e2d5-c418-46bc-b579-79e26318cd70',
			'shop_product_variant_id' => 'Lorem ipsum dolor sit amet',
			'shop_option_value_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
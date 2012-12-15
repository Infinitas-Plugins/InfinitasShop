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
			'id' => 'variant-active-1a',
			'shop_product_variant_id' => 'variant-active-1',
			'shop_option_value_id' => 'option-size-small'
		),
		array(
			'id' => 'variant-active-1b',
			'shop_product_variant_id' => 'variant-active-2',
			'shop_option_value_id' => 'option-size-medium'
		),
		array(
			'id' => 'variant-active-1c',
			'shop_product_variant_id' => 'variant-active-3',
			'shop_option_value_id' => 'option-size-large'
		),
		array(
			'id' => 'variant-multi-option-1a',
			'shop_product_variant_id' => 'variant-multi-option-1',
			'shop_option_value_id' => 'option-size-large'
		),
		array(
			'id' => 'variant-multi-option-1b',
			'shop_product_variant_id' => 'variant-multi-option-1',
			'shop_option_value_id' => 'option-colour-red'
		),
		array(
			'id' => 'variant-multi-option-2a',
			'shop_product_variant_id' => 'variant-multi-option-2',
			'shop_option_value_id' => 'option-size-medium'
		),
		array(
			'id' => 'variant-multi-option-2b',
			'shop_product_variant_id' => 'variant-multi-option-2',
			'shop_option_value_id' => 'option-colour-red'
		),
		array(
			'id' => 'variant-multi-option-3a',
			'shop_product_variant_id' => 'variant-multi-option-3',
			'shop_option_value_id' => 'option-size-small'
		),
		array(
			'id' => 'variant-multi-option-3b',
			'shop_product_variant_id' => 'variant-multi-option-3',
			'shop_option_value_id' => 'option-colour-red'
		),
		array(
			'id' => 'variant-multi-option-4a',
			'shop_product_variant_id' => 'variant-multi-option-4',
			'shop_option_value_id' => 'option-size-small'
		),
		array(
			'id' => 'variant-multi-option-4b',
			'shop_product_variant_id' => 'variant-multi-option-4',
			'shop_option_value_id' => 'option-colour-blue'
		),
	);
}
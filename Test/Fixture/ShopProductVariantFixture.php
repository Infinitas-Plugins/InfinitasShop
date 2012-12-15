<?php
/**
 * @brief fixture file for ShopProductVariant tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopProductVariantFixture extends CakeTestFixture {

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'master' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_product_variants_shop_products1_idx' => array('column' => 'shop_product_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'variant-active-master',
			'shop_product_id' => 'active',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-active-1',
			'shop_product_id' => 'active',
			'master' => 0,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-active-2',
			'shop_product_id' => 'active',
			'master' => 0,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-active-3',
			'shop_product_id' => 'active',
			'master' => 0,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-out-of-stock-1',
			'shop_product_id' => 'out-of-stock',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-no-stock-added-master',
			'shop_product_id' => 'no-stock-added',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-category-master',
			'shop_product_id' => 'multi-category',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-category-mixed',
			'shop_product_id' => 'multi-category-mixed-state',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-parent-inactive',
			'shop_product_id' => 'multi-category-parent-inactive',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-option-master',
			'shop_product_id' => 'multi-option',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-option-1',
			'shop_product_id' => 'multi-option',
			'master' => 0,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-option-2',
			'shop_product_id' => 'multi-option',
			'master' => 0,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-option-3',
			'shop_product_id' => 'multi-option',
			'master' => 0,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
		array(
			'id' => 'variant-multi-option-4',
			'shop_product_id' => 'multi-option',
			'master' => 0,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
	);
}
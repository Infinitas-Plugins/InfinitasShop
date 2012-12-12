<?php
/**
 * @brief fixture file for ShopProductVariant tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopProductVariantFixture extends CakeTestFixture {
	public $name = 'ShopProductVariant';

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
			'id' => '50c7e1a1-b5cc-4df9-8cd0-78056318cd70',
			'shop_product_id' => 'Lorem ipsum dolor sit amet',
			'master' => 1,
			'created' => '2012-12-12 01:45:05',
			'modified' => '2012-12-12 01:45:05'
		),
	);
}
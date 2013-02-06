<?php
/**
 * @brief fixture file for ShopProductAttribute tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopProductAttributeFixture extends CakeTestFixture {
	public $name = 'ShopProductAttribute';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_attribute_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_product_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_product_attributes_shop_products1_idx' => array('column' => 'shop_product_id', 'unique' => 0),
			'fk_shop_product_attributes_shop_attributes1_idx' => array('column' => 'shop_attribute_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => '510adfb4-3ba4-4316-a0dc-1bb76318cd70',
			'shop_attribute_id' => 'Lorem ipsum dolor sit amet',
			'shop_product_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
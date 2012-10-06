<?php
/**
 * ShopProductSizeFixture
 *
 */
class ShopProductSizeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'charset' => 'utf8', 'collate' => 'utf8_general_ci'),
		'shop_product_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'charset' => 'utf8', 'collate' => 'utf8_general_ci'),
		'shop_unit_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'charset' => 'utf8', 'collate' => 'utf8_general_ci'),
		'value' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_product_sizes_shop_units1' => array('column' => 'shop_unit_id', 'unique' => 0),
			'fk_shop_product_sizes_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0)
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
			'id' => 'active-product-weight',
			'shop_product_id' => 'active',
			'shop_unit_id' => 'product-weight',
			'value' => 100
		),
		array(
			'id' => 'active-ship-weight',
			'shop_product_id' => 'active',
			'shop_unit_id' => 'ship-weight',
			'value' => 200
		),
		array(
			'id' => 'inactive-ship-weight',
			'shop_product_id' => 'inactive',
			'shop_unit_id' => 'ship-weight',
			'value' => 250
		),
	);

}

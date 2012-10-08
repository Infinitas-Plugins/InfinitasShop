<?php
/**
 * ShopSizeFixture
 *
 */
class ShopSizeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'foreign_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'product_width' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'product_height' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'product_length' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'shipping_width' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'shipping_height' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'shipping_length' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'product_weight' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'shipping_weight' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_sizes_shop_products1' => array('column' => 'foreign_key', 'unique' => 0)
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
			'id' => 'product-active',
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'active',
			'product_width' => 10.5,
			'product_height' => 10.5,
			'product_length' => 10.5,
			'shipping_width' => 12.5,
			'shipping_height' => 12.5,
			'shipping_length' => 12.5,
			'product_weight' => 500,
			'shipping_weight' => 650
		),
		array(
			'id' => 'option-value-size-large',
			'model' => 'Shop.ShopOptionValue',
			'foreign_key' => 'option-size-large',
			'product_width' => 1.5,
			'product_height' => 1.5,
			'product_length' => 1.5,
			'shipping_width' => 2.5,
			'shipping_height' => 2.5,
			'shipping_length' => 2.5,
			'product_weight' => 50,
			'shipping_weight' => 65
		),
	);

}

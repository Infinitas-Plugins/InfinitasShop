<?php
/**
 * ShopSizeFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopSizeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'relation' => array('column' => array('model', 'foreign_key'), 'unique' => 0)
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
			'id' => 'product-active',
			'model' => 'Shop.ShopProductVariant',
			'foreign_key' => 'variant-active-master',
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
			'id' => 'product-multi-category',
			'model' => 'Shop.ShopProductVariant',
			'foreign_key' => 'variant-multi-category-master',
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
		array(
			'id' => 'order-1a-size',
			'model' => 'Shop.ShopOrderProduct',
			'foreign_key' => 'order-1a',
			'product_width' => '10.50000',
			'product_height' => '10.50000',
			'product_length' => '10.50000',
			'shipping_width' => '12.50000',
			'shipping_height' => '12.50000',
			'shipping_length' => '12.50000',
			'product_weight' => '500.00000',
			'shipping_weight' => '650.00000',
		),
		array(
			'id' => 'order-1b-size',
			'model' => 'Shop.ShopOrderProduct',
			'foreign_key' => 'order-1b',
			'product_width' => '10.50000',
			'product_height' => '10.50000',
			'product_length' => '10.50000',
			'shipping_width' => '12.50000',
			'shipping_height' => '12.50000',
			'shipping_length' => '12.50000',
			'product_weight' => '500.00000',
			'shipping_weight' => '650.00000',
		),
	);

}

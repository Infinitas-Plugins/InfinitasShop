<?php
/**
 * @brief fixture file for ShopOrderProduct tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopOrderProductFixture extends CakeTestFixture {
	public $name = 'ShopOrderProduct';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_order_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_variant_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_type_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quantity' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'brand' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_image_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'product_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'time_to_purchase' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'view_to_purchase' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_order_products_shop_orders1_idx' => array('column' => 'shop_order_id', 'unique' => 0),
			'fk_shop_order_products_shop_products1_idx' => array('column' => 'shop_product_variant_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'order-1a',
			'shop_order_id' => 'order-1',
			'shop_product_variant_id' => 'variant-active-1',
			'shop_product_type_id' => 'shirts',
			'quantity' => 5,
			'name' => 'active',
			'brand' => 'inhouse',
			'shop_image_id' => 'image-product-active',
			'product_code' => '',
			'time_to_purchase' => 2500,
			'view_to_purchase' => 10
		),
		array(
			'id' => 'order-1b',
			'shop_order_id' => 'order-1',
			'shop_product_variant_id' => 'variant-active-2',
			'shop_product_type_id' => 'shirts',
			'quantity' => 1,
			'name' => 'active',
			'brand' => 'inhouse',
			'shop_image_id' => 'image-product-active',
			'product_code' => '',
			'time_to_purchase' => 1500,
			'view_to_purchase' => 25
		),
	);
}
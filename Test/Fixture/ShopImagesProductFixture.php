<?php
/**
 * ShopImagesProductFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopImagesProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'shop_image_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_images_products_shop_images' => array('column' => 'shop_image_id', 'unique' => 0),
			'fk_shop_images_products_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'image-join-1',
			'shop_image_id' => 'shared-image-1',
			'shop_product_id' => 'active'
		),
		array(
			'id' => 'image-join-2',
			'shop_image_id' => 'shared-image-2',
			'shop_product_id' => 'active'
		),
		array(
			'id' => 'image-join-3',
			'shop_image_id' => 'shared-image-2',
			'shop_product_id' => 'multi-category'
		),
	);

}

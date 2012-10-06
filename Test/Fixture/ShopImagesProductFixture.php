<?php
/**
 * ShopImagesProductFixture
 *
 */
class ShopImagesProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'shop_image_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'shop_product_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
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
			'id' => 1,
			'shop_image_id' => 1,
			'shop_product_id' => 1
		),
	);

}

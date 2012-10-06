<?php
/**
 * ShopSpotlightFixture
 *
 */
class ShopSpotlightFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'shop_product_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'shop_image_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'start_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'end_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'active' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_spotlights_shop_images1' => array('column' => 'shop_image_id', 'unique' => 0),
			'fk_shop_spotlights_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0)
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
			'id' => 1,
			'shop_product_id' => 1,
			'shop_image_id' => 1,
			'start_date' => '2012-10-06 12:10:38',
			'end_date' => '2012-10-06 12:10:38',
			'active' => 1,
			'created' => '2012-10-06 12:10:38',
			'modified' => '2012-10-06 12:10:38'
		),
	);

}

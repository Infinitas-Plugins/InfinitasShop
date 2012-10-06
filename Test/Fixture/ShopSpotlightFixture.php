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
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'shop_image_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index'),
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
			'id' => 'spotlight-multi-option',
			'shop_product_id' => 'multi-option',
			'shop_image_id' => 'image-spotlight-multi-option',
			'start_date' => '2012-09-06 00:00:00',
			'end_date' => '2050-10-06 23:59:59',
			'active' => 1,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
		array(
			'id' => 'spotlight-active',
			'shop_product_id' => 'active',
			'shop_image_id' => null,
			'start_date' => '2012-10-06 00:00:00',
			'end_date' => '2050-10-06 23:59:59',
			'active' => 0,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
		array(
			'id' => 'spotlight-active-pending',
			'shop_product_id' => 'active',
			'shop_image_id' => 'image-spotlight-active-pending',
			'start_date' => '2050-10-06 00:00:00',
			'end_date' => '2051-10-06 23:59:59',
			'active' => 1,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
		array(
			'id' => 'spotlight-active-expired',
			'shop_product_id' => 'active',
			'shop_image_id' => null,
			'start_date' => '2010-10-06 00:00:00',
			'end_date' => '2011-10-06 23:59:59',
			'active' => 1,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
	);

}

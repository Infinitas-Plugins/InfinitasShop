<?php
/**
 * ShopBrandFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopBrandFixture extends CakeTestFixture {

/**
 * fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'shop_product_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 9),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'inhouse',
			'name' => 'inhouse',
			'slug' => 'inhouse',
			'active' => 1,
			'shop_product_count' => 1,
			'created' => '2012-10-13 18:04:09',
			'modified' => '2012-10-13 18:04:09'
		),
		array(
			'id' => 'other',
			'name' => 'other',
			'slug' => 'other',
			'active' => 1,
			'shop_product_count' => 1,
			'created' => '2012-10-13 18:04:09',
			'modified' => '2012-10-13 18:04:09'
		),
	);
}
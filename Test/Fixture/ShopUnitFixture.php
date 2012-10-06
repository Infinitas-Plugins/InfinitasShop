<?php
/**
 * ShopUnitFixture
 *
 */
class ShopUnitFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'product_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'shop_unit_type_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_units_shop_unit_types1' => array('column' => 'shop_unit_type_id', 'unique' => 0)
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
			'id' => 'ship-weight',
			'name' => 'ship-weight',
			'slug' => 'ship-weight',
			'description' => 'Mass in grams of the product with packaging',
			'active' => 1,
			'product_count' => 1,
			'shop_unit_type_id' => 'mass',
			'created' => '2012-10-06 01:01:12',
			'modified' => '2012-10-06 01:01:12'
		),
		array(
			'id' => 'product-weight',
			'name' => 'product-weight',
			'slug' => 'product-weight',
			'description' => 'Mass in grams of the actual product',
			'active' => 1,
			'product_count' => 1,
			'shop_unit_type_id' => 'mass',
			'created' => '2012-10-06 01:01:12',
			'modified' => '2012-10-06 01:01:12'
		),
		array(
			'id' => 'product-length',
			'name' => 'product-length',
			'slug' => 'product-length',
			'description' => 'Length of the product in mm',
			'active' => 1,
			'product_count' => 1,
			'shop_unit_type_id' => 'dimentions',
			'created' => '2012-10-06 01:01:12',
			'modified' => '2012-10-06 01:01:12'
		),
		array(
			'id' => 'ship-length',
			'name' => 'ship-length',
			'slug' => 'ship-length',
			'description' => 'Length of the product in mm including packaging',
			'active' => 1,
			'product_count' => 1,
			'shop_unit_type_id' => 'dimentions',
			'created' => '2012-10-06 01:01:12',
			'modified' => '2012-10-06 01:01:12'
		),
	);

}

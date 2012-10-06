<?php
/**
 * ShopProductTypesOptionFixture
 *
 */
class ShopProductTypesOptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_product_type_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_options_products_shop_options1' => array('column' => 'shop_option_id', 'unique' => 0),
			'fk_shop_products_options_shop_product_types1' => array('column' => 'shop_product_type_id', 'unique' => 0)
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
			'id' => '5070b41e-b600-4446-be37-28146318cd70',
			'shop_option_id' => 'Lorem ipsum dolor sit amet',
			'shop_product_type_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-06 23:43:42',
			'modified' => '2012-10-06 23:43:42',
			'ordering' => 1
		),
	);

}

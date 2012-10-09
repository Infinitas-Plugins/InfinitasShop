<?php
/**
 * ShopListProductOptionFixture
 *
 */
class ShopListProductOptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_list_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_list_product_options_shop_lists1_idx' => array('column' => 'shop_list_id', 'unique' => 0),
			'fk_shop_list_product_options_shop_options1_idx' => array('column' => 'shop_option_id', 'unique' => 0),
			'fk_shop_list_product_options_shop_option_values1_idx' => array('column' => 'shop_option_value_id', 'unique' => 0)
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
			'id' => '50733304-38a4-44cb-b46e-12f66318cd70',
			'shop_list_id' => 'Lorem ipsum dolor sit amet',
			'shop_option_id' => 'Lorem ipsum dolor sit amet',
			'shop_option_value_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-08 21:09:40'
		),
	);

}

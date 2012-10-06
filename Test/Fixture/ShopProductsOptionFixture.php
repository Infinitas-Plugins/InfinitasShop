<?php
/**
 * ShopProductsOptionFixture
 *
 */
class ShopProductsOptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_options_products_shop_options1' => array('column' => 'shop_option_id', 'unique' => 0),
			'fk_shop_options_products_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0)
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
			'id' => 'active-size',
			'shop_option_id' => 'option-size',
			'shop_product_id' => 'active',
			'created' => '2012-10-05 10:00:32',
			'modified' => '2012-10-05 10:00:32'
		),
		array(
			'id' => 'multi-option-size',
			'shop_option_id' => 'option-size',
			'shop_product_id' => 'multi-option',
			'created' => '2012-10-05 10:00:32',
			'modified' => '2012-10-05 10:00:32'
		),
		array(
			'id' => 'multi-option-colour',
			'shop_option_id' => 'option-colour',
			'shop_product_id' => 'multi-option',
			'created' => '2012-10-05 10:00:32',
			'modified' => '2012-10-05 10:00:32'
		),
	);

}

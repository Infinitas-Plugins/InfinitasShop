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
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_type_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_options_products_shop_options1' => array('column' => 'shop_option_id', 'unique' => 0),
			'fk_shop_products_options_shop_product_types1' => array('column' => 'shop_product_type_id', 'unique' => 0)
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
			'id' => 'product-option-shirts-size',
			'shop_option_id' => 'option-size',
			'shop_product_type_id' => 'shirts',
			'created' => '2012-10-06 23:43:42',
			'modified' => '2012-10-06 23:43:42',
			'ordering' => 1
		),
		array(
			'id' => 'product-option-comp-options-size',
			'shop_option_id' => 'option-size',
			'shop_product_type_id' => 'complex-options',
			'created' => '2012-10-06 23:43:42',
			'modified' => '2012-10-06 23:43:42',
			'ordering' => 1
		),
		array(
			'id' => 'product-option-complex-options-colour',
			'shop_option_id' => 'option-colour',
			'shop_product_type_id' => 'complex-options',
			'created' => '2012-10-06 23:43:42',
			'modified' => '2012-10-06 23:43:42',
			'ordering' => 2
		),


	);

}

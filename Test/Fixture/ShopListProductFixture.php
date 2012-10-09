<?php
/**
 * ShopListProductFixture
 *
 */
class ShopListProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'shop_list_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'price' => array('type' => 'float', 'null' => false, 'default' => '0.00000', 'length' => '15,5'),
		'quantity' => array('type' => 'float', 'null' => false, 'default' => '1.00000', 'length' => '15,5'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_wishlists_shop_products1_idx' => array('column' => 'shop_product_id', 'unique' => 0),
			'fk_shop_lists_shop_lists_users1_idx' => array('column' => 'shop_list_id', 'unique' => 0)
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
			'shop_list_id' => 'Lorem ipsum dolor sit amet',
			'shop_product_id' => 'Lorem ipsum dolor sit amet',
			'price' => 1,
			'quantity' => 1,
			'created' => '2012-10-08 21:10:20',
			'modified' => '2012-10-08 21:10:20'
		),
	);

}

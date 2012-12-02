<?php
/**
 * ShopOrderStatusFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopOrderStatusFixture extends CakeTestFixture {

/**
 * fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 5),
		'shop_order_count' => array('type' => 'integer', 'null' => false, 'default' => 0),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'canceled',
			'name' => 'canceled',
			'status' => 0,
			'shop_order_count' => 0,
			'created' => '2012-10-14 02:36:52',
			'modified' => '2012-10-14 02:36:52'
		),
		array(
			'id' => 'pending',
			'name' => 'pending',
			'status' => 5,
			'shop_order_count' => 0,
			'created' => '2012-10-14 02:36:52',
			'modified' => '2012-10-14 02:36:52'
		),
		array(
			'id' => 'processing',
			'name' => 'processing',
			'status' => 10,
			'shop_order_count' => 0,
			'created' => '2012-10-14 02:36:52',
			'modified' => '2012-10-14 02:36:52'
		),
		array(
			'id' => 'processed',
			'name' => 'processed',
			'status' => 15,
			'shop_order_count' => 0,
			'created' => '2012-10-14 02:36:52',
			'modified' => '2012-10-14 02:36:52'
		),
		array(
			'id' => 'shipped',
			'name' => 'shipped',
			'status' => 15,
			'shop_order_count' => 0,
			'created' => '2012-10-14 02:36:52',
			'modified' => '2012-10-14 02:36:52'
		),
		array(
			'id' => 'completed',
			'name' => 'completed',
			'status' => 20,
			'shop_order_count' => 0,
			'created' => '2012-10-14 02:36:52',
			'modified' => '2012-10-14 02:36:52'
		),
		array(
			'id' => 'reversed',
			'name' => 'reversed',
			'status' => 25,
			'shop_order_count' => 0,
			'created' => '2012-10-14 02:36:52',
			'modified' => '2012-10-14 02:36:52'
		),
	);
}
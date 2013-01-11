<?php
/**
 * ShopOrderNoteFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopOrderNoteFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_order_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_order_status_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_notified' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_order_notes_order_statuses1_idx' => array('column' => 'shop_order_status_id', 'unique' => 0),
			'fk_shop_order_notes_shop_orders1_idx' => array('column' => 'shop_order_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'order-1-note-a',
			'shop_order_id' => 'order-1',
			'shop_order_status_id' => 'pending',
			'notes' => 'Order created',
			'user_notified' => 1,
			'created' => '2012-10-14 11:25:27'
		),
		array(
			'id' => 'order-1-note-b',
			'shop_order_id' => 'order-1',
			'shop_order_status_id' => 'processing',
			'notes' => 'Fetching products',
			'user_notified' => 0,
			'created' => '2012-10-14 11:25:27'
		),
		array(
			'id' => 'order-1-note-c',
			'shop_order_id' => 'order-1',
			'shop_order_status_id' => 'shipped',
			'notes' => 'Shipped',
			'user_notified' => 1,
			'created' => '2012-10-14 11:25:27'
		),
		array(
			'id' => 'order-2-note-a',
			'shop_order_id' => 'order-2',
			'shop_order_status_id' => 'pending',
			'notes' => 'Order created',
			'user_notified' => 1,
			'created' => '2012-10-14 11:25:27'
		),
	);
}
<?php
App::uses('ShopOrderNote', 'Shop.Model');

/**
 * ShopOrderNote Test Case
 *
 */
class ShopOrderNoteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_order_note',
		'plugin.shop.shop_order',
		'plugin.shop.shop_order_status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopOrderNote');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Model);

		parent::tearDown();
	}

/**
 * test find notes exceptions
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindNotesException() {
		$this->Model->find('notes');
	}

/**
 * test find notes
 *
 * @return void
 */
	public function testFindNotes() {
		$expected = array(
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
		);
		$result = $this->Model->find('notes', array(
			'order-1',
			'admin' => true
		));
		$this->assertEquals($expected, $result);

		unset($expected[1]);
		$result = $this->Model->find('notes', 'order-1');
		$this->assertEquals(array_values($expected), $result);
	}

}

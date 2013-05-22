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

	public function testValidation() {
		$data = array();

		$expected = array(
			'shop_order_id' => array('No order specified'),
			'shop_order_status_id' => array('No order status specified'),
		);
		$this->Model->create();
		$result = $this->Model->save($data);
		$this->assertFalse((bool)$result);
		$this->assertEquals($expected, $this->Model->validationErrors);

		$data['shop_order_status_id'] = 'fake-order-status';
		$expected = array(
			'shop_order_id' => array('No order specified'),
			'shop_order_status_id' => array('Invalid order status specified')
		);
		$this->Model->create();
		$result = $this->Model->save($data);
		$this->assertFalse((bool)$result);
		$this->assertEquals($expected, $this->Model->validationErrors);

		$data['shop_order_status_id'] = 'pending';
		$expected = array(
			'shop_order_id' => array('No order specified'),
		);
		$this->Model->create();
		$result = $this->Model->save($data);
		$this->assertFalse((bool)$result);
		$this->assertEquals($expected, $this->Model->validationErrors);

		$data['shop_order_id'] = 'fake-order-id';
		$expected = array(
			'shop_order_id' => array('Invalid order specified'),
		);
		$this->Model->create();
		$result = $this->Model->save($data);
		$this->assertFalse((bool)$result);
		$this->assertEquals($expected, $this->Model->validationErrors);

		$data['shop_order_id'] = 'order-1';
		$expected = array();
		$this->Model->create();
		$result = $this->Model->save($data);
		$this->assertTrue((bool)$result);
		$this->assertEquals($expected, $this->Model->validationErrors);
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

		$expected = array(array(
			'id' => 'order-2-note-a',
			'shop_order_id' => 'order-2',
			'shop_order_status_id' => 'pending',
			'notes' => 'Order created',
			'user_notified' => 1,
			'created' => '2012-10-14 11:25:27'
		));
		$result = $this->Model->find('notes', 'order-2');
		$this->assertEquals($expected, $result);

		$expected = array(array(
			'id' => 'order-2-note-a',
			'shop_order_id' => 'order-2',
			'shop_order_status_id' => 'pending',
			'notes' => 'Order created',
			'user_notified' => 1,
			'created' => '2012-10-14 11:25:27'
		), array(
			'id' => 'order-2-note-b',
			'shop_order_id' => 'order-2',
			'shop_order_status_id' => 'pending',
			'notes' => 'internal',
			'user_notified' => 0,
			'created' => '2012-10-14 11:25:27'
		));
		$result = $this->Model->find('notes', array(
			'order-2',
			'admin' => true
		));
		$this->assertEquals($expected, $result);
	}

/**
 * test save notes
 */
	public function testSaveNote() {
		$this->assertFalse($this->Model->saveNote(array()));

		$data = array(
			'shop_order_id' => 'order-1',
			'shop_order_status_id' => 'pending',
			'notes' => 'note 123',
			'user_notified' => true,
			'internal' => true,
		);
		$result = $this->Model->saveNote($data);
		$this->assertTrue((bool)$result);

		$expected = array(
			'shop_order_id' => 'order-1',
			'shop_order_status_id' => 'pending',
			'notes' => 'note 123',
			'user_notified' => true,
			'internal' => false,
		);
		$result = current($this->Model->find('first', array(
			'conditions' => array(
				'ShopOrderNote.id' => $this->Model->id
			),
			'fields' => array(
				'ShopOrderNote.shop_order_id',
				'ShopOrderNote.shop_order_status_id',
				'ShopOrderNote.notes',
				'ShopOrderNote.user_notified',
				'ShopOrderNote.internal',
			)
		)));
		$this->assertEquals($expected, $result);
	}

}

<?php
App::uses('ShopOrderStatus', 'Shop.Model');

/**
 * ShopOrderStatus Test Case
 *
 */
class ShopOrderStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_order_status',
		'plugin.shop.shop_order_note',
		'plugin.shop.shop_order'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopOrderStatus = ClassRegistry::init('Shop.ShopOrderStatus');
		$this->modelClass = $this->ShopOrderStatus->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOrderStatus);

		parent::tearDown();
	}

/**
 * testGetViewData method
 *
 * @return void
 */
	public function testStatuses() {
		$expected = array(
			0 => 'Canceled',
			5 => 'Pending',
			10 => 'Processing',
			15 => 'Processed',
			20 => 'Completed',
			25 => 'Reversed'
		);
		$results = $this->{$this->modelClass}->statuses();
		$this->assertEquals($expected, $results);
	}

/**
 * Test find statuses
 *
 * @return void
 */
	public function testFindStatuses() {
		$expected = array (
			'Canceled ' => array (
				'canceled' => 'canceled',
			),
			'Pending ' => array (
				'pending' => 'pending',
			),
			'Processing ' => array (
				'processing' => 'processing',
			),
			'Processed ' => array (
				'processed' => 'processed',
				'shipped' => 'shipped',
			),
			'Completed ' => array (
				'completed' => 'completed',
			),
			'Reversed ' => array (
				'reversed' => 'reversed',
			),
		);
		$result = $this->{$this->modelClass}->find('statuses');
		$this->assertEquals($expected, $result);
	}

}

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
		$this->ShopOrderNote = ClassRegistry::init('Shop.ShopOrderNote');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOrderNote);

		parent::tearDown();
	}

/**
 * testGetViewData method
 *
 * @return void
 */
	public function testGetViewData() {
	}

}

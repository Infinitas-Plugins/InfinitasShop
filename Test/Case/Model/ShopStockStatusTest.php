<?php
App::uses('ShopStockStatus', 'Shop.Model');

/**
 * ShopStockStatus Test Case
 *
 */
class ShopStockStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_stock_status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopStockStatus = ClassRegistry::init('Shop.ShopStockStatus');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopStockStatus);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

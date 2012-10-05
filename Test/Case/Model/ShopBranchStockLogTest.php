<?php
App::uses('ShopBranchStockLog', 'Shop.Model');

/**
 * ShopBranchStockLog Test Case
 *
 */
class ShopBranchStockLogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_branch_stock_log',
		'plugin.shop.shop_branch_stock'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBranchStockLog = ClassRegistry::init('Shop.ShopBranchStockLog');
		$this->modelClass = $this->ShopBranchStockLog->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBranchStockLog);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

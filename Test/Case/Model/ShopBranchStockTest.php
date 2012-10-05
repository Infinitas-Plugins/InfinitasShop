<?php
App::uses('ShopBranchStock', 'Shop.Model');

/**
 * ShopBranchStock Test Case
 *
 */
class ShopBranchStockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_branch',
		'plugin.shop.shop_product',
		'plugin.shop.view_counter_view',
		'plugin.shop.shop_branch_stock_log'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBranchStock = ClassRegistry::init('Shop.ShopBranchStock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBranchStock);

		parent::tearDown();
	}

}

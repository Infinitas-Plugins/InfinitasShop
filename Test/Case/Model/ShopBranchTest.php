<?php
App::uses('ShopBranch', 'Shop.Model');

/**
 * ShopBranch Test Case
 *
 */
class ShopBranchTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_branch',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_product',
		'plugin.shop.shop_branch_stock_log',
		'plugin.shop.contact_branch',

		'plugin.users.user',
		'plugin.users.group',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBranch = ClassRegistry::init('Shop.ShopBranch');
		$this->modelClass = $this->ShopBranch->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBranch);

		parent::tearDown();
	}

	public function testSomething() {
	}

}

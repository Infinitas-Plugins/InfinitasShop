<?php
App::uses('ShopList', 'Shop.Model');

/**
 * ShopList Test Case
 *
 */
class ShopListTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list',
		'plugin.shop.shop_product',
		'plugin.view_counter.view_counter_view',
		'plugin.users.user',
		'plugin.users.group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopList = ClassRegistry::init('Shop.ShopList');
		$this->modelClass = $this->ShopList->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopList);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

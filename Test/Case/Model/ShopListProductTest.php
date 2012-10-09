<?php
App::uses('ShopListProduct', 'Shop.Model');

/**
 * ShopListProduct Test Case
 *
 */
class ShopListProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_list',
		'plugin.shop.shop_product',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopListProduct = ClassRegistry::init('Shop.ShopListProduct');
		$this->modelClass = $this->ShopListProduct->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopListProduct);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

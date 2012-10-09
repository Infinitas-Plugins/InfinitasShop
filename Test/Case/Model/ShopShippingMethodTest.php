<?php
App::uses('ShopShippingMethod', 'Shop.Model');

/**
 * ShopShippingMethod Test Case
 *
 */
class ShopShippingMethodTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_shipping_method',
		'plugin.shop.shop_list',
		'plugin.shop.shop_order',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopShippingMethod = ClassRegistry::init('Shop.ShopShippingMethod');
		$this->modelClass = $this->ShopShippingMethod->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopShippingMethod);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

<?php
App::uses('ShopPaymentMethod', 'Shop.Model');

/**
 * ShopPaymentMethod Test Case
 *
 */
class ShopPaymentMethodTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_payment_method',
		'plugin.shop.shop_payment_method_api',
		'plugin.shop.shop_list',
		'plugin.shop.shop_order',
		'plugin.shop.shop_payment_field',
		'plugin.shop.shop_payment_method_status',
		'plugin.shop.shop_payment_response'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopPaymentMethod = ClassRegistry::init('Shop.ShopPaymentMethod');
		$this->modelClass = $this->ShopPaymentMethod->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopPaymentMethod);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

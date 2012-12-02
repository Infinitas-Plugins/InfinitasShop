<?php
App::uses('ShopPaymentResponse', 'Shop.Model');

/**
 * ShopPaymentResponse Test Case
 *
 */
class ShopPaymentResponseTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_payment_response',
		'plugin.shop.shop_payment_method',
		'plugin.shop.shop_order'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopPaymentResponse = ClassRegistry::init('Shop.ShopPaymentResponse');
		$this->modelClass = $this->ShopPaymentResponse->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopPaymentResponse);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
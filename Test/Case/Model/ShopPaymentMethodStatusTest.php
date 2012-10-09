<?php
App::uses('ShopPaymentMethodStatus', 'Shop.Model');

/**
 * ShopPaymentMethodStatus Test Case
 *
 */
class ShopPaymentMethodStatusTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_payment_method_status',
		'plugin.shop.shop_payment_method'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopPaymentMethodStatus = ClassRegistry::init('Shop.ShopPaymentMethodStatus');
		$this->modelClass = $this->ShopPaymentMethodStatus->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopPaymentMethodStatus);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

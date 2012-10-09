<?php
App::uses('ShopPaymentMethodApi', 'Shop.Model');

/**
 * ShopPaymentMethodApi Test Case
 *
 */
class ShopPaymentMethodApiTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_payment_method_api',
		'plugin.shop.shop_payment_method',
		'plugin.shop.shop_currency'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopPaymentMethodApi = ClassRegistry::init('Shop.ShopPaymentMethodApi');
		$this->modelClass = $this->ShopPaymentMethodApi->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopPaymentMethodApi);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

<?php
App::uses('ShopCurrency', 'Shop.Model');

/**
 * ShopCurrency Test Case
 *
 */
class ShopCurrencyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_currency',
		'plugin.shop.shop_payment_method_api'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopCurrency = ClassRegistry::init('Shop.ShopCurrency');
		$this->modelClass = $this->ShopCurrency->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopCurrency);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

<?php
App::uses('ShopPaymentField', 'Shop.Model');

/**
 * ShopPaymentField Test Case
 *
 */
class ShopPaymentFieldTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_payment_field',
		'plugin.shop.shop_payment_method'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopPaymentField = ClassRegistry::init('Shop.ShopPaymentField');
		$this->modelClass = $this->ShopPaymentField->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopPaymentField);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

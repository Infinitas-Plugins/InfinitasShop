<?php
App::uses('ShopUnit', 'Shop.Model');

/**
 * ShopUnit Test Case
 *
 */
class ShopUnitTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_unit',
		'plugin.shop.shop_unit_type',
		'plugin.shop.shop_product_size'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopUnit = ClassRegistry::init('Shop.ShopUnit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopUnit);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

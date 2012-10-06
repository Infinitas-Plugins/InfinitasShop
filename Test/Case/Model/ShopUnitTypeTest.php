<?php
App::uses('ShopUnitType', 'Shop.Model');

/**
 * ShopUnitType Test Case
 *
 */
class ShopUnitTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_unit_type',
		'plugin.shop.shop_unit'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopUnitType = ClassRegistry::init('Shop.ShopUnitType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopUnitType);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

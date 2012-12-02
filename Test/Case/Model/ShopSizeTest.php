<?php
App::uses('ShopSize', 'Shop.Model');

/**
 * ShopSize Test Case
 *
 */
class ShopSizeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_size'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopSize = ClassRegistry::init('Shop.ShopSize');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopSize);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
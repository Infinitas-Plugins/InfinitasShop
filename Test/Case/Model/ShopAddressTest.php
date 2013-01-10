<?php
App::uses('ShopAddress', 'Shop.Model');

/**
 * ShopAddress Test Case
 *
 */
class ShopAddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_address',
		'plugin.shop.core_user',
		'plugin.shop.core_group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopAddress = ClassRegistry::init('Shop.ShopAddress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopAddress);

		parent::tearDown();
	}

/**
 * testGetViewData method
 *
 * @return void
 */
	public function testGetViewData() {
	}

}

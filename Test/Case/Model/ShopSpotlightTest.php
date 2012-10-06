<?php
App::uses('ShopSpotlight', 'Shop.Model');

/**
 * ShopSpotlight Test Case
 *
 */
class ShopSpotlightTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_product',
		'plugin.shop.shop_image',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopSpotlight = ClassRegistry::init('Shop.ShopSpotlight');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopSpotlight);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

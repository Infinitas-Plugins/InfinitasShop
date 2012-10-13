<?php
App::uses('ShopBrand', 'Shop.Model');

/**
 * ShopBrand Test Case
 *
 */
class ShopBrandTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_brand',
		'plugin.shop.shop_product',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBrand = ClassRegistry::init('Shop.ShopBrand');
		$this->modelClass = $this->ShopBrand->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBrand);

		parent::tearDown();
	}

	public function testSomething() {
	}

}

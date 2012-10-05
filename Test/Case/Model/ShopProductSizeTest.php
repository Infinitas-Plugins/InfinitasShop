<?php
App::uses('ShopProductSize', 'Shop.Model');

/**
 * ShopProductSize Test Case
 *
 */
class ShopProductSizeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product_size',
		'plugin.shop.shop_product',
		'plugin.shop.shop_unit',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductSize = ClassRegistry::init('Shop.ShopProductSize');

		$this->modelClass = $this->ShopProductSize->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductSize);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

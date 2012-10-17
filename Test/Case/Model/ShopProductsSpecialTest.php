<?php
App::uses('ShopProductsSpecial', 'Shop.Model');

/**
 * ShopProductsSpecial Test Case
 *
 */
class ShopProductsSpecialTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_products_special',
		'plugin.shop.shop_product',
		'plugin.shop.shop_special',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductsSpecial = ClassRegistry::init('Shop.ShopProductsSpecial');
		$this->modelClass = $this->ShopProductsSpecial->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductsSpecial);

		parent::tearDown();
	}

/**
 * testGetViewData method
 *
 * @return void
 */
	public function testSomething() {
	}

}

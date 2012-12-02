<?php
App::uses('ShopCategoriesProduct', 'Shop.Model');

/**
 * ShopCategoriesProduct Test Case
 *
 */
class ShopCategoriesProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
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
		$this->ShopCategoriesProduct = ClassRegistry::init('Shop.ShopCategoriesProduct');
		$this->modelClass = $this->ShopCategoriesProduct->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopCategoriesProduct);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
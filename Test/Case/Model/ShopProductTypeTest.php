<?php
App::uses('ShopProductType', 'Shop.Model');

/**
 * ShopProductType Test Case
 *
 */
class ShopProductTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_product',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_product_types_option',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductType = ClassRegistry::init('Shop.ShopProductType');
		$this->modelClass = $this->ShopProductType->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductType);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
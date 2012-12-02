<?php
App::uses('ShopProductsOptionValueOverride', 'Shop.Model');

/**
 * ShopProductsOptionValueOverride Test Case
 *
 */
class ShopProductsOptionValueOverrideTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_products_option_value_override',
		'plugin.shop.shop_option_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductsOptionValueOverride = ClassRegistry::init('Shop.ShopProductsOptionValueOverride');
		$this->modelClass = $this->ShopProductsOptionValueOverride->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductsOptionValueOverride);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
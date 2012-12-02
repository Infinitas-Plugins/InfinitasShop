<?php
App::uses('ShopProductsOptionValueIgnore', 'Shop.Model');

/**
 * ShopProductsOptionValueIgnore Test Case
 *
 */
class ShopProductsOptionValueIgnoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_products_option_value_ignore',
		'plugin.shop.shop_option_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductsOptionValueIgnore = ClassRegistry::init('Shop.ShopProductsOptionValueIgnore');
		$this->modelClass = $this->ShopProductsOptionValueIgnore->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductsOptionValueIgnore);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
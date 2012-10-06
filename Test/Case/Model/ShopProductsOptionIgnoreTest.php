<?php
App::uses('ShopProductsOptionIgnore', 'Shop.Model');

/**
 * ShopProductsOptionIgnore Test Case
 *
 */
class ShopProductsOptionIgnoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_products_option_ignore',
		'plugin.shop.shop_option'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductsOptionIgnore = ClassRegistry::init('Shop.ShopProductsOptionIgnore');
		$this->modelClass = $this->ShopProductsOptionIgnore->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductsOptionIgnore);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

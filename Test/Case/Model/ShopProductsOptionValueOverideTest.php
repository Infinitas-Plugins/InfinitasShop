<?php
App::uses('ShopProductsOptionValueOveride', 'Shop.Model');

/**
 * ShopProductsOptionValueOveride Test Case
 *
 */
class ShopProductsOptionValueOverideTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_products_option_value_overide',
		'plugin.shop.shop_option_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductsOptionValueOveride = ClassRegistry::init('Shop.ShopProductsOptionValueOveride');
		$this->modelClass = $this->ShopProductsOptionValueOveride->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductsOptionValueOveride);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

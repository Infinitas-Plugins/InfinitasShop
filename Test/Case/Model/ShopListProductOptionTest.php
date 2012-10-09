<?php
App::uses('ShopListProductOption', 'Shop.Model');

/**
 * ShopListProductOption Test Case
 *
 */
class ShopListProductOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_list',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopListProductOption = ClassRegistry::init('Shop.ShopListProductOption');
		$this->modelClass = $this->ShopListProductOption->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopListProductOption);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

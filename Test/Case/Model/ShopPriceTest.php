<?php
App::uses('ShopPrice', 'Shop.Model');

/**
 * ShopPrice Test Case
 *
 */
class ShopPriceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_price',
		'plugin.shop.shop_products_option_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopPrice = ClassRegistry::init('Shop.ShopPrice');
		$this->modelClass = $this->ShopPrice->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopPrice);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

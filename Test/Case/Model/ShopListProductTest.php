<?php
App::uses('ShopListProduct', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopListProduct Test Case
 *
 */
class ShopListProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_list',
		'plugin.shop.shop_product',
		'plugin.shop.shop_price',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_image',
		'plugin.shop.shop_products_option_value_override',

		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopListProduct = ClassRegistry::init('Shop.ShopListProduct');
		$this->modelClass = $this->ShopListProduct->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopListProduct);
		CakeSession::destroy();

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

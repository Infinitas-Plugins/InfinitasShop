<?php
App::uses('ShopProductsOption', 'Shop.Model');

/**
 * ShopProductsOption Test Case
 *
 */
class ShopProductsOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_products_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_product',
		'plugin.shop.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductsOption = ClassRegistry::init('Shop.ShopProductsOption');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductsOption);

		parent::tearDown();
	}

}

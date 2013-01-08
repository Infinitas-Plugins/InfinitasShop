<?php
App::uses('ShopOrderProduct', 'Shop.Model');

/**
 * ShopOrderProduct Test Case
 *
 */
class ShopOrderProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_order_product',
		'plugin.shop.shop_order',
		'plugin.shop.shop_product_variant',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopOrderProduct = ClassRegistry::init('Shop.ShopOrderProduct');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOrderProduct);

		parent::tearDown();
	}

/**
 * testGetViewData method
 *
 * @return void
 */
	public function testGetViewData() {
	}

}

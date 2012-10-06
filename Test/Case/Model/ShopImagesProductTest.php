<?php
App::uses('ShopImagesProduct', 'Shop.Model');

/**
 * ShopImagesProduct Test Case
 *
 */
class ShopImagesProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_image',
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
		$this->ShopImagesProduct = ClassRegistry::init('Shop.ShopImagesProduct');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopImagesProduct);

		parent::tearDown();
	}

	public function testSomething() {
		
	}

}

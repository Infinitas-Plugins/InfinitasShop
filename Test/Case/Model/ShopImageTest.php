<?php
App::uses('ShopImage', 'Shop.Model');

/**
 * ShopImage Test Case
 *
 */
class ShopImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_image',
		'plugin.shop.shop_category',
		'plugin.shop.shop_product',
		'plugin.shop.shop_special',
		'plugin.shop.shop_spotlight',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopImage = ClassRegistry::init('Shop.ShopImage');
		$this->modelClass = $this->ShopImage->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopImage);

		parent::tearDown();
	}

	public function testSomething() {

	}

}

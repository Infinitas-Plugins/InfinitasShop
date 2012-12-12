<?php
App::uses('ShopOptionVariant', 'Shop.Model');

/**
 * ShopOptionVariant Test Case
 *
 */
class ShopOptionVariantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_option_variant',
		'plugin.shop.shop_product_variant',
		'plugin.shop.shop_option_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopOptionVariant = ClassRegistry::init('Shop.ShopOptionVariant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOptionVariant);

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

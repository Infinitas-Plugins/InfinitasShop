<?php
App::uses('ShopProductAttribute', 'Shop.Model');

/**
 * ShopProductAttribute Test Case
 *
 */
class ShopProductAttributeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product_attribute',
		'plugin.shop.shop_attribute',
		'plugin.shop.shop_product'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductAttribute = ClassRegistry::init('Shop.ShopProductAttribute');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductAttribute);

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

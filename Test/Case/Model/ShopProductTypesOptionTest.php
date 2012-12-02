<?php
App::uses('ShopProductTypesOption', 'Shop.Model');

/**
 * ShopProductTypesOption Test Case
 *
 */
class ShopProductTypesOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_product_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductTypesOption = ClassRegistry::init('Shop.ShopProductTypesOption');
		$this->modelClass = $this->ShopProductTypesOption->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductTypesOption);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
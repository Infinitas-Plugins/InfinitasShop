<?php
App::uses('ShopProductVariant', 'Model');

/**
 * ShopProductVariant Test Case
 *
 */
class ShopProductVariantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.shop_product_variant',
		'app.shop_product',
		'app.view_counter_view',
		'app.shop_list_product',
		'app.shop_option_variant',
		'app.shop_order_product'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductVariant = ClassRegistry::init('ShopProductVariant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductVariant);

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

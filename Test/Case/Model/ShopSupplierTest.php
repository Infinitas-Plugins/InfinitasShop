<?php
App::uses('ShopSupplier', 'Shop.Model');

/**
 * ShopSupplier Test Case
 *
 */
class ShopSupplierTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_contact_address',
		'plugin.shop.shop_branch_stock_log',
		'plugin.shop.shop_product',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopSupplier = ClassRegistry::init('Shop.ShopSupplier');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopSupplier);

		parent::tearDown();
	}

	public function testSomething() {
	}
}
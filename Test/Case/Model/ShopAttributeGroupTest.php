<?php
App::uses('ShopAttributeGroup', 'Shop.Model');

/**
 * ShopAttributeGroup Test Case
 *
 */
class ShopAttributeGroupTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_attribute_group',
		'plugin.shop.shop_attribute'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopAttributeGroup = ClassRegistry::init('Shop.ShopAttributeGroup');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopAttributeGroup);

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

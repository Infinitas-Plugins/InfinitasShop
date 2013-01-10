<?php
App::uses('ShopProduct', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopProductFindTest
 *
 * General find tests for things like search and pagination
 *
 * @package Shop.Test.Case
 */
class ShopProductFindTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product',
		'plugin.shop.shop_brand',
		'plugin.shop.shop_size',
		'plugin.shop.shop_image',
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_branch',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_products_special',
		'plugin.shop.shop_product_variant',
		'plugin.shop.shop_option_variant',
		'plugin.shop.shop_special',
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_price',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_order',
		'plugin.shop.shop_order_product',
		'plugin.shop.shop_list',
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_shipping_method',
		'plugin.shop.shop_payment_method',

		'plugin.shop.shop_contact_address',

		'plugin.shop.core_user',
		'plugin.shop.core_group',

		'plugin.view_counter.view_counter_view',
		'plugin.trash.trash',
		'plugin.management.ticket',
		'plugin.installer.plugin'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProduct = ClassRegistry::init('Shop.ShopProduct');
		$this->modelClass = $this->ShopProduct->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProduct);

		parent::tearDown();
	}

/**
 * find paginated
 *
 * @dataProvider findPaginatedDataProvider
 */
	public function testFindPaginated($data, $expected) {
		$result = $this->{$this->modelClass}->find('paginated', $data);
		$result = Hash::extract($result, '{n}.ShopProductVariantMaster.id');
		$this->assertEquals($expected, $result);
	}

/**
 * find paginated data provider
 *
 * @return array
 */
	public function findPaginatedDataProvider() {
		return array(
			'empty' => array(
				array('conditions' => array('ShopProduct.name' => 'xxxxxxx')),
				array()
			),
			'noraml' => array(
				array(
					'limit' => 1,
					'order' => array(
						'ShopProduct.name' => 'asc'
					)
				),
				array(
					'variant-active-master'
				)
			)
		);
	}

/**
 * Test finding paginated lists by category
 */
	public function testFindPaginatedByCategory() {
		$this->assertEmpty($this->{$this->modelClass}->find('paginated', array(
			'category' => 'inactive'
		)));

		$expected = array(
			'active',
			'multi-category',
			'multi-category-mixed-state',
			'multi-category-parent-inactive',
			'multi-option'
		);
		$result = $this->{$this->modelClass}->find('paginated', array(
			'category' => 'active'
		));
		$result = Hash::extract($result, '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'multi-category'
		);
		$result = $this->{$this->modelClass}->find('paginated', array(
			'category' => 'another'
		));
		$result = Hash::extract($result, '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);
	}

/**
 * test product search
 */
	public function testFindSearch() {
		$expected = array(
			'active',
			'inactive-parent-category',
			'multi-category',
			'multi-category-mixed-state',
			'multi-category-parent-inactive',
			'multi-option'
		);

		$result = $this->{$this->modelClass}->find('search', array(
			'search' => 'active'
		));
		$result = Hash::extract($result, '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'multi-category-mixed-state'
		);
		$result = $this->{$this->modelClass}->find('search', array(
			'search' => '%mix%'
		));
		$result = Hash::extract($result, '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'active'
		);
		$result = $this->{$this->modelClass}->find('search', array(
			'search' => '!multi%'
		));
		$result = Hash::extract($result, '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);
	}

/**
 * test find wrapper methods
 */
	public function testFindWrappers() {
		$expected = array(
			'active',
			'inactive-parent-category',
			'multi-category',
			'multi-category-mixed-state',
			'multi-category-parent-inactive',
			'multi-option'
		);
		$result = Hash::extract($this->{$this->modelClass}->find('new'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'multi-category-parent-inactive',
			'multi-category-mixed-state',
			'active',
			'inactive-parent-category',
			'multi-category',
			'multi-option'
		);
		$result = Hash::extract($this->{$this->modelClass}->find('updated'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'multi-option'
		);
		$result = Hash::extract($this->{$this->modelClass}->find('specials'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'multi-option'
		);
		$result = Hash::extract($this->{$this->modelClass}->find('spotlights'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'multi-option',
			'multi-category',
			'multi-category-mixed-state',
			'active',
			'inactive-parent-category',
			'multi-category-parent-inactive',
		);
		$result = Hash::extract($this->{$this->modelClass}->find('mostViewed'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		$expected = array(
			'multi-category',
			'multi-option',
			'active',
			'inactive-parent-category',
			'multi-category-mixed-state',
			'multi-category-parent-inactive',
		);
		$result = Hash::extract($this->{$this->modelClass}->find('mostPurchased'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);


		$ViewCounter = ClassRegistry::init('ViewCounter.ViewCounterView');
		$saved = $ViewCounter->saveAll(array(
			array(
				'model' => 'Shop.ShopProduct',
				'foreign_key' => 'active',
				'created' => '2011-01-01 00:00:00',
				'user_id' => 'bob'
			),
			array(
				'model' => 'Shop.ShopProduct',
				'foreign_key' => 'multi-option',
				'created' => '2012-01-01 00:00:00',
				'user_id' => 'bob'
			),
			array(
				'model' => 'Shop.ShopProduct',
				'foreign_key' => 'multi-option',
				'created' => '2011-01-01 00:00:00',
				'user_id' => 'bob'
			),
			array(
				'model' => 'Shop.ShopProduct',
				'foreign_key' => 'active',
				'created' => '2012-01-02 00:00:00',
				'user_id' => 'bob'
			),
			array(
				'model' => 'Shop.ShopProduct',
				'foreign_key' => 'multi-category',
				'created' => '2013-01-01 00:00:00',
				'user_id' => 'sam'
			)
		));
		$this->assertTrue((bool)$saved);

		$expected = array(
			'active',
			'multi-option'
		);
		CakeSession::write('Auth.User.id', 'bob');
		$result = Hash::extract($this->{$this->modelClass}->find('recentlyViewed'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $result);

		CakeSession::destroy();
	}

/**
 * test find products
 *
 * @dataProvider findProductDataProvider
 */
	public function testFindProduct($data, $expected) {
		$result = $this->{$this->modelClass}->find('product', $data);
		$result = Hash::extract($result, 'ShopProductVariantMaster.id');
		$this->assertEquals($expected, $result);
	}

/**
 * find products data provider
 */
	public function findProductDataProvider() {
		return array(
			'made-up' => array(
				'made-up',
				array()
			),
			'active' => array(
				'active',
				array('variant-active-master')
			),
			'multi-category' => array(
				'multi-category',
				array('variant-multi-category-master')
			),
			'mixed-state' => array(
				'multi-category-mixed-state',
				array('variant-multi-category-mixed')
			),
			'mixed-state-parent-inactive' => array(
				'multi-category-parent-inactive',
				array('variant-multi-parent-inactive')
			),
			'multi-option' => array(
				'multi-option',
				array('variant-multi-option-master')
			)
		);
	}

	public function testFindProductsForListDefault() {
		CakeSession::write('Auth.User.id', 'bob');
		CakeSession::write('Shop.current_list', 'shop-list-bob-cart');

		$expected = $this->findProductsForListDataProvider();
		$expected = end($expected['bob-cart']);
		$result = $this->{$this->modelClass}->find('productsForList');
		$result = Hash::extract($result, '{n}.ShopProductVariantMaster.id');
		$this->assertEquals($expected, $result);
	}

/**
 * test find products for list
 *
 * @dataProvider  findProductsForListDataProvider
 */
	public function testFindProductsForList($data, $expected) {
		if (isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if (isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
		$result = $this->{$this->modelClass}->find('productsForList', array(
			'shop_list_id' => $data['shop_list_id']
		));
		$result = Hash::extract($result, '{n}.ShopProductVariantMaster.id');
		$this->assertEquals($expected, $result);

		CakeSession::destroy();
	}

/**
 * find products for list data provider
 *
 * @return array
 */
	public function findProductsForListDataProvider() {
		return array(
			/*'empty' => array(
				array('shop_list_id' => null),
				array()
			),*/
			'bob-cart' => array(
				array(
					'shop_list_id' => 'shop-list-bob-cart',
					'user_id' => 'bob'
				),
				array(
					'variant-active-master',
					'variant-multi-option-master',
					'variant-multi-option-master'
				)
			)
		);
	}

/**
 * test find products for order exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindProductsForOrderException() {
		$this->{$this->modelClass}->find('productsForOrder');
	}

/**
 * Test find products for order
 */
	public function testFindProductsForOrder() {
		$this->assertEmpty($this->{$this->modelClass}->find('productsForOrder', array(
			'shop_order_id' => 'order-1'
		)));

		CakeSession::write('Auth.User.id', 'sam');
		$this->assertEmpty($this->{$this->modelClass}->find('productsForOrder', array(
			'shop_order_id' => 'order-1'
		)));
		CakeSession::delete('Auth');

		$this->assertEmpty($this->{$this->modelClass}->find('productsForOrder', array(
			'shop_order_id' => 'order-1',
			'user_id' => 'sam'
		)));

		$expected = array(
			'order-1b',
			'order-1a',
		);
		$result = $this->{$this->modelClass}->find('productsForOrder', array(
			'shop_order_id' => 'order-1',
			'admin' => true
		));
		$result = Hash::extract($result, '{n}.ShopOrderProduct.id');
		sort($expected);
		sort($result);
		$this->assertEquals($expected, $result);

		CakeSession::write('Auth.User.id', 'bob');
		$result = $this->{$this->modelClass}->find('productsForOrder', array(
			'shop_order_id' => 'order-1'
		));
		$result = Hash::extract($result, '{n}.ShopOrderProduct.id');
		$this->assertEquals($expected, $result);
	}

/**
 * test admin finds
 */
	public function testAdminFinds() {
		$expected = array(
			'active',
			'inactive-parent-category',
			'multi-category',
			'multi-category-mixed-state',
			'multi-category-parent-inactive',
			'multi-option'
		);
		$results = Hash::extract($this->{$this->modelClass}->find('paginated'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $results);

		$expected = array(
			'active',
			'inactive',
			'inactive-category',
			'inactive-parent-category',
			'multi-category',
			'multi-category-mixed-state',
			'multi-category-parent-inactive',
			'multi-option',
			'no-stock-added',
			'out-of-stock'
		);
		$results = Hash::extract($this->{$this->modelClass}->find('adminPaginated'), '{n}.ShopProduct.id');
		$this->assertEquals($expected, $results);
	}
}
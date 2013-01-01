<?php
App::uses('ShopListProduct', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopListProduct Test Case
 *
 */
class ShopListProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_list',
		'plugin.shop.shop_product',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_product_variant',
		'plugin.shop.shop_price',
		'plugin.shop.shop_image',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_brand',
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_size',

		'plugin.view_counter.view_counter_view',
		'plugin.installer.plugin',
		'plugin.management.ticket',
		'plugin.trash.trash',
		'plugin.users.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopListProduct');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopListProduct);
		CakeSession::destroy();

		parent::tearDown();
	}

/**
 * test validation
 *
 * @dataProvider validationDataProvider
 */
	public function testValidation($data, $expected) {
		CakeSession::write('Auth.User.id', 'bob');

		$this->Model->create();
		$result = $this->Model->save($data);

		$this->assertEquals(empty($expected), (bool)$result);
		$this->assertEquals($expected, $this->Model->validationErrors);
	}

/**
 * validation data provider
 *
 * @return array
 */
	public function validationDataProvider() {
		return array(
			'none' => array(
				array(),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'shop_product_variant_id' => array('Please select a product to add to your list')
				)
			),
			'incorrect-product' => array(
				array(
					'shop_product_variant_id' => 'made-up-product'
				),
				array(
					'shop_product_variant_id' => array('The selected product does not exist'),
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('Unable to validate the ordered quantity')
				)
			),
			'invalid quantity' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => null
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('Please enter the quantity you would like to purchase'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'quantity too many' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => 11
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('The maximum purchase quantity is "10"'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'quantity too few' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => 1.5
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('The minimum purchase quantity is "2"'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'quantity incorrect units' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => 5.75
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('Quantity should be in multiples of "0.5"'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'correct units' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => 5
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'correct units float' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => 2.5
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'no stock' => array(
				array(
					'shop_product_variant_id' => 'variant-no-stock-added-master',
					'quantity' => 10
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('That quantity is not available for the selected product')
				)
			),
			'0 quantity' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => 0,
					'shop_list_id' => 'shop-list-bob-cart'
				),
				array(
					'quantity' => array('No quantity specifed for order'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'other users list' => array(
				array(
					'shop_product_variant_id' => 'variant-active-1',
					'quantity' => 2.5,
					'shop_list_id' => 'shop-list-sally-cart'
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'shop_product_variant_id' => array('That product is already in your list')
				)
			),
			'correct list' => array(
				array(
					'shop_product_variant_id' => 'variant-active-2',
					'quantity' => 2.5,
					'shop_list_id' => 'shop-list-bob-cart'
				),
				array()
			),
		);
	}

/**
 * Test adding product to list
 */
	public function testAddToList() {
		$this->Model->Behaviors->disable('Trashable');
		CakeSession::write('Auth.User.id', 'sally');
		$data = array(
			$this->Model->alias => array(
				'shop_product_variant_id' => 'variant-active-2',
				'quantity' => 2.5
			)
		);
		$id = $this->Model->addToList($data);
		$this->assertTrue((bool)$id);
		$this->assertEmpty($this->Model->validationErrors);

		$this->markTestIncomplete("addToList should now fail to avoid dupes");
		$result = $this->Model->addToList($data);
		$this->assertFalse($result);

		$this->assertTrue($this->Model->delete($id));
		$data[$this->Model->alias]['shop_list_id'] = 'shop-list-sally-cart';
		$id = $this->Model->addToList($data);
		$this->assertTrue((bool)$id);

		$this->assertTrue($this->Model->delete($id));
		$data[$this->Model->alias]['quantity'] = 0;
		$id = $this->Model->addToList($data);
		$this->assertFalse((bool)$id);
	}

	public function testFindCurrentList() {
		$expected = array(

		);
		$result = $this->Model->find('currentList');
		$this->assertEquals($expected, $result);

		CakeSession::write('Auth.User.id', 'bob');
		$expected = array(
			array(
				'ShopListProduct' => array(
					'id' => 'shop-list-bob-cart-active',
					'quantity' => '1.00000',
				),
				'ShopProduct' => array(
					'id' => 'active',
					'name' => 'active',
					'slug' => 'active',
				),
				'ShopCategory' => array(
					'id' => 'active',
					'name' => 'active',
					'slug' => 'active',
				),
			),
			array(
				'ShopListProduct' => array(
					'id' => 'shop-list-bob-cart-multi-option1',
					'quantity' => '1.00000',
				),
				'ShopProduct' => array(
					'id' => 'multi-option',
					'name' => 'multi-option',
					'slug' => 'multi-option',
				),
				'ShopCategory' => array(
					'id' => 'active',
					'name' => 'active',
					'slug' => 'active',
				),
			),
			array(
				'ShopListProduct' => array(
					'id' => 'shop-list-bob-cart-multi-option2',
					'quantity' => '2.00000',
				),
				'ShopProduct' => array(
					'id' => 'multi-option',
					'name' => 'multi-option',
					'slug' => 'multi-option',
				),
				'ShopCategory' => array(
					'id' => 'active',
					'name' => 'active',
					'slug' => 'active',
				),
			),
		);
		$result = $this->Model->find('currentList');
		$this->assertEquals($expected, $result);
	}

/**
 * test delete product from a list
 */
	public function testDelete() {
		$result = $this->Model->delete('shop-list-bob-cart-active');
		$this->assertFalse($result);

		$expected = array(
			'shop-list-bob-cart-active' => 'shop-list-bob-cart-active',
			'shop-list-bob-cart-multi-option1' => 'shop-list-bob-cart-multi-option1',
			'shop-list-bob-cart-multi-option2' => 'shop-list-bob-cart-multi-option2',
			'shop-list-guest-1' => 'shop-list-guest-1',
			'shop-list-sally' => 'shop-list-sally'
		);
		$result = $this->Model->find('list');
		$this->assertEquals($expected, $result);

		CakeSession::write('Auth.User.id', 'bob');
		$result = $this->Model->delete('shop-list-bob-cart-active');
		$this->assertTrue($result);

		$expected = array(
			'shop-list-bob-cart-multi-option1' => 'shop-list-bob-cart-multi-option1',
			'shop-list-bob-cart-multi-option2' => 'shop-list-bob-cart-multi-option2',
			'shop-list-guest-1' => 'shop-list-guest-1',
			'shop-list-sally' => 'shop-list-sally'
		);
		$result = $this->Model->find('list');
		$this->assertEquals($expected, $result);

		$result = $this->Model->delete('shop-list-sally');
		$this->assertFalse($result);

		$result = $this->Model->find('list');
		$this->assertEquals($expected, $result);
	}
}

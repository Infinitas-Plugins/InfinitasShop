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
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_list',
		'plugin.shop.shop_product',
		'plugin.shop.shop_price',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_image',
		'plugin.shop.shop_products_option_value_override',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_brand',
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_products_option_ignore',
		'plugin.shop.shop_products_option_value_ignore',
		'plugin.shop.shop_size',

		'plugin.view_counter.view_counter_view',
		'plugin.installer.plugin'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopListProduct = ClassRegistry::init('Shop.ShopListProduct');
		$this->modelClass = $this->ShopListProduct->alias;
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

		$this->{$this->modelClass}->create();
		$result = $this->{$this->modelClass}->save($data);

		$this->assertEquals(empty($expected), (bool)$result);
		$this->assertEquals($expected, $this->{$this->modelClass}->validationErrors);
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
					'shop_product_id' => array('Please select a product to add to your list')
				)
			),
			'incorrect-product' => array(
				array(
					'shop_product_id' => 'made-up-product'
				),
				array(
					'shop_product_id' => array('The selected product does not exist'),
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('Unable to validate the ordered quantity')
				)
			),
			'invalid quantity' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => null
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('Please enter the quantity you would like to purchase'),
				)
			),
			'quantity too many' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => 11
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('The maximum purchase quantity is "10"'),
				)
			),
			'quantity too few' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => 1.5
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('The minimum purchase quantity is "2"'),
				)
			),
			'quantity incorrect units' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => 5.75
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('Quantity should be in multiples of "0.5"'),
				)
			),
			'correct units' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => 5
				),
				array(
					'shop_list_id' => array('The selected list could not be found')
				)
			),
			'correct units float' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => 2.5
				),
				array(
					'shop_list_id' => array('The selected list could not be found')
				)
			),
			'no stock' => array(
				array(
					'shop_product_id' => 'no-stock-added',
					'quantity' => 10
				),
				array(
					'shop_list_id' => array('The selected list could not be found'),
					'quantity' => array('That quantity is not available for the selected product')
				)
			),
			'correct list' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => 2.5,
					'shop_list_id' => 'shop-list-bob-cart'
				),
				array()
			),
			'other users list' => array(
				array(
					'shop_product_id' => 'active',
					'quantity' => 2.5,
					'shop_list_id' => 'shop-list-sally-cart'
				),
				array(
					'shop_list_id' => array('The selected list could not be found')
				)
			)
		);
	}
}

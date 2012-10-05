<?php
App::uses('ShopProduct', 'Shop.Model');

/**
 * ShopProduct Test Case
 *
 */
class ShopProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product',
		'plugin.shop.shop_image',
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_list',
		'plugin.shop.shop_product_size',
		'plugin.shop.shop_special',
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_price',
		'plugin.shop.shop_products_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',

		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProduct = ClassRegistry::init('Shop.ShopProduct');

		$this->modelClass = 'ShopProduct';
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
 * @brief test when no product is passed
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindProductException() {
		$this->{$this->modelClass}->find('product');
	}

	/**
 * @brief test inactive products are not found
 *
 * @expectedException CakeException
 * @dataProvider findProductInactiveDataProvider
 */
	public function testFindProductInactive($data) {
		$this->{$this->modelClass}->find('product', $data);
	}

/**
 * @brief data provider for finding on inactive products
 *
 * @return arra
 */
	public function findProductInactiveDataProvider() {
		return array(
			array('inactive'),
			array('inactive-category'),
			array('inactive-parent'),
			array('missing-product-does-not-exist')
		);
	}

/**
 * @brief test find products
 *
 * @dataProvider findProductDataProvider
 */
	public function testFindProduct($data, $expected) {
		$result = $this->{$this->modelClass}->find('product', $data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find products data provider
 */
	public function findProductDataProvider() {
		return array(
			'active' => array(
				'active',
				array(
					'ShopProduct' => array(
						'id' => 'active',
						'slug' => 'active',
						'name' => 'active'
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active'
					)),
					'ShopPrice' => array(
						'id' => 'active',
						'selling' => '12.00000',
						'retail' => '15.00000'
					),
					'ShopOption' => array(array(
						'id' => 'option-size',
						'name' => 'Size',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'Large',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'Medium',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-small',
								'name' => 'Small',
								'shop_option_id' => 'option-size'
							),
						)
					))
				)
			),
			'multi-category' => array(
				'multi-category',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category',
						'slug' => 'multi-category',
						'name' => 'multi-category'
					),
					'ShopCategory' => array(array(
						'id' => 'another',
						'name' => 'another',
						'slug' => 'another'
					), array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active'
					)),
					'ShopPrice' => array(
						'id' => 'multi-category',
						'selling' => '6.00000',
						'retail' => '7.00000'
					),
					'ShopOption' => array()
				)
			),
			'mixed-state' => array(
				'multi-category-mixed-state',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category-mixed-state',
						'slug' => 'multi-category-mixed-state',
						'name' => 'multi-category-mixed-state'
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active'
					)),
					'ShopPrice' => array(
						'id' => 'multi-category-mixed-state',
						'selling' => '12.00000',
						'retail' => '15.00000'
					),
					'ShopOption' => array()
				)
			),
			'mixed-state-parent-inactive' => array(
				'multi-category-parent-inactive',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category-parent-inactive',
						'slug' => 'multi-category-parent-inactive',
						'name' => 'multi-category-parent-inactive'
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active'
					)),
					'ShopPrice' => array(
						'id' => 'multi-category-parent-inactive',
						'selling' => '12.00000',
						'retail' => '15.00000'
					),
					'ShopOption' => array()
				)
			),

			'multi-option' => array(
				'multi-option',
				array(
					'ShopProduct' => array(
						'id' => 'multi-option',
						'slug' => 'multi-option',
						'name' => 'multi-option'
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active'
					)),
					'ShopPrice' => array(
						'id' => 'multi-option',
						'selling' => '25.00000',
						'retail' => '30.00000'
					),
					'ShopOption' => array(array(
						'id' => 'option-size',
						'name' => 'Size',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'Large',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'Medium',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-small',
								'name' => 'Small',
								'shop_option_id' => 'option-size'
							))), array(
						'id' => 'option-colour',
						'name' => 'Colour',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-colour-blue',
								'name' => 'Blue',
								'shop_option_id' => 'option-colour'
							),
							array(
								'id' => 'option-colour-red',
								'name' => 'Red',
								'shop_option_id' => 'option-colour'
							)))
					)
				)
			),
		);
	}

/**
 * @brief test product options
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider productOptionsDataProvider
 */
	public function atestProductOptions($data, $expected) {
		$result = $this->{$this->modelClass}->find('product', $data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief data provider for the options test
 *
 * @return array
 */
	public function productOptionsDataProvider() {
		return array(
			array(
				'',
				''
			)
		);
	}

}

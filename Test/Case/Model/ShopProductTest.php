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
		'plugin.shop.shop_unit',
		'plugin.shop.shop_unit_type',

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
 * @brief find paginated
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findPaginatedDataProvider
 */
	public function testFindPaginated($data, $expected) {
		$result = $this->{$this->modelClass}->find('paginated', $data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find paginated data provider
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
					array(
						'ShopProduct' => array(
							'id' => 'active',
							'slug' => 'active',
							'name' => 'active',
							'total_stock' => 25
						),
						'ShopPrice' => array(
							'id' => 'active',
							'selling' => '12.00000',
							'retail' => '15.00000'
						),
						'ShopCategory' => array(array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'shop_product_id' => 'active'
						)),
						'ShopOption' => array(array(
							'id' => 'option-size',
							'name' => 'Size',
							'shop_product_id' => 'active',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'Large',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
									)
								),
								array(
									'id' => 'option-size-medium',
									'name' => 'Medium',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								),
								array(
									'id' => 'option-size-small',
									'name' => 'Small',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								),
							)
						))
					)
				)
			)
		);
	}

/**
 * @brief test find wrapper methods
 *
 * @param type $data
 * @param type $expected
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
 * @expectedException InvalidArgumentException
 *
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
						'name' => 'active',
						'total_stock' => '25'
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'active'
					)),
					'ShopPrice' => array(
						'id' => 'active',
						'selling' => '12.00000',
						'retail' => '15.00000'
					),
					'ShopOption' => array(array(
						'id' => 'option-size',
						'name' => 'Size',
						'shop_product_id' => 'active',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'Large',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
								)
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'Medium',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							),
							array(
								'id' => 'option-size-small',
								'name' => 'Small',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							),
						)
					)),
					'ShopBranchStock' => array(
						array(
							'id' => 'branch-stock-1',
							'shop_branch_id' => 'branch-1',
							'stock' => '10'
						),
						array(
							'id' => 'branch-stock-2',
							'shop_branch_id' => 'branch-2',
							'stock' => '15'
						)
					),
					'ShopProductSize' => array(
						array(
							'id' => 'active-product-weight',
							'value' => '100.000',
							'symbol' => 'g',
							'ShopUnit' => array(
								'id' => 'product-weight',
								'name' => 'product-weight',
								'slug' => 'product-weight',
								'shop_unit_type_id' => 'mass'
							)
						),
						array(
							'id' => 'active-ship-weight',
							'value' => '200.000',
							'symbol' => 'g',
							'ShopUnit' => array(
								'id' => 'ship-weight',
								'name' => 'ship-weight',
								'slug' => 'ship-weight',
								'shop_unit_type_id' => 'mass'
							)
						)
					)
				)
			),
			'multi-category' => array(
				'multi-category',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category',
						'slug' => 'multi-category',
						'name' => 'multi-category',
						'total_stock' => null
					),
					'ShopCategory' => array(array(
						'id' => 'another',
						'name' => 'another',
						'slug' => 'another',
						'shop_product_id' => 'multi-category'
					), array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'multi-category'
					)),
					'ShopPrice' => array(
						'id' => 'multi-category',
						'selling' => '6.00000',
						'retail' => '7.00000'
					),
					'ShopOption' => array(),
					'ShopBranchStock' => array(),
					'ShopProductSize' => array()
				)
			),
			'mixed-state' => array(
				'multi-category-mixed-state',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category-mixed-state',
						'slug' => 'multi-category-mixed-state',
						'name' => 'multi-category-mixed-state',
						'total_stock' => null
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'multi-category-mixed-state'
					)),
					'ShopPrice' => array(
						'id' => 'multi-category-mixed-state',
						'selling' => '12.00000',
						'retail' => '15.00000'
					),
					'ShopOption' => array(),
					'ShopBranchStock' => array(),
					'ShopProductSize' => array()
				)
			),
			'mixed-state-parent-inactive' => array(
				'multi-category-parent-inactive',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category-parent-inactive',
						'slug' => 'multi-category-parent-inactive',
						'name' => 'multi-category-parent-inactive',
						'total_stock' => null
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'multi-category-parent-inactive'
					)),
					'ShopPrice' => array(
						'id' => 'multi-category-parent-inactive',
						'selling' => '12.00000',
						'retail' => '15.00000'
					),
					'ShopOption' => array(),
					'ShopBranchStock' => array(),
					'ShopProductSize' => array()
				)
			),

			'multi-option' => array(
				'multi-option',
				array(
					'ShopProduct' => array(
						'id' => 'multi-option',
						'slug' => 'multi-option',
						'name' => 'multi-option',
						'total_stock' => null
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'multi-option'
					)),
					'ShopPrice' => array(
						'id' => 'multi-option',
						'selling' => '25.00000',
						'retail' => '30.00000'
					),
					'ShopOption' => array(array(
						'id' => 'option-size',
						'name' => 'Size',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'Large',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
								)
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'Medium',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							),
							array(
								'id' => 'option-size-small',
								'name' => 'Small',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							))), array(
						'id' => 'option-colour',
						'name' => 'Colour',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-colour-blue',
								'name' => 'Blue',
								'shop_option_id' => 'option-colour',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							),
							array(
								'id' => 'option-colour-red',
								'name' => 'Red',
								'shop_option_id' => 'option-colour',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							)))
					),
					'ShopBranchStock' => array(),
					'ShopProductSize' => array()
				)
			),
		);
	}

}

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
		'plugin.shop.shop_branch',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_list',
		'plugin.shop.shop_product_size',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_special',
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_price',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_unit',
		'plugin.shop.shop_unit_type',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_products_option_ignore',
		'plugin.shop.shop_products_option_value_ignore',

		'plugin.view_counter.view_counter_view',
		'plugin.management.trash',
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
 * @brief find paginated
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findPaginatedDataProvider
 */
	public function testFindPaginated($data, $expected) {
		foreach($expected as &$v) {
			$v = array_merge(
				array(
					'ShopProductType' => array('id' => null, 'name' => null, 'slug' => null),
					'ShopImage' => array('id' => null, 'image' => null),
					'ShopSpecial' => array(),
					'ShopSpotlight' => array(),
				),
				$v
			);
		}
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
						'ShopProductType' => array(
							'id' => 'shirts',
							'name' => 'shirts',
							'slug' => 'shirts'
						),
						'ShopImage' => array(
							'id' => 'image-product-active',
							'image' => 'image-product-active.png'
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
							'name' => 'option-size',
							'shop_product_id' => 'active',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'option-size-large',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
									)
								),
								array(
									'id' => 'option-size-medium',
									'name' => 'option-size-medium',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								),
								array(
									'id' => 'option-size-small',
									'name' => 'option-size-small',
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
 * @brief test find products
 *
 * @dataProvider findProductDataProvider
 */
	public function testFindProduct($data, $expected) {
		if(!empty($expected)) {
			$expected = array_merge(
				array(
					'ShopProductType' => array('id' => null, 'name' => null, 'slug' => null),
					'ShopImage' => array('id' => null, 'image' => null),
					'ShopBranchStock' => array(),
					'ShopProductSize' => array(),
					'ShopSpecial' => array(),
					'ShopSpotlight' => array(),
					'ShopImagesProduct' => array(),
					'ShopOption' => array()
				),
				$expected
			);
		}
		$result = $this->{$this->modelClass}->find('product', $data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find products data provider
 */
	public function findProductDataProvider() {
		return array(
			'made-up' => array(
				'made-up',
				array()
			),
			'active' => array(
				'active',
				array(
					'ShopProduct' => array(
						'id' => 'active',
						'slug' => 'active',
						'name' => 'active',
						'product_code' => null,
						'total_stock' => '25'
					),
					'ShopProductType' => array(
						'id' => 'shirts',
						'name' => 'shirts',
						'slug' => 'shirts'
					),
					'ShopImage' => array(
						'id' => 'image-product-active',
						'image' => 'image-product-active.png'
					),
					'ShopImagesProduct' => array(
						array(
							'id' => 'shared-image-1',
							'image' => 'shared-image-1.png',
							'shop_product_id' => 'active'
						),
						array(
							'id' => 'shared-image-2',
							'image' => 'shared-image-2.png',
							'shop_product_id' => 'active'
						)
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
						'name' => 'option-size',
						'shop_product_id' => 'active',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
								)
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'option-size-medium',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							),
							array(
								'id' => 'option-size-small',
								'name' => 'option-size-small',
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
						'product_code' => null,
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
					'ShopImagesProduct' => array(
						array(
							'id' => 'shared-image-2',
							'image' => 'shared-image-2.png',
							'shop_product_id' => 'multi-category'
						)
					)
				)
			),
			'mixed-state' => array(
				'multi-category-mixed-state',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category-mixed-state',
						'slug' => 'multi-category-mixed-state',
						'name' => 'multi-category-mixed-state',
						'product_code' => null,
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
					)
				)
			),
			'mixed-state-parent-inactive' => array(
				'multi-category-parent-inactive',
				array(
					'ShopProduct' => array(
						'id' => 'multi-category-parent-inactive',
						'slug' => 'multi-category-parent-inactive',
						'name' => 'multi-category-parent-inactive',
						'product_code' => null,
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
					)
				)
			),

			'multi-option' => array(
				'multi-option',
				array(
					'ShopProduct' => array(
						'id' => 'multi-option',
						'slug' => 'multi-option',
						'name' => 'multi-option',
						'product_code' => null,
						'total_stock' => null
					),
					'ShopProductType' => array(
						'id' => 'complex-options',
						'name' => 'complex-options',
						'slug' => 'complex-options'
					),
					'ShopImage' => array(
						'id' => 'image-product-multi-option',
						'image' => 'image-product-multi-option.png'
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
						'name' => 'option-size',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
								)
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'option-size-medium',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							),
							array(
								'id' => 'option-size-small',
								'name' => 'option-size-small',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							))), array(
						'id' => 'option-colour',
						'name' => 'option-colour',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-colour-blue',
								'name' => 'option-colour-blue',
								'shop_option_id' => 'option-colour',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							),
							array(
								'id' => 'option-colour-red',
								'name' => 'option-colour-red',
								'shop_option_id' => 'option-colour',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							)))
					),
					'ShopSpecial' => array(
						array(
							'id' => 'special-multi-option',
							'shop_product_id' => 'multi-option',
							'discount' => 10,
							'amount' => null,
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
							'ShopImage' => array(
								'id' => 'image-special-multi-option',
								'image' => 'image-special-multi-option.png'
							)
						)
					),
					'ShopSpotlight' => array(
						array(
							'id' => 'spotlight-multi-option',
							'shop_product_id' => 'multi-option',
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
							'ShopImage' => array(
								'id' => 'image-spotlight-multi-option',
								'image' => 'image-spotlight-multi-option.png'
							)
						)
					)
				)
			),
		);
	}

/**
 * @brief test deleting a product removes related data
 */
	public function testProductDeleteRelations() {
		$relations = array(
			'ShopBranchStock',
			'ShopCategoriesProduct',
			'ShopImagesProduct',
			'ShopList',
			'ShopProductSize',
			'ShopSpotlight',
			'ShopSpecial'
		);
		$this->{$this->modelClass}->Behaviors->disable('Trashable');

		foreach($relations as $relation) {
			$this->{$this->modelClass}->{$relation}->Behaviors->disable('Trashable');
		}

		$this->assertTrue($this->{$this->modelClass}->delete('active'));
		$expected = array();

		foreach($relations as $relation) {
			$result = $this->{$this->modelClass}->{$relation}->find('list', array(
				'conditions' => array(
					$relation . '.shop_product_id' => 'active'
				)
			));
			$this->assertEquals($expected, $result, sprintf('%s relation has not been cleared', $relation));
		}
	}

}

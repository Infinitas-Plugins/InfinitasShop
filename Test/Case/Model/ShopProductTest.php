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
		'plugin.shop.shop_size',
		'plugin.shop.shop_image',
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_branch',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_special',
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_price',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_list',
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_products_option_ignore',
		'plugin.shop.shop_products_option_value_ignore',
		'plugin.shop.shop_products_option_value_override',

		'plugin.shop.core_user',
		'plugin.shop.core_group',

		'plugin.view_counter.view_counter_view',
		'plugin.management.trash',
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
 * @brief find paginated
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findPaginatedDataProvider
 */
	public function testFindPaginated($data, $expected) {
		foreach($expected as &$v) {
			foreach($v['ShopOption'] as &$option) {
				foreach($option['ShopOptionValue'] as &$vv) {
					$vv = array_merge(
						array(
							'ShopSize' => array(
								'id' => null,
								'model' => null,
								'foreign_key' => null,
								'product_width' => null,
								'product_height' => null,
								'product_length' => null,
								'shipping_width' => null,
								'shipping_height' => null,
								'shipping_length' => null,
								'product_weight' => null,
								'shipping_weight' => null,
							)
						),
						$vv
					);
				}
			}

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
							'slug' => 'option-size',
							'description' => 'some descriptive text about option-size',
							'required' => '1',
							'shop_product_id' => 'active',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'option-size-large',
									'description' => 'some text about option-size-large',
									'product_code' => 'l',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
									),
									'ShopSize' => array(
										'id' => 'option-value-size-large',
										'model' => 'Shop.ShopOptionValue',
										'foreign_key' => 'option-size-large',
										'product_width' => '1.50000',
										'product_height' => '1.50000',
										'product_length' => '1.50000',
										'shipping_width' => '2.50000',
										'shipping_height' => '2.50000',
										'shipping_length' => '2.50000',
										'product_weight' => '50.00000',
										'shipping_weight' => '65.00000'
									)
								),
								array(
									'id' => 'option-size-medium',
									'name' => 'option-size-medium',
									'description' => 'some text about option-size-medium',
									'product_code' => 'm',
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
									'description' => 'some text about option-size-small',
									'product_code' => 's',
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
 * @brief test find product shipping
 *
 * @param array $data
 * @param array $expected
 *
 * @dataProvider findProductShippingDataProvider
 */
	public function testFindProductShipping($data, $expected) {
		$results = $this->{$this->modelClass}->find('productShipping', $data);
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find product shipping data provider
 *
 * @return array
 */
	public function findProductShippingDataProvider() {
		return array(
			'fake' => array(
				'fake',
				array(

				)
			),
			'active' => array(
				'active',
				array(
					'width' => 15.0,
					'height' => 15.0,
					'length' => 15.0,
					'weight' => 715.0,
					'cost' => 15.0
				)
			)
		);
	}

/**
 * @brief test find product shipping
 *
 * @param array $data
 * @param array $expected
 *
 * @dataProvider findProductListShippingDataProvider
 */
	public function testFindProductListShipping($data, $expected) {
		App::uses('CakeSession', 'Model/Datasource');
		if(isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if(isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
		$results = $this->{$this->modelClass}->find('prodcutListShipping', array(
			'shop_list_id' => $data
		));
		$this->assertEquals($expected, $results);
		CakeSession::destroy();
	}

/**
 * @brief find product shipping data provider
 *
 * @return array
 */
	public function findProductListShippingDataProvider() {
		return array(
			'shop-list-bob-cart' => array(
				array(
					'shop_list_id' => 'shop-list-bob-cart',
					'user_id' => 'bob'
				),
				array(
					'width' => 17.5,
					'height' => 17.5,
					'length' => 17.5,
					'weight' => 780.0,
					'cost' => 43.0
				)
			),
		);
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
					'ShopSpecial' => array(),
					'ShopSpotlight' => array(),
					'ShopImagesProduct' => array(),
					'ShopOption' => array(),
					'ShopProductCode' => array(),
					'ShopSize' => array(
						'id' => null,
						'model' => null,
						'foreign_key' => null,
						'product_width' => null,
						'product_height' => null,
						'product_length' => null,
						'shipping_width' => null,
						'shipping_height' => null,
						'shipping_length' => null,
						'product_weight' => null,
						'shipping_weight' => null,
					)
				),
				$expected
			);
			foreach($expected['ShopOption'] as &$option) {
				foreach($option['ShopOptionValue'] as &$vv) {
					$vv = array_merge(
						array(
							'ShopSize' => array(
								'id' => null,
								'model' => null,
								'foreign_key' => null,
								'product_width' => null,
								'product_height' => null,
								'product_length' => null,
								'shipping_width' => null,
								'shipping_height' => null,
								'shipping_length' => null,
								'product_weight' => null,
								'shipping_weight' => null,
							)
						),
						$vv
					);
				}
			}
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
						'product_code' => 'active-:option-size',
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
						'slug' => 'option-size',
						'description' => 'some descriptive text about option-size',
						'required' => '1',
						'shop_product_id' => 'active',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'description' => 'some text about option-size-large',
								'product_code' => 'l',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
								),
								'ShopSize' => array(
									'id' => 'option-value-size-large',
									'model' => 'Shop.ShopOptionValue',
									'foreign_key' => 'option-size-large',
									'product_width' => '1.50000',
									'product_height' => '1.50000',
									'product_length' => '1.50000',
									'shipping_width' => '2.50000',
									'shipping_height' => '2.50000',
									'shipping_length' => '2.50000',
									'product_weight' => '50.00000',
									'shipping_weight' => '65.00000'
								)
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'option-size-medium',
								'description' => 'some text about option-size-medium',
								'product_code' => 'm',
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
								'description' => 'some text about option-size-small',
								'product_code' => 's',
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
					'ShopProductCode' => array(
						array(
							'product_code' => 'active-l',
						),
						array(
							'product_code' => 'active-m',
						),
						array(
							'product_code' => 'active-s',
						)
					),
					'ShopSize' => array(
						'id' => 'product-active',
						'model' => 'Shop.ShopProduct',
						'foreign_key' => 'active',
						'product_width' => '10.50000',
						'product_height' => '10.50000',
						'product_length' => '10.50000',
						'shipping_width' => '12.50000',
						'shipping_height' => '12.50000',
						'shipping_length' => '12.50000',
						'product_weight' => '500.00000',
						'shipping_weight' => '650.00000'
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
						'product_code' => 'multi-option-:option-size(:option-colour)',
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
						'slug' => 'option-size',
						'description' => 'some descriptive text about option-size',
						'required' => '1',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'description' => 'some text about option-size-large',
								'product_code' => 'l',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
								),
								'ShopSize' => array(
									'id' => 'option-value-size-large',
									'model' => 'Shop.ShopOptionValue',
									'foreign_key' => 'option-size-large',
									'product_width' => '1.50000',
									'product_height' => '1.50000',
									'product_length' => '1.50000',
									'shipping_width' => '2.50000',
									'shipping_height' => '2.50000',
									'shipping_length' => '2.50000',
									'product_weight' => '50.00000',
									'shipping_weight' => '65.00000'
								)
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'option-size-medium',
								'description' => 'some text about option-size-medium',
								'product_code' => 'm',
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
								'description' => 'some text about option-size-small',
								'product_code' => 's',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
								)
							))), array(
						'id' => 'option-colour',
						'name' => 'option-colour',
						'slug' => 'option-colour',
						'description' => 'some descriptive text about option-colour',
						'required' => '0',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-colour-blue',
								'name' => 'option-colour-blue',
								'description' => 'some text about option-colour-blue',
								'product_code' => 'blue',
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
								'description' => 'some text about option-colour-red',
								'product_code' => 'red',
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
					),
					'ShopProductCode' => array(
						array(
							'product_code' => 'multi-option-l(blue)'
						),
						array(
							'product_code' => 'multi-option-l(red)'
						),
						array(
							'product_code' => 'multi-option-m(blue)'
						),
						array(
							'product_code' => 'multi-option-m(red)'
						),
						array(
							'product_code' => 'multi-option-s(blue)'
						),
						array(
							'product_code' => 'multi-option-s(red)'
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

/**
 * @brief test generating product codes
 *
 * @dataProvider productCodesDataProvider
 */
	public function testProductCodes($data, $expected) {
		$this->{$this->modelClass}->id = 'multi-option';
		$this->{$this->modelClass}->saveField('product_code', null);
		$result = $this->{$this->modelClass}->productCodes($data['product'], $data['options']);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief product code data provider
 *
 * @return array
 */
	public function productCodesDataProvider() {
		return array(
			'generate-from-db-by-id' => array(
				array(
					'product' => 'active',
					'options' => array()
				),
				array(
					array(
						'product_code' => 'active-l'
					),
					array(
						'product_code' => 'active-m'
					),
					array(
						'product_code' => 'active-s'
					)
				)
			),
			'options-from-db' => array(
				array(
					'product' => array(
						'id' => 'active',
						'product_code' => ':option-size'
					),
					'options' => array()
				),
				array(
					array(
						'product_code' => 'l'
					),
					array(
						'product_code' => 'm'
					),
					array(
						'product_code' => 's'
					)
				)
			),
			'passed-in-options' => array(
				array(
					'product' => array(
						'id' => 'active',
						'product_code' => 'active-:option-size'
					),
					'options' => array(array(
						'id' => 'option-size',
						'name' => 'option-size',
						'slug' => 'option-size',
						'shop_product_id' => 'active',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'product_code' => 'lar',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'option-size-medium',
								'product_code' => 'med',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-small',
								'name' => 'option-size-small',
								'product_code' => 'sma',
								'shop_option_id' => 'option-size'
							),
						)
					))
				),
				array(
					array(
						'product_code' => 'active-lar'
					),
					array(
						'product_code' => 'active-med'
					),
					array(
						'product_code' => 'active-sma'
					)
				)
			),
			'append-codes' => array(
				array(
					'product' => array(
						'id' => 'active',
						'product_code' => 'active-product'
					),
					'options' => array()
				),
				array(
					array(
						'product_code' => 'active-product-l'
					),
					array(
						'product_code' => 'active-product-m'
					),
					array(
						'product_code' => 'active-product-s'
					)
				)
			),
			'null-main-code' => array(
				array(
					'product' => array(
						'id' => 'out-of-stock',
						'product_code' => null
					),
					'options' => array(array(
						'id' => 'option-size',
						'name' => 'option-size',
						'slug' => 'option-size',
						'shop_product_id' => 'out-of-stock',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'product_code' => 'lar',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'option-size-medium',
								'product_code' => 'med',
								'shop_option_id' => 'option-size'
							),
							array(
								'id' => 'option-size-small',
								'name' => 'option-size-small',
								'product_code' => 'sma',
								'shop_option_id' => 'option-size'
							),
						)
					))
				),
				array(
					array(
						'product_code' => 'lar'
					),
					array(
						'product_code' => 'med'
					),
					array(
						'product_code' => 'sma'
					)
				)
			),
			'null-main-code-no-options' => array(
				array(
					'product' => array(
						'id' => 'out-of-stock',
						'product_code' => null
					),
					'options' => array()
				),
				array(
				)
			),
			'multi-option-append-codes' => array(
				array(
					'product' => array(
						'id' => 'multi-option',
						'product_code' => 'multi-option'
					),
					'options' => array()
				),
				array(
					array(
						'product_code' => 'multi-option-lblue'
					),
					array(
						'product_code' => 'multi-option-lred'
					),
					array(
						'product_code' => 'multi-option-mblue'
					),
					array(
						'product_code' => 'multi-option-mred'
					),
					array(
						'product_code' => 'multi-option-sblue'
					),
					array(
						'product_code' => 'multi-option-sred'
					),
				)
			),
			'multi-option-null-main-code' => array(
				array(
					'product' => array(
						'id' => 'multi-option',
						'product_code' => null
					),
					'options' => array()
				),
				array(
					array(
						'product_code' => 'lblue'
					),
					array(
						'product_code' => 'lred'
					),
					array(
						'product_code' => 'mblue'
					),
					array(
						'product_code' => 'mred'
					),
					array(
						'product_code' => 'sblue'
					),
					array(
						'product_code' => 'sred'
					),
				)
			),
		);
	}

/**
 * @brief test find products for list
 *
 * @dataProvider  findProductsForListDataProvider
 */
	public function testFindProductsForList($data, $expected) {
		App::uses('CakeSession', 'Model/Datasource');
		if(isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if(isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
		$result = $this->{$this->modelClass}->find('productsForList', array(
			'shop_list_id' => $data['shop_list_id']
		));
		$this->assertEquals($expected, $result);

		CakeSession::destroy();
	}

/**
 * @brief find products for list data provider
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
					array(
						'ShopProduct' => array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'product_code' => 'active-:option-size',
							'total_stock' => '25',
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
						'ShopSize' => array(
							'shipping_width' => '12.50000',
							'shipping_height' => '12.50000',
							'shipping_length' => '12.50000',
							'shipping_weight' => '650.00000',
						),
						'ShopListProduct' => array(
							'id' => 'shop-list-bob-cart-active',
							'shop_list_id' => 'shop-list-bob-cart',
							'shop_product_id' => 'active',
							'quantity' => '1.00000'
						),
						'ShopOption' => array(
							array(
								'id' => 'option-size',
								'name' => 'option-size',
								'slug' => 'option-size',
								'description' => 'some descriptive text about option-size',
								'required' => '1',
								'shop_product_id' => 'active',
								'ShopOptionValue' => array(
									array(
										'id' => 'option-size-large',
										'name' => 'option-size-large',
										'description' => 'some text about option-size-large',
										'product_code' => 'l',
										'shop_option_id' => 'option-size',
										'ShopPrice' => array(
											'id' => 'option-value-large',
											'selling' => '3.00000',
											'retail' => '4.00000'
										),
										'ShopSize' => array(
											'id' => 'option-value-size-large',
											'model' => 'Shop.ShopOptionValue',
											'foreign_key' => 'option-size-large',
											'product_width' => '1.50000',
											'product_height' => '1.50000',
											'product_length' => '1.50000',
											'shipping_width' => '2.50000',
											'shipping_height' => '2.50000',
											'shipping_length' => '2.50000',
											'product_weight' => '50.00000',
											'shipping_weight' => '65.00000'
										)
									)
								)
							)
						)
					),
					array(
						'ShopProduct' => array(
							'id' => 'multi-option',
							'name' => 'multi-option',
							'slug' => 'multi-option',
							'product_code' => 'multi-option-:option-size(:option-colour)',
							'total_stock' => null,
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
						'ShopPrice' => array(
							'id' => 'multi-option',
							'selling' => '25.00000',
							'retail' => '30.00000'
						),
						'ShopCategory' => array(array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'shop_product_id' => 'multi-option'
						)),
						'ShopSize' => array(
							'shipping_width' => null,
							'shipping_height' => null,
							'shipping_length' => null,
							'shipping_weight' => null,
						),
						'ShopListProduct' => array(
							'id' => 'shop-list-bob-cart-multi-option',
							'shop_list_id' => 'shop-list-bob-cart',
							'shop_product_id' => 'multi-option',
							'quantity' => '1.00000'
						),
						'ShopOption' => array(
							array(
								'id' => 'option-size',
								'name' => 'option-size',
								'slug' => 'option-size',
								'description' => 'some descriptive text about option-size',
								'required' => '1',
								'shop_product_id' => 'multi-option',
								'ShopOptionValue' => array(
									array(
										'id' => 'option-size-large',
										'name' => 'option-size-large',
										'description' => 'some text about option-size-large',
										'product_code' => 'l',
										'shop_option_id' => 'option-size',
										'ShopPrice' => array(
											'id' => 'option-value-large',
											'selling' => '3.00000',
											'retail' => '4.00000'
										),
										'ShopSize' => array(
											'id' => 'option-value-size-large',
											'model' => 'Shop.ShopOptionValue',
											'foreign_key' => 'option-size-large',
											'product_width' => '1.50000',
											'product_height' => '1.50000',
											'product_length' => '1.50000',
											'shipping_width' => '2.50000',
											'shipping_height' => '2.50000',
											'shipping_length' => '2.50000',
											'product_weight' => '50.00000',
											'shipping_weight' => '65.00000'
										)
									)
								)
							),
							array(
								'id' => 'option-colour',
								'name' => 'option-colour',
								'slug' => 'option-colour',
								'description' => 'some descriptive text about option-colour',
								'required' => '0',
								'shop_product_id' => 'multi-option',
								'ShopOptionValue' => array(
								)
							)
						)
					)
				)
			)
		);
	}

}

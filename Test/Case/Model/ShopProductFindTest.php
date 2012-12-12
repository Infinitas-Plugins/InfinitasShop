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
		'plugin.shop.shop_special',
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_price',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
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
		foreach ($expected as &$v) {
			foreach ($v['ShopOption'] as &$option) {
				foreach ($option['ShopOptionValue'] as &$vv) {
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
					array(
						'ShopProduct' => array(
							'id' => 'active',
							'slug' => 'active',
							'name' => 'active',
							'total_stock' => 25,
							'rating' => 1,
							'rating_count' => 1,
							'views' => 5,
							'sales' => 1,
							'active' => true,
							'description' => 'active desc'
						),
						'ShopBrand' => array(
							'id' => 'inhouse',
							'name' => 'inhouse',
							'slug' => 'inhouse'
						),
						'ShopProductType' => array(
							'id' => 'shirts',
							'name' => 'shirts',
							'slug' => 'shirts'
						),
						'ShopImage' => array(
							'id' => 'image-product-active',
							'image' => 'image-product-active.png',
							'image_full' => '/files/shop_image/image/image-product-active/image-product-active.png',
							'image_large' => '/files/shop_image/image/image-product-active/large_image-product-active.png',
							'image_medium' => '/files/shop_image/image/image-product-active/medium_image-product-active.png',
							'image_small' => '/files/shop_image/image/image-product-active/small_image-product-active.png',
							'image_thumb' => '/files/shop_image/image/image-product-active/thumb_image-product-active.png'
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
	}

/**
 * test find products
 *
 * @dataProvider findProductDataProvider
 */
	public function testFindProduct($data, $expected) {
		if (!empty($expected)) {
			$expected = array_merge(
				array(
					'ShopProductType' => array('id' => null, 'name' => null, 'slug' => null),
					'ShopImage' => array(
						'id' => null,
						'image' => null,
						'image_full' => '/filemanager/img/no-image.png',
						'image_large' => '/filemanager/img/no-image.png',
						'image_medium' => '/filemanager/img/no-image.png',
						'image_small' => '/filemanager/img/no-image.png',
						'image_thumb' => '/filemanager/img/no-image.png'
					),
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
			foreach ($expected['ShopOption'] as &$option) {
				foreach ($option['ShopOptionValue'] as &$vv) {
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
				array(
					'ShopProduct' => array(
						'id' => 'active',
						'slug' => 'active',
						'name' => 'active',
						'product_code' => 'active-:option-size',
						'total_stock' => '25',
						'rating' => 1,
						'rating_count' => 1,
						'views' => 5,
						'sales' => 1,
						'active' => true,
						'description' => 'active desc',
						'specifications' => 'active specs',
						'available' => '2012-10-05 01:14:47',
						'quantity_unit' => 0.5,
						'quantity_min' => 2,
						'quantity_max' => 10
					),
					'ShopProductType' => array(
						'id' => 'shirts',
						'name' => 'shirts',
						'slug' => 'shirts'
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse'
					),
					'ShopImage' => array(
						'id' => 'image-product-active',
						'image' => 'image-product-active.png',
						'image_full' => '/files/shop_image/image/image-product-active/image-product-active.png',
						'image_large' => '/files/shop_image/image/image-product-active/large_image-product-active.png',
						'image_medium' => '/files/shop_image/image/image-product-active/medium_image-product-active.png',
						'image_small' => '/files/shop_image/image/image-product-active/small_image-product-active.png',
						'image_thumb' => '/files/shop_image/image/image-product-active/thumb_image-product-active.png'
					),
					'ShopImagesProduct' => array(
						array(
							'id' => 'shared-image-1',
							'image' => 'shared-image-1.png',
							'shop_product_id' => 'active',
							'image_full' => '/files/shop_image/image/shared-image-1/shared-image-1.png',
							'image_large' => '/files/shop_image/image/shared-image-1/large_shared-image-1.png',
							'image_medium' => '/files/shop_image/image/shared-image-1/medium_shared-image-1.png',
							'image_small' => '/files/shop_image/image/shared-image-1/small_shared-image-1.png',
							'image_thumb' => '/files/shop_image/image/shared-image-1/thumb_shared-image-1.png'
						),
						array(
							'id' => 'shared-image-2',
							'image' => 'shared-image-2.png',
							'shop_product_id' => 'active',
							'image_full' => '/files/shop_image/image/shared-image-2/shared-image-2.png',
							'image_large' => '/files/shop_image/image/shared-image-2/large_shared-image-2.png',
							'image_medium' => '/files/shop_image/image/shared-image-2/medium_shared-image-2.png',
							'image_small' => '/files/shop_image/image/shared-image-2/small_shared-image-2.png',
							'image_thumb' => '/files/shop_image/image/shared-image-2/thumb_shared-image-2.png'
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
						'total_stock' => null,
						'rating' => 1,
						'rating_count' => 1,
						'views' => 30,
						'sales' => 100,
						'active' => true,
						'description' => 'multi-category desc',
						'specifications' => 'multi-category specs',
						'available' => '2012-10-05 01:14:47',
						'quantity_unit' => 1,
						'quantity_min' => 1,
						'quantity_max' => null
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse'
					),
					'ShopCategory' => array(array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'multi-category'
					), array(
						'id' => 'another',
						'name' => 'another',
						'slug' => 'another',
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
							'shop_product_id' => 'multi-category',
							'image_full' => '/files/shop_image/image/shared-image-2/shared-image-2.png',
							'image_large' => '/files/shop_image/image/shared-image-2/large_shared-image-2.png',
							'image_medium' => '/files/shop_image/image/shared-image-2/medium_shared-image-2.png',
							'image_small' => '/files/shop_image/image/shared-image-2/small_shared-image-2.png',
							'image_thumb' => '/files/shop_image/image/shared-image-2/thumb_shared-image-2.png'
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
						'total_stock' => null,
						'rating' => 1,
						'rating_count' => 1,
						'views' => 20,
						'sales' => 1,
						'active' => true,
						'description' => 'multi-category-mixed-state desc',
						'specifications' => 'multi-category-mixed-state specs',
						'available' => '2012-10-05 01:14:47',
						'quantity_unit' => 1,
						'quantity_min' => 1,
						'quantity_max' => null
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse'
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
						'total_stock' => null,
						'rating' => 1,
						'rating_count' => 1,
						'views' => 1,
						'sales' => 1,
						'active' => true,
						'description' => 'multi-category-parent-inactive desc',
						'specifications' => 'multi-category-parent-inactive specs',
						'available' => '2012-10-05 01:14:47',
						'quantity_unit' => 1,
						'quantity_min' => 1,
						'quantity_max' => null
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse'
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
						'total_stock' => null,
						'rating' => 1,
						'rating_count' => 1,
						'views' => 100,
						'sales' => 25,
						'active' => true,
						'description' => 'multi-option desc',
						'specifications' => 'multi-option specs',
						'available' => '2012-10-05 01:14:47',
						'quantity_unit' => 1,
						'quantity_min' => 1,
						'quantity_max' => null
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse'
					),
					'ShopProductType' => array(
						'id' => 'complex-options',
						'name' => 'complex-options',
						'slug' => 'complex-options'
					),
					'ShopImage' => array(
						'id' => 'image-product-multi-option',
						'image' => 'image-product-multi-option.png',
						'image_full' => '/files/shop_image/image/image-product-multi-option/image-product-multi-option.png',
						'image_large' => '/files/shop_image/image/image-product-multi-option/large_image-product-multi-option.png',
						'image_medium' => '/files/shop_image/image/image-product-multi-option/medium_image-product-multi-option.png',
						'image_small' => '/files/shop_image/image/image-product-multi-option/small_image-product-multi-option.png',
						'image_thumb' => '/files/shop_image/image/image-product-multi-option/thumb_image-product-multi-option.png'
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
							'discount' => true,
							'amount' => 10,
							'free_shipping' => false,
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59'
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
								'image' => 'image-spotlight-multi-option.png',
								'image_full' => '/files/shop_image/image/image-spotlight-multi-option/image-spotlight-multi-option.png',
								'image_large' => '/files/shop_image/image/image-spotlight-multi-option/large_image-spotlight-multi-option.png',
								'image_medium' => '/files/shop_image/image/image-spotlight-multi-option/medium_image-spotlight-multi-option.png',
								'image_small' => '/files/shop_image/image/image-spotlight-multi-option/small_image-spotlight-multi-option.png',
								'image_thumb' => '/files/shop_image/image/image-spotlight-multi-option/thumb_image-spotlight-multi-option.png'
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

	public function testFindProductsForListDefault() {
		CakeSession::write('Auth.User.id', 'bob');
		CakeSession::write('Shop.current_list', 'shop-list-bob-cart');

		$expected = $this->findProductsForListDataProvider();
		$expected = end($expected['bob-cart']);
		$result = $this->{$this->modelClass}->find('productsForList');
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
					array(
						'ShopProduct' => array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'product_code' => 'active-l',
							'total_stock' => '25',
							'rating' => 1,
							'rating_count' => 1,
							'views' => 5,
							'sales' => 1,
							'active' => true
						),
						'ShopBrand' => array(
							'id' => 'inhouse',
							'name' => 'inhouse',
							'slug' => 'inhouse'
						),
						'ShopProductType' => array(
							'id' => 'shirts',
							'name' => 'shirts',
							'slug' => 'shirts'
						),
						'ShopImage' => array(
							'id' => 'image-product-active',
							'image' => 'image-product-active.png',
							'image_full' => '/files/shop_image/image/image-product-active/image-product-active.png',
							'image_large' => '/files/shop_image/image/image-product-active/large_image-product-active.png',
							'image_medium' => '/files/shop_image/image/image-product-active/medium_image-product-active.png',
							'image_small' => '/files/shop_image/image/image-product-active/small_image-product-active.png',
							'image_thumb' => '/files/shop_image/image/image-product-active/thumb_image-product-active.png'
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
							'rating' => 1,
							'rating_count' => 1,
							'views' => 100,
							'sales' => 25,
							'active' => true
						),
						'ShopBrand' => array(
							'id' => 'inhouse',
							'name' => 'inhouse',
							'slug' => 'inhouse'
						),
						'ShopProductType' => array(
							'id' => 'complex-options',
							'name' => 'complex-options',
							'slug' => 'complex-options'
						),
						'ShopImage' => array(
							'id' => 'image-product-multi-option',
							'image' => 'image-product-multi-option.png',
							'image_full' => '/files/shop_image/image/image-product-multi-option/image-product-multi-option.png',
							'image_large' => '/files/shop_image/image/image-product-multi-option/large_image-product-multi-option.png',
							'image_medium' => '/files/shop_image/image/image-product-multi-option/medium_image-product-multi-option.png',
							'image_small' => '/files/shop_image/image/image-product-multi-option/small_image-product-multi-option.png',
							'image_thumb' => '/files/shop_image/image/image-product-multi-option/thumb_image-product-multi-option.png'
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
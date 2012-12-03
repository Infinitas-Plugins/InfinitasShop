<?php
App::uses('ShopProduct', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopProductTest
 *
 * @package Shop.Test.Case
 */
class ShopProductTest extends CakeTestCase {

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
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_products_option_ignore',
		'plugin.shop.shop_products_option_value_ignore',
		'plugin.shop.shop_products_option_value_override',
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
 * test validation A
 */
	public function testValidationA() {
		$data = array();
		$expected = array(
			'name' => array('Please enter the name of this product'),
			'description' => array('Please enter the description for this product')
		);
		$result = $this->{$this->modelClass}->saveAll($data);
		$this->assertFalse($result);

		$this->assertEquals($expected, $this->{$this->modelClass}->validationErrors);
		$data = array('name' => 'active');
		$expected = array(
			'name' => array('A product with that name already exists'),
			'description' => array('Please enter the description for this product')
		);
		$result = $this->{$this->modelClass}->saveAll($data);
		$this->assertFalse($result);

		$this->assertEquals($expected, $this->{$this->modelClass}->validationErrors);
	}

/**
 * test validation A
 *
 * @dataProvider validationBDataProvider
 */
	public function testValidationB($data, $expected) {
		$save = array($data => 'fake');
		$this->assertFalse($this->{$this->modelClass}->save($save));

		$this->assertTrue(!empty($this->{$this->modelClass}->validationErrors[$data]), 'Validation not found');
		$result = $this->{$this->modelClass}->validationErrors[$data];
		$this->assertEquals($expected, $result);
	}

/**
 * validation A data provider
 *
 * @return array
 */
	public function validationBDataProvider() {
		return array(
			'image' => array(
				'shop_image_id',
				array('The selected image does not exist')
			),
			'product-type' => array(
				'shop_product_type_id',
				array('The selected product type does not exist')
			),
			'supplier' => array(
				'shop_supplier_id',
				array('The selected supplier does not exist')
			),
			'brand' => array(
				'shop_brand_id',
				array('The selected brand does not exist')
			),
			'active' => array(
				'active',
				array('Active should be boolean')
			),
			'available' => array(
				'available',
				array('Please enter a valid date')
			)
		);
	}

/**
 * test validation C
 *
 * @dataProvider validationCDataProvider
 */
	public function testValidationC($data) {
		$this->assertFalse($this->{$this->modelClass}->save($data));
		$this->assertTrue(empty($this->{$this->modelClass}->validationErrors[key($data)]), 'Validation failed but should pass');
	}

/**
 * validation C data provider
 *
 * @return array
 */
	public function validationCDataProvider() {
		return array(
			'name' => array(
				array('name' => 'some-cool-product')
			),
			'description' => array(
				array('description' => 'some cool description')
			),
			'image' => array(
				array('shop_image_id' => 'image-spotlight-multi-option')
			),
			'product-type' => array(
				array('shop_product_type_id' => 'general')
			),
			'supplier' => array(
				array('shop_supplier_id' => 'supplier-1')
			),
			'brand' => array(
				array('shop_brand_id' => 'inhouse')
			),
			'active' => array(
				array('active' => 1)
			),
			'inactive' => array(
				array('active' => 0)
			),
			'available-before' => array(
				array('available' => '2012-01-01 00:00:00')
			),
			'available-after' => array(
				array('available' => '2050-01-01 00:00:00')
			),
			'available-format' => array(
				array('available' => '2050/01/01 00:00:00')
			)
		);
	}

	public function testVirtualFields() {
		$id = 'active';

		$expected = '20.000';
		$result = $this->{$this->modelClass}->field('conversion_rate', array('ShopProduct.id' => $id));
		$this->assertEquals($expected, $result);

		$this->{$this->modelClass}->id = $id;
		$this->assertTrue((bool)$this->{$this->modelClass}->saveField('sales', 5));

		$expected = '100.000';
		$result = $this->{$this->modelClass}->field('conversion_rate', array('ShopProduct.id' => $id));
		$this->assertEquals($expected, $result);

		$expected = '2.000';
		$result = $this->{$this->modelClass}->find('first', array(
			'fields' => array('markup_amount'),
			'conditions' => array('ShopProduct.id' => $id),
			'joins' => array($this->{$this->modelClass}->autoJoinModel($this->{$this->modelClass}->ShopPrice))
		));
		$this->assertEquals($expected, $result[$this->modelClass]['markup_amount']);

		$expected = '20.000';
		$result = $this->{$this->modelClass}->find('first', array(
			'fields' => array('markup_percentage'),
			'conditions' => array('ShopProduct.id' => $id),
			'joins' => array($this->{$this->modelClass}->autoJoinModel($this->{$this->modelClass}->ShopPrice))
		));
		$this->assertEquals($expected, $result[$this->modelClass]['markup_percentage']);

		$expected = '16.667';
		$result = $this->{$this->modelClass}->find('first', array(
			'fields' => array('margin'),
			'conditions' => array('ShopProduct.id' => $id),
			'joins' => array($this->{$this->modelClass}->autoJoinModel($this->{$this->modelClass}->ShopPrice))
		));
		$this->assertEquals($expected, $result[$this->modelClass]['margin']);
	}

/**
 * test find search exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindSearchException() {
		$this->{$this->modelClass}->find('search');
	}

/**
 * test when no product is passed
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindProductException() {
		$this->{$this->modelClass}->find('product');
	}

/**
 * test find product shipping
 *
 * @dataProvider findProductShippingDataProvider
 */
	public function testFindProductShipping($data, $expected) {
		$results = $this->{$this->modelClass}->find('productShipping', $data);
		$this->assertEquals($expected, $results);
	}

/**
 * find product shipping data provider
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
 * test find product shipping
 *
 * @dataProvider findProductListShippingDataProvider
 */
	public function testFindProductListShipping($data, $expected) {
		App::uses('CakeSession', 'Model/Datasource');
		if (isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if (isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
		$results = $this->{$this->modelClass}->find('prodcutListShipping', array(
			'shop_list_id' => $data
		));
		$this->assertEquals($expected, $results);
		CakeSession::destroy();
	}

/**
 * find product shipping data provider
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
 * test deleting a product removes related data
 */
	public function testProductDeleteRelations() {
		$relations = array(
			'ShopBranchStock',
			'ShopCategoriesProduct',
			'ShopImagesProduct',
			'ShopSpotlight',
			'ShopProductsSpecial'
		);
		$this->{$this->modelClass}->Behaviors->disable('Trashable');

		foreach ($relations as $relation) {
			$this->{$this->modelClass}->{$relation}->Behaviors->disable('Trashable');
		}

		$this->assertTrue($this->{$this->modelClass}->delete('active'));
		$expected = array();

		foreach ($relations as $relation) {
			$result = $this->{$this->modelClass}->{$relation}->find('list', array(
				'conditions' => array(
					$relation . '.shop_product_id' => 'active'
				)
			));
			$this->assertEquals($expected, $result, sprintf('%s relation has not been cleared', $relation));
		}
	}

/**
 * test generating product codes
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
 * product code data provider
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
 * test find cost for list
 *
 * @return void
 */
	public function testFindCostForList() {
		CakeSession::write('Auth.User.id', 'bob');
		CakeSession::write('Shop.current_list', 'shop-list-bob-cart');

		$expected = 43;
		$result = $this->{$this->modelClass}->find('costForList');
		$this->assertEquals($expected, $result);

		$ShopListProduct = ClassRegistry::init('Shop.ShopListProduct');
		$ShopListProduct->id = 'shop-list-bob-cart-multi-option';
		$ShopListProduct->saveField('quantity', 25);

		$expected = 715;
		$result = $this->{$this->modelClass}->find('costForList');
		$this->assertEquals($expected, $result);

		ClassRegistry::init('Shop.ShopList')->delete('shop-list-bob-cart');

		$expected = 0;
		$result = $this->{$this->modelClass}->find('costForList');
		$this->assertEquals($expected, $result);
	}

/**
 * test things that make products inactive
 *
 * available data - active when
 * 	before now (rounded to latest minute)
 *
 * brand - active when:
 * 	not specified
 * 	brand active
 *
 * product type - active when:
 * 	not specified
 * 	product type active
 *
 * supplier - active when:
 * 	not specified
 * 	supplier active
 *
 * @todo categories - active when:
 * 	category active
 *
 */
	public function testThingsThatMakeProductsInactive() {
		$id = 'active';
		$Model = $this->{$this->modelClass};
		$Model->id = $id;
		$product = function($id) use($Model) {
			$product = $Model->find('product', $id);

			return !empty($product[$Model->alias][$Model->primaryKey]) &&
				$product[$Model->alias][$Model->primaryKey] == $id;
		};
		$this->assertTrue($product($id));

		$Model->saveField('available', date('Y-m-d H:i:s', time() + 10000));
		$this->assertFalse($product($id));
		$Model->saveField('available', date('Y-m-d H:i:s', time() - 10000));
		$this->assertTrue($product($id));

		$Model->saveField('active', 0);
		$this->assertFalse($product($id));
		$Model->saveField('active', 1);
		$this->assertTrue($product($id));

		$Model->ShopBrand->id = 'inhouse';
		$Model->ShopBrand->saveField('active', 0);
		$this->assertFalse($product($id));
		$Model->ShopBrand->deleteAll(array('ShopBrand.id' => 'inhouse'));
		$this->assertTrue($product($id));

		return;
		$Model->ShopProductType->id = 'shirts';
		$Model->ShopProductType->saveField('active', 0);
		$this->assertFalse($product($id));
		$Model->ShopProductType->deleteAll(array('ShopProductType.id' => 'shirts'));
		$this->assertTrue($product($id));

		$Model->ShopSupplier->id = 'supplier-1';
		$Model->ShopSupplier->saveField('active', 0);
		$this->assertFalse($product($id));
		$Model->ShopSupplier->deleteAll(array('ShopSupplier.id' => 'supplier-1'));
		$this->assertTrue($product($id));
		return;

		print_r($Model->ShopCategoriesProduct->ShopCategory->find('list', array('fields' => array('ShopCategory.id', 'ShopCategory.active'))));
		$Model->ShopCategoriesProduct->ShopCategory->id = 'active';
		$Model->ShopCategoriesProduct->ShopCategory->saveField('active', 0);
		print_r($Model->ShopCategoriesProduct->ShopCategory->find('list', array('fields' => array('ShopCategory.id', 'ShopCategory.active'))));
		$this->assertFalse($product($id));

		$Model->ShopCategoriesProduct->ShopCategory->saveField('active', 1);
		$this->assertTrue($product($id));
	}
}
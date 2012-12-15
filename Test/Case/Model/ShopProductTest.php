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
		'plugin.shop.shop_option_variant',
		'plugin.shop.shop_list',
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_product_variant',
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

		/*$expected = '2.000';
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
		$this->assertEquals($expected, $result[$this->modelClass]['margin']);*/
	}

/**
 * test find search exception
 *
 * @dataProvider findNoParamsExceptionDataProvider
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindNoParamsException($data) {
		$this->{$this->modelClass}->find($data);
	}

/**
 * find no params exception data provider
 *
 * @return array
 */
	public function findNoParamsExceptionDataProvider() {
		return array(
			array('search'),
			array('product')
		);
	}

/**
 * test find product shipping
 *
 * @dataProvider findProductShippingDataProvider
 */
	public function testFindProductShipping($data, $expected) {
		$this->skipIf(true);
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
		$this->skipIf(true);
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
		$this->skipIf(true);
		$relations = array(
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
 * test find cost for list
 *
 * @return void
 */
	public function testFindCostForList() {
		$this->skipIf(true);
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

	public function testProductPrice() {
		$ShopPrice = ClassRegistry::init('Shop.ShopPrice');
		$this->assertTrue($ShopPrice->deleteAll(array('id !=' => 0)));

		$expected = array(
			'variant-active-1' => array(
				'id' => null,
				'cost' => null,
				'selling' => null,
				'retail' => null,
			),
			'variant-active-2' => array(
				'id' => null,
				'cost' => null,
				'selling' => null,
				'retail' => null,
			),
			'variant-active-3' => array(
				'id' => null,
				'cost' => null,
				'selling' => null,
				'retail' => null,
			)
		);
		$result = $this->_getMainPrice();
		$this->assertEquals($expected, $result, 'Prices are not null');

		$ShopPrice->create();
		$saved = $ShopPrice->save(array(
			'model' => 'Shop.ShopProductVariant',
			'foreign_key' => 'variant-active-1',
			'cost' => 10,
			'selling' => 15,
			'retail' => 20
		));
		$this->assertTrue((bool)$saved, 'Could not save the price for the variant');

		$variantPriceOverride = $ShopPrice->id;
		$expected['variant-active-1'] = array(
			'id' => $variantPriceOverride,
			'cost' => 10,
			'selling' => 15,
			'retail' => 20
		);

		$result = $this->_getMainPrice();
		$this->assertEquals($expected, $result, 'variant specific price not correct');

		$ShopPrice->create();
		$saved = $ShopPrice->save(array(
			'model' => 'Shop.ShopProductVariant',
			'foreign_key' => 'variant-active-master',
			'cost' => 125,
			'selling' => 150,
			'retail' => 175
		));
		$this->assertTrue((bool)$saved, 'Could not save the price for the master variant');

		$expected = array_merge($expected, array(
			'variant-active-2' => array(
				'id' => null,
				'cost' => 125,
				'selling' => 150,
				'retail' => 175
			),
			'variant-active-3' => array(
				'id' => null,
				'cost' => 125,
				'selling' => 150,
				'retail' => 175
			)
		));
		$result = $this->_getMainPrice();
		$this->assertEquals($expected, $result, 'defaults from master price not correct');

		$ShopPrice->create();
		$saved = $ShopPrice->save(array(
			'model' => 'Shop.ShopOptionValue',
			'foreign_key' => 'option-size-large',
			'cost' => .5,
			'selling' => .5,
			'retail' => .5
		));
		$this->assertTrue((bool)$saved, 'Could not save the price for the option variant');

		$ShopPrice->create();
		$saved = $ShopPrice->save(array(
			'model' => 'Shop.ShopOptionValue',
			'foreign_key' => 'option-size-small',
			'cost' => .9,
			'selling' => .9,
			'retail' => .9
		));
		$this->assertTrue((bool)$saved, 'Could not save the price for the option variant');

		$expected = array_merge($expected, array(
			'variant-active-3' => array(
				'id' => null,
				'cost' => 125.5,
				'selling' => 150.5,
				'retail' => 175.5
			)
		));
		$result = $this->_getMainPrice();
		$this->assertEquals($expected, $result, 'option price not added');

		$this->assertTrue($ShopPrice->delete($variantPriceOverride), 'Could not delete option override');

		$expected = array_merge($expected, array(
			'variant-active-1' => array(
				'id' => null,
				'cost' => 125.9,
				'selling' => 150.9,
				'retail' => 175.9
			)
		));
		$result = $this->_getMainPrice();
		$this->assertEquals($expected, $result, 'option price not added');

	}

/**
 * test multioption pricing overrides
 *
 * 1 - large / red
 * 2 - medium / red
 * 3 - small / red
 * 4 - small / blue
 */
	public function testProductPriceMultiOption() {
		$ShopPrice = ClassRegistry::init('Shop.ShopPrice');
		$this->assertTrue($ShopPrice->deleteAll(array('id !=' => 0)));

		$expected = array(
			'variant-multi-option-1' => array(
				'id' => null,
				'cost' => null,
				'selling' => null,
				'retail' => null,
			),
			'variant-multi-option-2' => array(
				'id' => null,
				'cost' => null,
				'selling' => null,
				'retail' => null,
			),
			'variant-multi-option-3' => array(
				'id' => null,
				'cost' => null,
				'selling' => null,
				'retail' => null,
			),
			'variant-multi-option-4' => array(
				'id' => null,
				'cost' => null,
				'selling' => null,
				'retail' => null,
			)
		);
		$result = $this->_getMainPrice('multi-option');
		$this->assertEquals($expected, $result, 'Prices are not null');

		$ShopPrice->create();
		$saved = $ShopPrice->save(array(
			'model' => 'Shop.ShopOptionValue',
			'foreign_key' => 'option-colour-red',
			'cost' => 10,
			'selling' => 10,
			'retail' => 10
		));
		$this->assertTrue((bool)$saved, 'Could not add price for red option');

		$ShopPrice->create();
		$saved = $ShopPrice->save(array(
			'model' => 'Shop.ShopOptionValue',
			'foreign_key' => 'option-size-medium',
			'cost' => 5,
			'selling' => 5,
			'retail' => 5
		));
		$this->assertTrue((bool)$saved, 'Could not add price for size medium');


		$expected = array_merge($expected, array(
			'variant-multi-option-1' => array(
				'id' => null,
				'cost' => 10.0,
				'selling' => 10.0,
				'retail' => 10.0,
			),
			'variant-multi-option-2' => array(
				'id' => null,
				'cost' => 15.0,
				'selling' => 15.0,
				'retail' => 15.0,
			),
			'variant-multi-option-3' => array(
				'id' => null,
				'cost' => 10.0,
				'selling' => 10.0,
				'retail' => 10.0,
			)
		));
		$result = $this->_getMainPrice('multi-option');
		$this->assertEquals($expected, $result, 'Size option pricing not correct');

		$ShopPrice->create();
		$saved = $ShopPrice->save(array(
			'model' => 'Shop.ShopProductVariant',
			'foreign_key' => 'variant-multi-option-4',
			'cost' => 25,
			'selling' => 25,
			'retail' => 25
		));
		$this->assertTrue((bool)$saved, 'Could not variant price for variant 4');

		$expected = array_merge($expected, array(
			'variant-multi-option-4' => array(
				'id' => null,
				'cost' => 25,
				'selling' => 25,
				'retail' => 25,
			)
		));
	}

/**
 * get the price data for a product and test min / max
 *
 * @param string $id the product id
 *
 * @return array
 */
	protected function _getMainPrice($id = 'active') {
		$result = $this->{$this->modelClass}->find('product', $id);
		$prices = Hash::combine($result['ShopProductVariant'], '{n}.id', '{n}.ShopProductVariantPrice');

		$selling = Hash::extract($prices, '{s}.selling');
		if ($selling) {
			$this->assertEquals(min($selling), $result[$this->modelClass]['price_min']);
			$this->assertEquals(max($selling), $result[$this->modelClass]['price_max']);
		}

		return $prices;
	}
}
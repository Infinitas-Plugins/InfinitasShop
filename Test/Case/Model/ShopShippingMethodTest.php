<?php
App::uses('ShopShippingMethod', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopShippingMethod Test Case
 *
 */
class ShopShippingMethodTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_shipping_method',
		'plugin.shop.shop_shipping_method_value',
		'plugin.shop.shop_brand',
		'plugin.shop.shop_list',
		'plugin.shop.shop_order',
		'plugin.shop.shop_product',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_image',
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_price',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_category',
		'plugin.shop.shop_size',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_products_option_ignore',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_products_option_value_ignore',
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_special',
		'plugin.shop.shop_products_special',
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_supplier',

		'plugin.installer.plugin',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopShippingMethod = ClassRegistry::init('Shop.ShopShippingMethod');
		$this->modelClass = $this->ShopShippingMethod->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopShippingMethod);

		parent::tearDown();
	}

/**
 * @brief test find shipping
 *
 * @param  [type] $data     [description]
 * @param  [type] $expected [description]
 *
 * @dataProvider findShippingDataProvider
 */
	public function testFindShipping($data, $expected) {
		if(isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if(isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
		if(!empty($expected)) {
			$expected = array('ShopShippingMethod' => $expected);
		}
		$result = $this->{$this->modelClass}->find('shipping', array(
			'shop_shipping_method_id' => $data['shop_shipping_method_id']
		));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find shipping data provider
 *
 * @return array
 */
	public function findShippingDataProvider() {
		return array(
			'royal-mail-1st' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-1st'
				),
				array(
					'id' => 'royal-mail-1st',
					'name' => 'royal-mail-1st',
					'ShopShippingMethodValue' => array(
						array(
							'id' => 'royal-mail-1st-rate-1',
							'name' => 'royal-mail-1st-rate-1',
							'shop_shipping_method_id' => 'royal-mail-1st',
							'insurance' => array(
								array('limit' => 39.0, 'rate' => 0.0),
								array('limit' => 100, 'rate' => 1.0),
								array('limit' => 250.0, 'rate' => 2.25),
								array('limit' => 500.0, 'rate' => 3.5),
							),
							'rates' => array(
								array('limit' => 100.0, 'rate' => 1.58),
								array('limit' => 250.0, 'rate' => 1.96),
								array('limit' => 500.0, 'rate' => 2.48),
								array('limit' => 750.0, 'rate' => 3.05),
								array('limit' => 1000.0, 'rate' => 3.71),
							),
							'surcharge' => '0.00000',
							'delivery_time' => '48',
							'total_minimum' => '0.00000',
							'total_maximum' => '150.00000',
							'require_login' => false,
						)
					),
					'ShopSupplier' => array(
						'id' => 'mail-supplier',
						'name' => 'mail-supplier'
					)
				)
			),
			'from-cart' => array(
				array(
					'user_id' => 'bob',
					'shop_shipping_method_id' => null
				),
				array(
					'id' => 'royal-mail-1st',
					'name' => 'royal-mail-1st',
					'ShopShippingMethodValue' => array(
						array(
							'id' => 'royal-mail-1st-rate-1',
							'name' => 'royal-mail-1st-rate-1',
							'shop_shipping_method_id' => 'royal-mail-1st',
							'insurance' => array(
								array('limit' => 39.0, 'rate' => 0.0),
								array('limit' => 100, 'rate' => 1.0),
								array('limit' => 250.0, 'rate' => 2.25),
								array('limit' => 500.0, 'rate' => 3.5),
							),
							'rates' => array(
								array('limit' => 100.0, 'rate' => 1.58),
								array('limit' => 250.0, 'rate' => 1.96),
								array('limit' => 500.0, 'rate' => 2.48),
								array('limit' => 750.0, 'rate' => 3.05),
								array('limit' => 1000.0, 'rate' => 3.71),
							),
							'surcharge' => '0.00000',
							'delivery_time' => '48',
							'total_minimum' => '0.00000',
							'total_maximum' => '150.00000',
							'require_login' => false,
						)
					),
					'ShopSupplier' => array(
						'id' => 'mail-supplier',
						'name' => 'mail-supplier'
					)
				)
			),
			'bob-custom' => array(
				array(
					'user_id' => 'bob',
					'shop_shipping_method_id' => 'royal-mail-2nd'
				),
				array(
					'id' => 'royal-mail-2nd',
					'name' => 'royal-mail-2nd',
					'ShopShippingMethodValue' => array(
						array(
							'id' => 'royal-mail-2nd-rate-1',
							'name' => 'royal-mail-2nd-rate-1',
							'shop_shipping_method_id' => 'royal-mail-2nd',
							'insurance' => array(
							),
							'rates' => array(
								array('limit' => 100.0, 'rate' => 1.33),
								array('limit' => 250.0, 'rate' => 1.72),
								array('limit' => 500.0, 'rate' => 2.16),
								array('limit' => 750.0, 'rate' => 2.61),
								array('limit' => 1000.0, 'rate' => 3.15),
							),
							'total_minimum' => '0.00000',
							'total_maximum' => '150.00000',
							'surcharge' => '0.00000',
							'delivery_time' => '96',
							'require_login' => false
						),
						array(
							'id' => 'royal-mail-2nd-rate-2',
							'name' => 'royal-mail-2nd-rate-2',
							'shop_shipping_method_id' => 'royal-mail-2nd',
							'insurance' => array(
							),
							'rates' => array(
								array('limit' => 100.0, 'rate' => 5),
								array('limit' => 250.0, 'rate' => 10),
								array('limit' => 500.0, 'rate' => 15),
								array('limit' => 750.0, 'rate' => 20),
								array('limit' => 1000.0, 'rate' => 25),
							),
							'total_minimum' => '0.00000',
							'total_maximum' => '150.00000',
							'surcharge' => '0.00000',
							'delivery_time' => '240',
							'require_login' => true
						)
					),
					'ShopSupplier' => array(
						'id' => 'mail-supplier',
						'name' => 'mail-supplier'
					)
				)
			),
			'inactive' => array(
				array(
					'shop_shipping_method_id' => 'inactive'
				),
				array(
				)
			),
			'try-get-two' => array(
				array(
					'shop_shipping_method_id' => array(
						'royal-mail-1st',
						'royal-mail-2nd'
					)
				),
				array(
					'id' => 'royal-mail-1st',
					'name' => 'royal-mail-1st',
					'ShopShippingMethodValue' => array(
						array(
							'id' => 'royal-mail-1st-rate-1',
							'name' => 'royal-mail-1st-rate-1',
							'shop_shipping_method_id' => 'royal-mail-1st',
							'insurance' => array(
								array('limit' => 39.0, 'rate' => 0.0),
								array('limit' => 100, 'rate' => 1.0),
								array('limit' => 250.0, 'rate' => 2.25),
								array('limit' => 500.0, 'rate' => 3.5),
							),
							'rates' => array(
								array('limit' => 100.0, 'rate' => 1.58),
								array('limit' => 250.0, 'rate' => 1.96),
								array('limit' => 500.0, 'rate' => 2.48),
								array('limit' => 750.0, 'rate' => 3.05),
								array('limit' => 1000.0, 'rate' => 3.71),
							),
							'surcharge' => '0.00000',
							'delivery_time' => '48',
							'total_minimum' => '0.00000',
							'total_maximum' => '150.00000',
							'require_login' => false,
						)
					),
					'ShopSupplier' => array(
						'id' => 'mail-supplier',
						'name' => 'mail-supplier'
					)
				)
			),
		);
	}

/**
 * @brief test order of rates is correct
 */
	public function testGetShippingOrder() {
		$this->{$this->modelClass}->ShopShippingMethodValue->id = 'royal-mail-1st-rate-1';

		$expected = array(
			array('limit' => 120, 'rate' => 4.0),
			array('limit' => 150, 'rate' => 5.0),
			array('limit' => 200, 'rate' => 6.0),
		);
		$this->{$this->modelClass}->ShopShippingMethodValue->saveField('rates', '150:5,120:4,200:6');
		$result = $this->{$this->modelClass}->find('shipping', array(
			'shop_shipping_method_id' => $this->{$this->modelClass}->id
		));
		$this->assertEquals($expected, $result[$this->modelClass]['ShopShippingMethodValue'][0]['rates']);

		$this->{$this->modelClass}->ShopShippingMethodValue->saveField('insurance', '150:5,120:4,200:6');
		$result = $this->{$this->modelClass}->find('shipping', array(
			'shop_shipping_method_id' => $this->{$this->modelClass}->id
		));
		$this->assertEquals($expected, $result[$this->modelClass]['ShopShippingMethodValue'][0]['insurance']);
	}

/**
 * @brief test product
 *
 * @param  [type] $data     [description]
 * @param  [type] $expected [description]
 *
 * @dataProvider productDataProvider
 */
	public function testProduct($data, $expected) {
		$result = $this->{$this->modelClass}->find('product', array(
			'shop_shipping_method_id' => $data['shop_shipping_method_id'],
			'shop_product_id' => $data['product']
		));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief product data provider
 *
 * @return array
 */
	public function productDataProvider() {
		return array(
			'active-1st-class' => array(
				array(
					'product' => 'active',
					'shop_shipping_method_id' => 'royal-mail-1st'
				),
				array(
					'total' => 3.05,
					'shipping' => 3.05,
					'insurance_rate' => 0.0,
					'insurance_cover' => 39.0,
					'surcharge' => '0.00000'
				)
			),
			'active-2nd-class' => array(
				array(
					'product' => 'active',
					'shop_shipping_method_id' => 'royal-mail-2nd'
				),
				array(
					'total' => 2.61,
					'shipping' => 2.61,
					'insurance_rate' => 0.0,
					'insurance_cover' => 0.0,
					'surcharge' => '0.00000'
				)
			)
		);
	}

/**
 * @brief test product list
 *
 * @param  [type] $data     [description]
 * @param  [type] $expected [description]
 *
 * @dataProvider productListDataProvider
 */
	public function testProductList($data, $expected) {
		App::uses('CakeSession', 'Model/Datasource');
		if(isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if(isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
		$result = $this->{$this->modelClass}->find('productList', array(
			'shop_shipping_method_id' => $data['shop_shipping_method_id'],
			'shop_list_id' => $data['shop_list_id']
		));
		$this->assertEquals($expected, $result);

		if(!empty($data['shop_shipping_method_value_id'])) {
			$this->{$this->modelClass}->ShopShippingMethodValue->id = $data['shop_shipping_method_value_id'];
			$this->{$this->modelClass}->ShopShippingMethodValue->saveField('surcharge', 25);

			$expected['total'] += 25;
			$expected['surcharge'] = 25;
			$result = $this->{$this->modelClass}->find('productList', array(
				'shop_shipping_method_id' => $data['shop_shipping_method_id'],
				'shop_list_id' => $data['shop_list_id']
			));
			$this->assertEquals($expected, $result);
		}

		CakeSession::destroy();
	}

/**
 * @brief product list data provider
 *
 * @return array
 */
	public function productListDataProvider() {
		return array(
			'bob-list-from-session' => array(
				array(
					'shop_shipping_method_id' => null,
					'shop_list_id' => null,
					'user_id' => 'bob'
				),
				array(
					'total' => 4.71,
					'shipping' => 3.71,
					'insurance_rate' => 1.0,
					'insurance_cover' => 100.0,
					'surcharge' => '0.00000'
				)
			),
			'shop-list-bob-cart' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-2nd',
					'shop_shipping_method_value_id' => 'royal-mail-2nd-rate-1',
					'shop_list_id' => 'shop-list-bob-cart',
					'user_id' => 'bob'
				),
				array(
					'total' => 3.15,
					'shipping' => 3.15,
					'insurance_rate' => 0.0,
					'insurance_cover' => 0.0,
					'surcharge' => '0.00000'
				)
			),
			'shop-list-bob-wish' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-2nd',
					'shop_shipping_method_value_id' => 'royal-mail-2nd-rate-1',
					'shop_list_id' => 'shop-list-bob-wish',
					'user_id' => 'bob'
				),
				array(
					'total' => 1.33,
					'shipping' => 1.33,
					'insurance_rate' => 0.0,
					'insurance_cover' => 0.0,
					'surcharge' => '0.00000'
				)
			)
		);
	}

}

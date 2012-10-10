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
		'plugin.shop.shop_spotlight',
		
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
					'total_minimum' => 0,
					'total_maximum' => 150,
					'surcharge' => '0.00000',
					'delivery_time' => '48'
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
					'total_minimum' => 0,
					'total_maximum' => 150,
					'surcharge' => '0.00000',
					'delivery_time' => '48'
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
					'insurance' => array(
					),
					'rates' => array(
						array('limit' => 100.0, 'rate' => 1.33),
						array('limit' => 250.0, 'rate' => 1.72),
						array('limit' => 500.0, 'rate' => 2.16),
						array('limit' => 750.0, 'rate' => 2.61),
						array('limit' => 1000.0, 'rate' => 3.15),
					),
					'total_minimum' => 0,
					'total_maximum' => 150,
					'surcharge' => '0.00000',
					'delivery_time' => '96'
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
					'total_minimum' => 0,
					'total_maximum' => 150,
					'surcharge' => '0.00000',
					'delivery_time' => '48'
				)
			),
		);
	}

/**
 * @brief test order of rates is correct
 */
	public function testGetShippingOrder() {
		$this->{$this->modelClass}->id = 'royal-mail-1st';

		$expected = array(
			array('limit' => 120, 'rate' => 4.0),
			array('limit' => 150, 'rate' => 5.0),
			array('limit' => 200, 'rate' => 6.0),
		);
		$this->{$this->modelClass}->saveField('rates', '150:5,120:4,200:6');
		$result = $this->{$this->modelClass}->find('shipping', array(
			'shop_shipping_method_id' => $this->{$this->modelClass}->id
		));
		$this->assertEquals($expected, $result[$this->modelClass]['rates']);

		$expected = array(
			array('limit' => 120, 'rate' => 4.0),
			array('limit' => 150, 'rate' => 5.0),
			array('limit' => 200, 'rate' => 6.0),
		);
		$this->{$this->modelClass}->saveField('insurance', '150:5,120:4,200:6');
		$result = $this->{$this->modelClass}->find('shipping', array(
			'shop_shipping_method_id' => $this->{$this->modelClass}->id
		));
		$this->assertEquals($expected, $result[$this->modelClass]['rates']);
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
					'insurance_cover' => 39.0
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
					'insurance_cover' => 0.0
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
					'insurance_cover' => 100.0
				)
			),
			'shop-list-bob-cart' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-2nd',
					'shop_list_id' => 'shop-list-bob-cart',
					'user_id' => 'bob'
				),
				array(
					'total' => 3.15,
					'shipping' => 3.15,
					'insurance_rate' => 0.0,
					'insurance_cover' => 0.0
				)
			),
			'shop-list-bob-wish' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-2nd',
					'shop_list_id' => 'shop-list-bob-wish',
					'user_id' => 'bob'
				),
				array(
					'total' => 1.33,
					'shipping' => 1.33,
					'insurance_rate' => 0.0,
					'insurance_cover' => 0.0
				)
			)
		);
	}

/**
 * @brief test min settings
 */
	public function testMinimum() {
		$findConditions = array(
			'shop_shipping_method_id' => 'royal-mail-2nd',
			'shop_list_id' => 'shop-list-bob-cart'
		);
		$this->{$this->modelClass}->id = $findConditions['shop_shipping_method_id'];
		$this->assertTrue((bool)$this->{$this->modelClass}->saveField('total_minimum', null));

		try {
			$result = $this->{$this->modelClass}->find('productList', $findConditions);
			$this->assertTrue(is_array($result));
		} catch(Exception $e) {
			$this->assertTrue(false, 'Was not able to get a valid shipping total');
		}

		$this->assertTrue((bool)$this->{$this->modelClass}->saveField('total_minimum', 1));

		try {
			$result = $this->{$this->modelClass}->find('productList', $findConditions);
			$this->assertTrue(is_array($result));
		} catch(Exception $e) {
			$this->assertTrue(false, 'Was not able to get a valid shipping total');
		}

		$this->assertTrue((bool)$this->{$this->modelClass}->saveField('total_minimum', 250));

		try {
			$result = $this->{$this->modelClass}->find('productList', $findConditions);
			$this->assertTrue(false, 'No Exception was thrown');
		} catch(Exception $e) {
			if(get_class($e) == 'ShopShippingMethodMinimumException') {
				$this->assertTrue(true);
			} else {
				throw $e;
			}
		}
	}

/**
 * @brief test max settings
 */
	public function testMaximum() {
		$findConditions = array(
			'shop_shipping_method_id' => 'royal-mail-2nd',
			'shop_list_id' => 'shop-list-bob-cart'
		);
		$this->{$this->modelClass}->id = $findConditions['shop_shipping_method_id'];
		$this->assertTrue((bool)$this->{$this->modelClass}->saveField('total_maximum', null));

		try {
			$result = $this->{$this->modelClass}->find('productList', $findConditions);
			$this->assertTrue(is_array($result));
		} catch(Exception $e) {
			$this->assertTrue(false, 'Was not able to get a valid shipping total');
		}

		$this->assertTrue((bool)$this->{$this->modelClass}->saveField('total_maximum', 500));

		try {
			$result = $this->{$this->modelClass}->find('productList', $findConditions);
			$this->assertTrue(is_array($result));
		} catch(Exception $e) {
			$this->assertTrue(false, 'Was not able to get a valid shipping total');
		}

		$this->assertTrue((bool)$this->{$this->modelClass}->saveField('total_maximum', 1));

		try {
			$result = $this->{$this->modelClass}->find('productList', $findConditions);
			$this->assertTrue(false, 'No Exception was thrown');
		} catch(Exception $e) {
			if(get_class($e) == 'ShopShippingMethodMaximumException') {
				$this->assertTrue(true);
			} else {
				throw $e;
			}
		}
	}

}

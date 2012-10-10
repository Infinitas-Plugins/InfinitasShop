<?php
App::uses('ShopShippingMethod', 'Shop.Model');
App::uses('ShopShippingCostLib', 'Shop.Lib');

App::uses('CakeSession', 'Model/Datasource');

/**
 * @brief ShopShippingCostLib test case
 */
class ShopShippingCostLibTest extends CakeTestCase {
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
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		CakeSession::destroy();
		parent::tearDown();
	}

/**
 * @brief test get shipping exception
 * 
 * @param  [type] $data [description]
 * @return [type]       [description]
 *
 * @expectedException CakeException
 *
 * @dataProvider getShippingExceptionDataProvider
 */
	public function testGetShippingException($data) {
		ShopShippingCostLib::getShipping($data);
	}

/**
 * @brief get shipping exception data provider
 * 
 * @return array
 */
	public function getShippingExceptionDataProvider() {
		return array(
			array(null),
			array('fake'),
		);
	}

/**
 * @brief test get shipping
 * 
 * @param  [type] $data     [description]
 * @param  [type] $expected [description]
 * 
 * @dataProvider getShippingDataProvider
 */
	public function testGetShipping($data, $expected) {
		if(isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if(isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
		if(!empty($expected)) {
			$expected = array('ShopShippingMethod' => $expected);
		}

		$result = ShopShippingCostLib::getShipping($data['shop_shipping_method_id']);
		$this->assertEquals($expected, $result);
	}

/**
 * get shipping data provider 
 * 
 * @return array
 */
	public function getShippingDataProvider() {
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
				)
			),
		);
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
		$result = ShopShippingCostLib::product($data['product'], $data['shop_shipping_method_id']);
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
}
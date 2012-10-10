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
		$result = $this->{$this->modelClass}->find('shipping', $data['shop_shipping_method_id']);
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
		$result = $this->{$this->modelClass}->find('shipping', $this->{$this->modelClass}->id);
		$this->assertEquals($expected, $result[$this->modelClass]['rates']);

		$expected = array(
			array('limit' => 120, 'rate' => 4.0),
			array('limit' => 150, 'rate' => 5.0),
			array('limit' => 200, 'rate' => 6.0),
		);
		$this->{$this->modelClass}->saveField('insurance', '150:5,120:4,200:6');
		$result = $this->{$this->modelClass}->find('shipping', $this->{$this->modelClass}->id);
		$this->assertEquals($expected, $result[$this->modelClass]['rates']);
	}

}

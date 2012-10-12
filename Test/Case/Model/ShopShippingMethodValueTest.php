<?php
App::uses('ShopShippingMethodValue', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopShippingMethodValue Test Case
 *
 */
class ShopShippingMethodValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_shipping_method_value',
		'plugin.shop.shop_shipping_method'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopShippingMethodValue = ClassRegistry::init('Shop.ShopShippingMethodValue');
		$this->modelClass = $this->ShopShippingMethodValue->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopShippingMethodValue);
		CakeSession::destroy();
		parent::tearDown();
	}

/**
 * @brief test find values excepton
 * 
 * @expectedException InvalidArgumentException
 */
	public function testFindValuesException() {
		$this->{$this->modelClass}->find('values');
	}

/**
 * @brief test find values
 *
 * @dataProvider findValuesDataProvider
 */
	public function testFindValues($data, $expected) {
		if(isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if(isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}

		$result = $this->{$this->modelClass}->find('values', array(
			'shop_shipping_method_id' => $data['shop_shipping_method_id']
		));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find values data provider
 * 
 * @return array
 */
	public function findValuesDataProvider() {
		return array(
			'empty' => array(
				array(
					'shop_shipping_method_id' => 'not-valid'
				),
				array()
			),
			'royal-mail-1st' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-1st'
				),
				array(
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
				)
			),
			'royal-mail-2nd' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-2nd'
				),
				array(
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
					)
				)
			),
			'royal-mail-2nd-logged-in' => array(
				array(
					'shop_shipping_method_id' => 'royal-mail-2nd',
					'user_id' => 'bob'
				),
				array(
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
				)
			)
		);
	}

/**
 * @brief test find values with order value
 */
	public function testFindValuesOrderValue() {
		$this->{$this->modelClass}->id = 'royal-mail-1st-rate-1';
		$this->{$this->modelClass}->saveField('total_minimum', 50);
		$this->{$this->modelClass}->saveField('total_maximum', 100);

		$expected = $this->{$this->modelClass}->find('values', array(
			'shop_shipping_method_id' => 'royal-mail-1st'
		));

		$this->assertEmpty($this->{$this->modelClass}->find('values', array(
			'shop_shipping_method_id' => 'royal-mail-1st',
			'order_value' => 49.99999
		)));

		$this->assertEmpty($this->{$this->modelClass}->find('values', array(
			'shop_shipping_method_id' => 'royal-mail-1st',
			'order_value' => 100.00001
		)));

		$result = $this->{$this->modelClass}->find('values', array(
			'shop_shipping_method_id' => 'royal-mail-1st',
			'order_value' => 50.00000
		));
		$this->assertEquals($expected, $result);

		$result = $this->{$this->modelClass}->find('values', array(
			'shop_shipping_method_id' => 'royal-mail-1st',
			'order_value' => 100.00000
		));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief test save
 * 
 * @param  [type] $data     [description]
 * @param  [type] $expected [description]
 * 
 * @dataProvider saveDataProvider
 */
	public function testSave($data, $expected) {
		$result = $this->{$this->modelClass}->save($data);
		$this->assertTrue((bool)$result);

		$result = $this->{$this->modelClass}->find('first', array(
			'conditions' => array(
				$this->modelClass . '.id' => $this->{$this->modelClass}->id
			)
		));
		unset($result[$this->modelClass]['id'], $result[$this->modelClass]['created'], $result[$this->modelClass]['modified']);
		$this->assertEquals($expected, current($result));
	}

/**
 * @brief save data provider
 * @return array
 */
	public function saveDataProvider() {
		return array(
			'normal-order' => array(
				array(
					'name' => 'royal-mail-1st-rate-1',
					'shop_shipping_method_id' => 'royal-mail-1st',
					'active' => 1,
					'insurance' => array(
						array('limit' => 10.0, 'rate' => 1.0),
						array('limit' => 30, 'rate' => 3.0),
						array('limit' => 20.00, 'rate' => 2.0),
					),
					'rates' => array(
						array('limit' => 10.0, 'rate' => 1.0),
						array('limit' => 30.0, 'rate' => 3.0),
						array('limit' => 20.0, 'rate' => 2.0),
					),
					'surcharge' => 0,
					'delivery_time' => 48,
					'total_minimum' => 0,
					'total_maximum' => 150,
					'require_login' => 0,
				),
				array(
					'name' => 'royal-mail-1st-rate-1',
					'shop_shipping_method_id' => 'royal-mail-1st',
					'active' => true,
					'insurance' => array(
						array('limit' => 10.0, 'rate' => 1.0),
						array('limit' => 20.0, 'rate' => 2.0),
						array('limit' => 30.0, 'rate' => 3.0),
					),
					'rates' => array(
						array('limit' => 10.0, 'rate' => 1.0),
						array('limit' => 20.0, 'rate' => 2.0),
						array('limit' => 30.0, 'rate' => 3.0),
					),
					'surcharge' => '0.00000',
					'delivery_time' => '48',
					'total_minimum' => '0.00000',
					'total_maximum' => '150.00000',
					'require_login' => false,
				)
			)
		);
	}

}

<?php
App::uses('ShopPaymentMethod', 'Shop.Model');

/**
 * ShopPaymentMethod Test Case
 *
 */
class ShopPaymentMethodTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_payment_method',
		'plugin.infinitas_payments.infinitas_payment_method',
		'plugin.shop.shop_list',
		'plugin.shop.shop_order'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopPaymentMethod');
		CakeSession::destroy();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Model);

		parent::tearDown();
		CakeSession::destroy();
	}

/**
 * test find available exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindAvailableException() {
		$this->Model->find('available');
	}

/**
 * test find available for logged in users
 */
	public function testFindAvailableLoggedIn() {
		$expected = array('cc' => 'cc');
		$result = $this->Model->find('available', array(
			'order_value' => 99
		));
		$this->assertEquals($expected, $result);

		CakeSession::write('Auth.User', array(
			'id' => 'bob'
		));
		$expected = array('cc' => 'cc', 'login' => 'login');
		$result = $this->Model->find('available', array(
			'order_value' => 99
		));
		$this->assertEquals($expected, $result);

		$expected = array('cc' => 'cc');
		$result = $this->Model->find('available', array(
			'order_value' => 100.1
		));
		$this->assertEquals($expected, $result);
	}

/**
 * test find available
 *
 * @dataProvider findAvailableDataProvider
 */
	public function testFindAvailable($data, $expected) {
		$result = $this->Model->find('available', array(
			'order_value' => $data
		));
		$this->assertEquals($expected, $result);
	}

	public function findAvailableDataProvider() {
		return array(
			'no-min' => array(
				0,
				array(
					'cc' => 'cc',
				)
			),
			'no-max' => array(
				99999,
				array(
					'cc' => 'cc',
				)
			),
			'almost' => array(
				499.99999,
				array(
					'cc' => 'cc',
				)
			),
			'min reached' => array(
				500,
				array(
					'cc' => 'cc',
					'paypal' => 'paypal'
				)
			),
			'middle ground' => array(
				550,
				array(
					'cc' => 'cc',
					'paypal' => 'paypal'
				)
			),
			'max reached' => array(
				600,
				array(
					'cc' => 'cc',
					'paypal' => 'paypal'
				)
			)
		);
	}

}
<?php
App::uses('ShopCurrency', 'Shop.Model');
App::uses('ShopCurrencyLib', 'Shop.Lib');
class ShopCurrencyLibTest extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_currency',
		'plugin.shop.shop_payment_method_api'
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
 * @brief test set session exception
 * 
 * @expectedException InvalidArgumentException
 */
	public function testSetSessionException() {
		ShopCurrencyLib::setSession('gb');
	}

/**
 * @brief test get currency
 */
	public function testGetCurrency() {
		$expected = ShopCurrencyLib::getCurrency(Configure::read('Shop.currency'));
		$result = ShopCurrencyLib::getCurrency();
		$this->assertEquals($expected, $result);

		$expected = 'GBP';
		CakeSession::write('Shop.currency', $expected);
		$result = ShopCurrencyLib::getCurrency();
		$this->assertEquals($expected, $result);

		$expected = 'USD';
		CakeSession::write('Shop.currency', $expected);
		$result = ShopCurrencyLib::getCurrency();
		$this->assertEquals($expected, $result);
	}

/**
 * @brief test set currency
 * 
 * @dataProvider setCurrencyDataProvider
 */
	public function testSetCurrency($data, $expected) {
		ShopCurrencyLib::setCurrency($data);
		$result = CakeNumber::currency(1000, ShopCurrencyLib::getCurrency());
		$this->assertEquals($expected, $result);
		CakeSession::destroy();
	}

/**
 * @brief set currency data provider
 */
	public function setCurrencyDataProvider() {
		return array(
			'null' => array(null, '£1,000.00'),
			'gbp' => array('gbp', '£1,000.00'),
			'usd' => array('usd', '$1,000.00'),
			'eur' => array('eur', '€1.000,000'),
		);
	}

/**
 * @brief test set currency invalid
 *
 * @expectedException CakeException
 */
	public function testSetCurrencyInvalid() {
		ShopCurrencyLib::setCurrency('invalid');
	}

/**
 * @brief test convert
 *
 * @dataProvider convertDataProvider
 */
	public function testConvert($data, $expected) {
		$result = ShopCurrencyLib::convert(1000, $data);
		$this->assertEquals($expected, $result);
		CakeSession::destroy();

		ShopCurrencyLib::setCurrency($data);
		$result = ShopCurrencyLib::convert(1000);
		$this->assertEquals($expected, $result);
		CakeSession::destroy();
	}

/**
 * @brief convert data provider
 */
	public function convertDataProvider() {
		return array(
			array('gbp', 1000),
			array('GbP', 1000),
			array('gbp', 1000),
			array('usd', 1599.9),
			array('eur', 1242.5),
		);
	}

/**
 * @brief test fetch update
 */
	public function testFetchUpdate() {
		$result = ShopCurrencyLib::fetchUpdate('GBP', 'USD');
		$this->assertTrue($result > 1);

		$result = ShopCurrencyLib::fetchUpdate('USD', 'GBP');
		$this->assertTrue($result < 1);

		$result = ShopCurrencyLib::fetchUpdate('USD', 'FAKE');
		$this->assertFalse($result);
	}
}